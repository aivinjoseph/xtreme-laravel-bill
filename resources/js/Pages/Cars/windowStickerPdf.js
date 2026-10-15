import { PDFDocument, StandardFonts, rgb } from 'pdf-lib';
import { removeBackground } from '@imgly/background-removal';
import qrcode from 'qrcode-generator';

const PAGE_WIDTH = 612;
const PAGE_HEIGHT = 792;
const RED = rgb(0.60, 0.05, 0.05);
const DARK = rgb(0.07, 0.09, 0.13);
const MUTED = rgb(0.29, 0.33, 0.39);
const LIGHT_BORDER = rgb(0.82, 0.84, 0.87);
const LIGHT_BACKGROUND = rgb(0.96, 0.97, 0.98);

const cutoutCache = new Map();

const cleanValue = (value) => {
    if (value === null || value === undefined) return '';

    const normalized = String(value).trim();
    return new Set(['', 'null', 'undefined', 'n/a', 'na', '-', '--']).has(normalized.toLowerCase())
        ? ''
        : normalized;
};

const formatPrice = (value) => {
    const number = Number(cleanValue(value));
    if (!Number.isFinite(number)) return '';

    return new Intl.NumberFormat('en-CA', {
        style: 'currency',
        currency: 'CAD',
        maximumFractionDigits: 0,
    }).format(number);
};

const resolveSameOriginUrl = (source) => {
    const url = new URL(source, window.location.origin);
    if (url.origin !== window.location.origin) {
        throw new Error('Window Sticker images must be served by this application.');
    }

    return url.href;
};

const featuredImageUrl = (car) => {
    const images = Array.isArray(car?.images)
        ? car.images.filter((image) => cleanValue(image))
        : [];
    const selectedIndex = Number(car?.featured_image_index);
    const selectedImage = Array.isArray(car?.images) ? car.images[selectedIndex] : '';

    const source = cleanValue(selectedImage) || images[0] || '';
    if (!source) throw new Error('The selected vehicle has no featured image.');

    return resolveSameOriginUrl(source);
};

const fetchBlob = async (url) => {
    const response = await fetch(url, { credentials: 'same-origin' });
    if (!response.ok) throw new Error(`Image request failed with status ${response.status}.`);
    return response.blob();
};

const imageBlobToPng = async (blob) => {
    const bitmap = await createImageBitmap(blob);
    const canvas = document.createElement('canvas');
    canvas.width = bitmap.width;
    canvas.height = bitmap.height;
    canvas.getContext('2d').drawImage(bitmap, 0, 0);
    bitmap.close();

    const png = await new Promise((resolve, reject) => {
        canvas.toBlob((value) => value ? resolve(value) : reject(new Error('Image conversion failed.')), 'image/png');
    });

    return png;
};

const getCutout = async (sourceUrl, sourceBlob, onProgress) => {
    if (cutoutCache.has(sourceUrl)) return cutoutCache.get(sourceUrl);

    const existing = removeBackground(sourceBlob, {
        model: 'isnet_fp16',
        device: 'cpu',
        output: { type: 'foreground', format: 'image/png' },
        progress: (key, current, total) => {
            if (total > 0) onProgress(Math.min(99, Math.round((current / total) * 100)), key);
        },
    });

    cutoutCache.set(sourceUrl, existing);

    try {
        return await existing;
    } catch (error) {
        cutoutCache.delete(sourceUrl);
        throw error;
    }
};

const featuredTitle = (car) => {
    const words = [];
    const seen = new Set();

    [car?.year, car?.make, car?.model, car?.trim].forEach((value) => {
        cleanValue(value).split(/\s+/).forEach((word) => {
            const normalized = word.toLowerCase();
            if (normalized && !seen.has(normalized)) {
                seen.add(normalized);
                words.push(word);
            }
        });
    });

    return words.join(' ') || cleanValue(car?.name) || 'Vehicle';
};

const mileageText = (car) => [cleanValue(car?.mileage), cleanValue(car?.mileage_unit).toUpperCase()]
    .filter(Boolean)
    .join(' ');

const specifications = (car) => [
    ['VIN', cleanValue(car?.vin)],
    ['Mileage', mileageText(car)],
    ['Exterior Colour', cleanValue(car?.ext_color)],
    ['Interior Colour', cleanValue(car?.int_color)],
    ['Engine', cleanValue(car?.engine)],
    ['Transmission', cleanValue(car?.transmission)],
    ['Fuel', cleanValue(car?.fuel)],
    ['Drive', cleanValue(car?.drive)],
    ['Body Style', cleanValue(car?.body_type)],
    ['Doors', cleanValue(car?.door)],
    ['Seats', cleanValue(car?.seats)],
    ['City Fuel Consumption', cleanValue(car?.city_fuel_consumption) ? `${cleanValue(car.city_fuel_consumption)} / 100 km` : ''],
    ['Highway Fuel Consumption', cleanValue(car?.highway_fuel_consumption) ? `${cleanValue(car.highway_fuel_consumption)} / 100 km` : ''],
].filter(([, value]) => value);

const features = (car) => (Array.isArray(car?.features) ? car.features : [])
    .map((feature) => cleanValue(typeof feature === 'object' ? feature.name : feature))
    .filter(Boolean)
    .slice(0, 12);

const websiteLabel = (url) => {
    if (!url) return '';

    try {
        return new URL(url).host;
    } catch {
        return String(url).replace(/^https?:\/\//, '').replace(/\/$/, '');
    }
};

const fitText = (font, value, maxWidth, size, minimum = 5) => {
    let result = cleanValue(value);
    let currentSize = size;

    while (currentSize > minimum && font.widthOfTextAtSize(result, currentSize) > maxWidth) {
        currentSize -= 0.25;
    }

    if (font.widthOfTextAtSize(result, currentSize) <= maxWidth) return [result, currentSize];

    while (result.length > 1 && font.widthOfTextAtSize(`${result}...`, currentSize) > maxWidth) {
        result = result.slice(0, -1);
    }

    return [`${result}...`, currentSize];
};

const wrapText = (font, value, maxWidth, size) => {
    const words = cleanValue(value).split(/\s+/).filter(Boolean);
    if (!words.length) return [];

    const lines = [];
    let line = '';
    words.forEach((word) => {
        if (font.widthOfTextAtSize(word, size) > maxWidth) {
            if (line) lines.push(line);
            line = '';

            for (let index = 0; index < word.length; index += 1) {
                const candidate = `${line}${word[index]}`;
                if (line && font.widthOfTextAtSize(candidate, size) > maxWidth) {
                    lines.push(line);
                    line = word[index];
                } else {
                    line = candidate;
                }
            }
            return;
        }

        const candidate = line ? `${line} ${word}` : word;
        if (line && font.widthOfTextAtSize(candidate, size) > maxWidth) {
            lines.push(line);
            line = word;
        } else {
            line = candidate;
        }
    });
    if (line) lines.push(line);

    return lines;
};

const drawWrappedTextFit = (page, font, value, x, y, maxWidth, size, options = {}) => {
    const minimum = options.minimum ?? 5;
    const maxLines = options.maxLines ?? 2;
    let fittedSize = size;
    let lines = wrapText(font, value, maxWidth, fittedSize);

    while (fittedSize > minimum && lines.length > maxLines) {
        fittedSize -= 0.25;
        lines = wrapText(font, value, maxWidth, fittedSize);
    }

    lines.forEach((line, index) => {
        page.drawText(line, {
            x,
            y: y - index * (options.lineHeight ?? fittedSize + 1),
            size: fittedSize,
            font,
            color: options.color ?? DARK,
            maxWidth,
        });
    });
};

const drawTextFit = (page, font, value, x, y, maxWidth, size, options = {}) => {
    const [text, fittedSize] = fitText(font, value, maxWidth, size, options.minimum ?? 5);
    if (!text) return;

    page.drawText(text, {
        x,
        y,
        size: fittedSize,
        font,
        color: options.color ?? DARK,
        maxWidth,
    });
};

const drawCenteredTextFit = (page, font, value, x, y, width, size, options = {}) => {
    const [text, fittedSize] = fitText(font, value, width, size, options.minimum ?? 5);
    if (!text) return;

    page.drawText(text, {
        x: x + (width - font.widthOfTextAtSize(text, fittedSize)) / 2,
        y,
        size: fittedSize,
        font,
        color: options.color ?? DARK,
    });
};

const drawSectionHeading = (page, font, text, y) => {
    page.drawText(text.toUpperCase(), { x: 28, y, size: 8.5, font, color: RED });
    page.drawLine({ start: { x: 28, y: y - 4 }, end: { x: 584, y: y - 4 }, thickness: 0.6, color: LIGHT_BORDER });
};

const drawQrCode = async (url) => {
    if (!url) return null;

    const code = qrcode(0, 'H');
    code.addData(url);
    code.make();
    const response = await fetch(code.createDataURL(5, 8));
    return (await imageBlobToPng(await response.blob())).arrayBuffer();
};

const drawImageFit = (page, image, x, y, width, height, options = {}) => {
    const scale = Math.min(width / image.width, height / image.height);
    const drawWidth = image.width * scale;
    const drawHeight = image.height * scale;

    page.drawImage(image, {
        x: x + (width - drawWidth) / 2,
        y: y + (height - drawHeight) / 2,
        width: drawWidth,
        height: drawHeight,
        opacity: options.opacity,
    });
};

const embedPng = async (pdf, blob) => pdf.embedPng(await (await imageBlobToPng(blob)).arrayBuffer());

const buildPdf = async (data, imageBlob, logoBlob, qrBytes, branded) => {
    const pdf = await PDFDocument.create();
    const page = pdf.addPage([PAGE_WIDTH, PAGE_HEIGHT]);
    const regular = await pdf.embedFont(StandardFonts.Helvetica);
    const bold = await pdf.embedFont(StandardFonts.HelveticaBold);
    const logo = logoBlob ? await embedPng(pdf, logoBlob) : null;
    const vehicleImage = imageBlob ? await embedPng(pdf, imageBlob) : null;
    const qrImage = qrBytes ? await pdf.embedPng(qrBytes) : null;
    const car = data.car ?? {};
    const dealer = data.dealer ?? {};

    page.drawRectangle({ x: 0, y: 0, width: PAGE_WIDTH, height: PAGE_HEIGHT, color: rgb(1, 1, 1) });

    if (logo) drawImageFit(page, logo, 28, 724, 170, 38);
    drawTextFit(page, bold, dealer.name, 210, 747, 370, 11, { color: RED });
    drawWrappedTextFit(page, regular, dealer.address, 210, 733, 370, 8, { color: MUTED, lineHeight: 9, minimum: 3.5 });
    page.drawLine({ start: { x: 28, y: 716 }, end: { x: 584, y: 716 }, thickness: 2.2, color: RED });

    page.drawText('PRE-OWNED VEHICLE', { x: 28, y: 689, size: 7.5, font: bold, color: RED });
    drawTextFit(page, bold, featuredTitle(car), 28, 666, 405, 22, { minimum: 12 });
    drawTextFit(page, bold, formatPrice(car.price), 450, 666, 134, 20, { color: RED, minimum: 11 });

    page.drawRectangle({ x: 28, y: 453, width: 556, height: 192, color: LIGHT_BACKGROUND, borderColor: LIGHT_BORDER, borderWidth: 0.8 });
    if (logo) drawImageFit(page, logo, 145, 496, 322, 100, { opacity: 0.18 });
    page.drawEllipse({ x: 306, y: 465, xScale: 164, yScale: 6, color: rgb(0.15, 0.17, 0.20), opacity: 0.12 });
    if (vehicleImage) drawImageFit(page, vehicleImage, 52, 463, 508, 174);

    let y = 432;
    drawSectionHeading(page, bold, 'Vehicle Details', y);
    y -= 22;
    const specs = specifications(car);
    const columnWidth = 270;
    const rowHeight = 17;
    specs.forEach(([label, value], index) => {
        const column = index % 2;
        const row = Math.floor(index / 2);
        const x = 28 + column * 286;
        const rowY = y - row * rowHeight;
        page.drawLine({ start: { x, y: rowY - 4 }, end: { x: x + columnWidth, y: rowY - 4 }, thickness: 0.35, color: LIGHT_BORDER });
        page.drawText(label, { x, y: rowY, size: 6.7, font: bold, color: MUTED });
        drawTextFit(page, regular, value, x + 94, rowY, columnWidth - 94, 7.4, { minimum: 5.2 });
    });

    y -= Math.ceil(specs.length / 2) * rowHeight + 20;
    drawSectionHeading(page, bold, 'Features', y);
    y -= 19;
    features(car).forEach((feature, index) => {
        const column = index % 3;
        const row = Math.floor(index / 3);
        const x = 28 + column * 186;
        const rowY = y - row * 15;
        page.drawLine({ start: { x: x + 1, y: rowY + 2 }, end: { x: x + 4, y: rowY - 1 }, thickness: 1, color: RED });
        page.drawLine({ start: { x: x + 4, y: rowY - 1 }, end: { x: x + 9, y: rowY + 5 }, thickness: 1, color: RED });
        drawTextFit(page, regular, feature, x + 11, rowY, 172, 7, { minimum: 5.2 });
    });

    page.drawLine({ start: { x: 28, y: 126 }, end: { x: 584, y: 126 }, thickness: 2.2, color: RED });
    page.drawText('SCAN TO VIEW VEHICLE', { x: 28, y: 106, size: 8.5, font: bold, color: RED });
    drawTextFit(page, regular, dealer.phone, 28, 90, 300, 8.5, { color: MUTED });
    drawTextFit(page, regular, dealer.email, 28, 76, 300, 8.5, { color: MUTED });
    drawTextFit(page, bold, websiteLabel(data.publicWebsiteUrl), 28, 62, 300, 8.5, { color: MUTED });
    drawTextFit(page, regular, dealer.name, 28, 42, 300, 7.5, { color: MUTED });
    drawWrappedTextFit(page, regular, dealer.address, 28, 30, 300, 7.5, { color: MUTED, lineHeight: 8.5, minimum: 3.5 });

    if (qrImage) {
        drawImageFit(page, qrImage, 458, 29, 106, 88);
        drawCenteredTextFit(page, regular, 'View photos, details & availability', 440, 18, 140, 6.5, { color: MUTED });
    } else {
        page.drawText('Public vehicle URL is not configured.', { x: 400, y: 67, size: 7.5, font: bold, color: RED });
    }

    page.drawText(branded ? 'BRANDED VEHICLE CUTOUT' : 'ORIGINAL VEHICLE PHOTO', { x: 28, y: 12, size: 5.5, font: regular, color: rgb(0.50, 0.53, 0.58) });

    return pdf.save({ useObjectStreams: false });
};

export const generateWindowStickerPdf = async (data, mode = 'branded', onProgress = () => {}) => {
    const sourceUrl = featuredImageUrl(data.car);
    const sourceBlob = await fetchBlob(sourceUrl);
    const logoBlob = await fetchBlob(resolveSameOriginUrl('/img/logo.png'));
    let imageBlob = sourceBlob;
    let branded = false;
    let fallbackReason = '';

    if (mode === 'branded') {
        try {
            onProgress(1, 'Preparing vehicle image…');
            imageBlob = await getCutout(sourceUrl, sourceBlob, (percent, key) => onProgress(percent, key));
            branded = true;
            onProgress(100, 'Vehicle image ready.');
        } catch (error) {
            fallbackReason = 'Automatic background removal was unavailable, so the original featured photo was used.';
            onProgress(100, fallbackReason);
        }
    } else {
        onProgress(100, 'Original vehicle photo ready.');
    }

    const qrBytes = await drawQrCode(data.publicVehicleUrl);
    const bytes = await buildPdf({ ...data, publicWebsiteUrl: data.publicWebsiteUrl }, imageBlob, logoBlob, qrBytes, branded);

    return { bytes, branded, fallbackReason };
};

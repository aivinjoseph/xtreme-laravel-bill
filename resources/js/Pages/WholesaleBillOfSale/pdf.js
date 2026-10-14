import { PDFDocument, StandardFonts, rgb } from 'pdf-lib';
import { formatCurrency } from './calculations.js';

const plain = (value) => {
    if (value === null || value === undefined) return '';
    return String(value).replace(/[\r\n]+/g, ' ').trim();
};

const dateText = (value) => plain(value).replace(/-/g, ' / ');

const setText = (form, name, value) => {
    const field = form.getTextField(name);
    let text = plain(value);
    const maxLength = field.getMaxLength();

    // Keep values inside the approved field when malformed input exceeds its
    // source-defined capacity. No customer value is logged or persisted.
    if (maxLength !== undefined) text = text.slice(0, maxLength);
    field.setText(text);
};

const setCheckbox = (form, name, checked) => {
    const field = form.getCheckBox(name);
    field.uncheck();
    if (checked) field.check();
};

const setRadioChoice = (form, name, option) => {
    const field = form.getRadioGroup(name);
    field.clear();
    if (option) field.select(option);
};

const clearDynamicFields = (form) => {
    for (const field of form.getFields()) {
        const type = field.constructor.name;
        if (type === 'PDFTextField') field.setText('');
        if (type === 'PDFCheckBox') field.uncheck();
        if (type === 'PDFRadioGroup') field.clear();
    }
};

const wrapText = (value, lengths) => {
    const words = plain(value).split(/\s+/).filter(Boolean);
    const lines = [];
    let line = '';

    for (const word of words) {
        const candidate = line ? `${line} ${word}` : word;
        if (line && candidate.length > lengths[Math.min(lines.length, lengths.length - 1)]) {
            lines.push(line);
            line = word;
        } else {
            line = candidate;
        }
    }

    if (line) lines.push(line);
    return lengths.map((_, index) => lines[index] ?? '').join('\n');
};

const drawSignature = (page, rectangle, value, font) => {
    const text = plain(value);
    if (!text) return;

    const availableWidth = Math.max(1, rectangle.width - 4);
    let fontSize = 8;
    while (fontSize > 5 && font.widthOfTextAtSize(text, fontSize) > availableWidth) {
        fontSize -= 0.5;
    }

    page.drawText(text, {
        x: rectangle.x + 2,
        y: rectangle.y + Math.max(1, (rectangle.height - fontSize) / 2),
        size: fontSize,
        font,
        color: rgb(0, 0, 0),
    });
};

const populate = async (pdf, data) => {
    const form = pdf.getForm();
    const page = pdf.getPages()[0];
    const font = await pdf.embedFont(StandardFonts.Helvetica);
    const seller = data?.seller ?? {};
    const purchaser = data?.purchaser ?? {};
    const vehicle = data?.vehicle ?? {};
    const financial = data?.financial ?? {};
    const searches = data?.searches ?? {};
    const disclosures = data?.disclosures ?? {};

    clearDynamicFields(form);

    const signatureRectangles = ['Signature', 'Signature_2'].map((name) => (
        form.getSignature(name).acroField.getWidgets()[0].getRectangle()
    ));

    setText(form, 'DATE', dateText(data?.date));

    setText(form, 'MVDA REG', seller.mvda_registration_number);
    setText(form, 'NAME', seller.name);
    setText(form, 'ADDRESS', seller.address);
    setText(form, 'CITY_PROV', seller.city_province_postal);
    setText(form, 'TEL', seller.telephone);
    setText(form, 'FAX', seller.fax);
    setText(form, 'Salespersons Registration', seller.salesperson_registration_number);
    setText(form, 'Salespersons Name', seller.salesperson_name);
    setText(form, 'HST Registration', seller.hst_registration_number);

    setText(form, 'MVDA REG_2', purchaser.mvda_registration_number);
    setText(form, 'NAME_2', purchaser.name);
    setText(form, 'ADDRESS_2', purchaser.address);
    setText(form, 'CITY_PROV_2', purchaser.city_province_postal);
    setText(form, 'TEL_2', purchaser.telephone);
    setText(form, 'FAX_2', purchaser.fax);
    setText(form, 'Salespersons Registration_2', purchaser.salesperson_registration_number);
    setText(form, 'Salespersons Name_2', purchaser.salesperson_name);
    setText(form, 'HST Registration_2', purchaser.hst_registration_number);

    setText(form, 'STOCK', vehicle.stock_number);
    setText(form, 'YEAR', vehicle.year);
    setText(form, 'MAKE', vehicle.make);
    setText(form, 'MODEL', vehicle.model);
    setText(form, 'COLOUR', vehicle.colour);
    setText(form, 'TRIM LEVEL', vehicle.trim_level);
    setText(form, 'FUEL', vehicle.fuel);
    setText(form, 'SERIAL OR VIN', vehicle.vin);
    setText(form, 'ODOM', vehicle.distance_travelled);
    setText(form, 'PRICE', formatCurrency(financial.price));
    setText(form, 'HST', formatCurrency(financial.hst));
    setText(form, 'LIC', formatCurrency(financial.licencing));
    setText(form, 'TOTAL', formatCurrency(financial.total));
    setRadioChoice(form, 'ODOM_TYPE', vehicle.mileage_unit === 'mi' ? 'ODOM_TYPE_MLS' : 'ODOM_TYPE_KMS');

    setCheckbox(form, 'LIEN_SEARCH', searches.ucda_lien);
    setCheckbox(form, 'OOP_LIEN_SEARCH', searches.out_of_province_lien);
    setCheckbox(form, 'AUTO_CHECK', searches.auto_check);
    setCheckbox(form, 'OMHS', searches.ontario_vehicle_history);
    setCheckbox(form, 'CARFAX', searches.carfax);
    setCheckbox(form, 'CAN_CHECK', searches.can_check);

    setRadioChoice(form, 'BRAND', {
        irreparable: 'BRAND_IRR',
        rebuilt: 'BRAND_REB',
        salvage: 'BRAND_SAL',
        none: 'BRAND_NONE',
    }[disclosures.mto_registration_brand]);

    setCheckbox(form, 'ODOM_FAULTY', disclosures.odometer_issue);
    setRadioChoice(form, 'ODOM_FAULTY_OPT', {
        '1A': 'ODOM_FAULTY_OPT_1A',
        '1B': 'ODOM_FAULTY_OPT_1B',
    }[disclosures.odometer_section]);
    setText(form, 'ODOM_PREV_READING', disclosures.previous_odometer_reading);
    setText(form, 'ODOM_DOR', dateText(disclosures.previous_odometer_date));
    setRadioChoice(form, 'ODOM_TKU_KM', disclosures.previous_odometer_unit !== 'mi' ? 'Choice1' : undefined);
    setRadioChoice(form, 'ODOM_TKU', disclosures.previous_odometer_unit === 'mi' ? 'ODOM_TKU_MLS' : undefined);

    setRadioChoice(form, 'OUTOFPROVINCE VEHICLE', disclosures.us_vehicle ? 'Yes_2' : (disclosures.out_of_province_vehicle ? 'Yes' : undefined));
    setText(form, 'IF YES IDENTIFY PROVINCES ANDOR STATES 1', disclosures.jurisdiction_details);
    setText(form, 'IF YES IDENTIFY PROVINCES ANDOR STATES 2', '');
    setText(form, 'IF YES IDENTIFY PROVINCES ANDOR STATES 3', '');

    setCheckbox(form, 'DAILY_RENTAL', disclosures.daily_rental);
    setCheckbox(form, 'FIRE_DMG', disclosures.fire_damaged);
    setCheckbox(form, 'WATER_DMG', disclosures.water_damaged);
    setCheckbox(form, 'POLICE', disclosures.police_cruiser);
    setCheckbox(form, 'EMERG', disclosures.emergency_services_vehicle);
    setCheckbox(form, 'TAXI', disclosures.taxi_or_limo);
    setCheckbox(form, 'REP_SUB', disclosures.suspension_subframe_repairs);
    setCheckbox(form, 'STRUCT_DMG', disclosures.structural_parts);
    setCheckbox(form, 'DMG_EXC', disclosures.previous_damage_over_3000);
    setCheckbox(form, 'ORIG_MAN_CHNG', disclosures.badges_or_specs_changed);
    setRadioChoice(form, 'ABS_INOP', disclosures.anti_lock_not_applicable ? 'ABS_INOP_NA' : (disclosures.anti_lock_brakes ? 'ABS_INOP_YES' : undefined));
    setRadioChoice(form, 'AB_INOP', disclosures.air_bags_not_applicable ? 'AB_INOP_NA' : (disclosures.air_bags ? 'AB_INOP_YES' : undefined));
    setCheckbox(form, 'PCU_INOP', disclosures.pollution_control);
    setCheckbox(form, 'TOTAL_LOSS', disclosures.total_loss);
    setCheckbox(form, 'THFT_REC', disclosures.theft_recovery);
    setCheckbox(form, 'WARR_CANC', disclosures.warranty_cancelled);
    setCheckbox(form, 'BODY_PNLS', disclosures.body_panels_painted_or_replaced);
    setText(form, 'DISC', disclosures.other_disclosures);

    const detailLines = wrapText(disclosures.details, [55, 65, 90]).split('\n');
    setText(form, 'DISC_2', detailLines[0]);
    setText(form, 'DISC_3', detailLines[1]);
    setText(form, 'DISC_4', detailLines[2]);
    setCheckbox(form, 'NO DISCLOSURES ARE REQUIRED TO BE MADE FOR THIS VEHICLE', disclosures.no_disclosures);

    form.updateFieldAppearances(font);
    form.flatten();

    drawSignature(page, signatureRectangles[0], seller.signature, font);
    drawSignature(page, signatureRectangles[1], purchaser.signature, font);
};

export const populateWholesaleBillOfSalePdf = async (templateBytes, data) => {
    const pdf = await PDFDocument.load(templateBytes, { ignoreEncryption: true });
    await populate(pdf, data);
    return pdf.save({ useObjectStreams: false });
};

export const generateWholesaleBillOfSalePdf = async (data, templateUrl) => {
    const response = await fetch(templateUrl, { credentials: 'same-origin' });
    if (!response.ok) throw new Error('Wholesale PDF template could not be loaded.');
    return populateWholesaleBillOfSalePdf(await response.arrayBuffer(), data);
};

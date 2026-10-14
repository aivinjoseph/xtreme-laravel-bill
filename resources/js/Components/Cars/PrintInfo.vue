<script setup>
import { computed } from 'vue';
import QRCodeVue3 from 'qrcode-vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    car: {
        type: Object,
        required: true,
    },
    dealer: {
        type: Object,
        default: () => ({}),
    },
    publicWebsiteUrl: {
        type: String,
        default: '',
    },
    publicVehicleUrl: {
        type: String,
        default: '',
    },
});

const placeholderValues = new Set(['', 'null', 'undefined', 'n/a', 'na', '-', '--']);

const cleanValue = (value) => {
    if (value === null || value === undefined) {
        return '';
    }

    const normalized = String(value).trim();

    return placeholderValues.has(normalized.toLowerCase()) ? '' : normalized;
};

const title = computed(() => {
    const words = [];
    const seen = new Set();

    [props.car.year, props.car.make, props.car.model, props.car.trim].forEach((value) => {
        cleanValue(value).split(/\s+/).forEach((word) => {
            const normalized = word.toLowerCase();

            if (normalized && !seen.has(normalized)) {
                seen.add(normalized);
                words.push(word);
            }
        });
    });

    return words.join(' ') || cleanValue(props.car.name) || 'Vehicle';
});

const price = computed(() => {
    const value = cleanValue(props.car.price);

    if (!value || Number.isNaN(Number(value))) {
        return '';
    }

    return new Intl.NumberFormat('en-CA', {
        style: 'currency',
        currency: 'CAD',
        maximumFractionDigits: 0,
    }).format(Number(value));
});

const featuredImage = computed(() => {
    const images = Array.isArray(props.car.images)
        ? props.car.images.filter((image) => cleanValue(image))
        : [];
    const selectedIndex = Number(props.car.featured_image_index);
    const selectedImage = Array.isArray(props.car.images) ? props.car.images[selectedIndex] : '';

    return cleanValue(selectedImage) || images[0] || '';
});

const mileage = computed(() => {
    const value = cleanValue(props.car.mileage);
    const unit = cleanValue(props.car.mileage_unit);

    return [value, unit ? unit.toUpperCase() : ''].filter(Boolean).join(' ');
});

const specifications = computed(() => [
    ['VIN', cleanValue(props.car.vin)],
    ['Mileage', mileage.value],
    ['Exterior Colour', cleanValue(props.car.ext_color)],
    ['Interior Colour', cleanValue(props.car.int_color)],
    ['Engine', cleanValue(props.car.engine)],
    ['Transmission', cleanValue(props.car.transmission)],
    ['Fuel', cleanValue(props.car.fuel)],
    ['Drive', cleanValue(props.car.drive)],
    ['Body Style', cleanValue(props.car.body_type)],
    ['Doors', cleanValue(props.car.door)],
    ['Seats', cleanValue(props.car.seats)],
    ['City Fuel Consumption', cleanValue(props.car.city_fuel_consumption) ? `${cleanValue(props.car.city_fuel_consumption)} / 100 km` : ''],
    ['Highway Fuel Consumption', cleanValue(props.car.highway_fuel_consumption) ? `${cleanValue(props.car.highway_fuel_consumption)} / 100 km` : ''],
].filter(([, value]) => value));

const features = computed(() => {
    const values = Array.isArray(props.car.features) ? props.car.features : [];

    return values
        .map((feature) => cleanValue(typeof feature === 'object' ? feature.name : feature))
        .filter(Boolean);
});

const displayedFeatures = computed(() => features.value.slice(0, 12));
const remainingFeatureCount = computed(() => Math.max(0, features.value.length - displayedFeatures.value.length));

const dealerName = computed(() => cleanValue(props.dealer.name));
const dealerAddress = computed(() => cleanValue(props.dealer.address));
const dealerPhone = computed(() => cleanValue(props.dealer.phone));
const dealerEmail = computed(() => cleanValue(props.dealer.email));
const websiteLabel = computed(() => {
    if (!props.publicWebsiteUrl) {
        return '';
    }

    try {
        return new URL(props.publicWebsiteUrl).host;
    } catch {
        return props.publicWebsiteUrl.replace(/^https?:\/\//, '').replace(/\/$/, '');
    }
});

const print = async () => {
    const images = [...document.querySelectorAll('.window-sticker img')];

    await Promise.all(images.map((image) => {
        if (image.complete) {
            return Promise.resolve();
        }

        return new Promise((resolve) => {
            image.addEventListener('load', resolve, { once: true });
            image.addEventListener('error', resolve, { once: true });
        });
    }));

    window.print();
};
</script>

<template>
    <article class="window-sticker">
        <header class="sticker-header">
            <div class="brand-block">
                <img src="/img/logo.png" class="dealer-logo" alt="Dealer logo" />
                <div v-if="dealerName" class="dealer-name">{{ dealerName }}</div>
                <div v-if="dealerAddress" class="dealer-address">{{ dealerAddress }}</div>
            </div>
            <SecondaryButton type="button" class="print-action print:hidden" @click="print">Print</SecondaryButton>
        </header>

        <section class="vehicle-heading">
            <div>
                <p class="eyebrow">PRE-OWNED VEHICLE</p>
                <h1>{{ title }}</h1>
            </div>
            <div v-if="price" class="vehicle-price">{{ price }}</div>
        </section>

        <div v-if="featuredImage" class="vehicle-photo-frame">
            <img :src="featuredImage" :alt="`${title} vehicle photo`" class="vehicle-photo" />
        </div>

        <section v-if="specifications.length" class="sticker-section">
            <h2>Vehicle Details</h2>
            <div class="spec-grid">
                <div v-for="([label, value]) in specifications" :key="label" class="spec-item">
                    <span class="spec-label">{{ label }}</span>
                    <span class="spec-value">{{ value }}</span>
                </div>
            </div>
        </section>

        <section v-if="displayedFeatures.length" class="sticker-section features-section">
            <h2>Features</h2>
            <div class="feature-grid">
                <span v-for="feature in displayedFeatures" :key="feature" class="feature-item">✓ {{ feature }}</span>
            </div>
            <p v-if="remainingFeatureCount" class="feature-overflow">+ {{ remainingFeatureCount }} more features</p>
        </section>

        <section class="sticker-footer">
            <div class="contact-block">
                <div class="qr-label">SCAN TO VIEW VEHICLE</div>
                <div v-if="dealerPhone" class="contact-line">{{ dealerPhone }}</div>
                <div v-if="dealerEmail" class="contact-line">{{ dealerEmail }}</div>
                <div v-if="websiteLabel" class="website-line">{{ websiteLabel }}</div>
            </div>
            <div class="qr-block">
                <div v-if="publicVehicleUrl" class="qr-code">
                    <QRCodeVue3
                        :value="publicVehicleUrl"
                        :width="180"
                        :height="180"
                        :qr-options="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
                        :image-options="{ hideBackgroundDots: true, imageSize: 0, margin: 8 }"
                        :dots-options="{ type: 'square', color: '#111827' }"
                        :background-options="{ color: '#ffffff' }"
                        :corners-square-options="{ type: 'square', color: '#111827' }"
                        :corners-dot-options="{ type: 'square', color: '#111827' }"
                    />
                </div>
                <div v-else class="qr-error">Public vehicle URL is not configured.</div>
                <div v-if="publicVehicleUrl" class="qr-caption">View photos, details &amp; availability</div>
            </div>
        </section>

        <footer class="sticker-contact">
            <span v-if="dealerName">{{ dealerName }}</span>
            <span v-if="dealerAddress">{{ dealerAddress }}</span>
            <span v-if="dealerPhone">{{ dealerPhone }}</span>
            <span v-if="dealerEmail">{{ dealerEmail }}</span>
            <span v-if="websiteLabel">{{ websiteLabel }}</span>
        </footer>
    </article>
</template>

<style scoped>
.window-sticker {
    box-sizing: border-box;
    width: 7.8in;
    min-height: 10.3in;
    margin: 1rem auto;
    padding: 0.28in;
    color: #111827;
    background: #ffffff;
    border: 1px solid #d1d5db;
    font-family: Arial, Helvetica, sans-serif;
}

.sticker-header,
.vehicle-heading,
.sticker-footer,
.sticker-contact {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sticker-header {
    min-height: 0.75in;
    padding-bottom: 0.12in;
    border-bottom: 3px solid #991b1b;
}

.brand-block {
    min-width: 0;
}

.dealer-logo {
    display: block;
    width: auto;
    height: 0.46in;
    max-width: 2.55in;
    object-fit: contain;
    object-position: left center;
}

.dealer-name {
    margin-top: 0.04in;
    color: #991b1b;
    font-size: 0.15in;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.dealer-address {
    max-width: 4.5in;
    margin-top: 0.03in;
    color: #4b5563;
    font-size: 0.095in;
}

.vehicle-heading {
    gap: 0.2in;
    padding: 0.16in 0 0.13in;
}

.eyebrow {
    margin: 0 0 0.035in;
    color: #991b1b;
    font-size: 0.09in;
    font-weight: 800;
    letter-spacing: 0.14em;
}

h1 {
    margin: 0;
    font-size: 0.31in;
    line-height: 1.05;
    font-weight: 900;
}

.vehicle-price {
    flex: 0 0 auto;
    color: #991b1b;
    font-size: 0.29in;
    font-weight: 900;
    white-space: nowrap;
}

.vehicle-photo-frame {
    width: 100%;
    height: 2.25in;
    overflow: hidden;
    background: #f3f4f6;
    border: 1px solid #d1d5db;
}

.vehicle-photo {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}

.sticker-section {
    padding-top: 0.12in;
}

h2 {
    margin: 0 0 0.07in;
    padding-bottom: 0.035in;
    color: #991b1b;
    border-bottom: 1px solid #d1d5db;
    font-size: 0.12in;
    font-weight: 900;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.spec-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.055in 0.2in;
}

.spec-item {
    display: grid;
    grid-template-columns: minmax(1.25in, 1fr) minmax(0, 1.6fr);
    gap: 0.08in;
    min-width: 0;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 0.035in;
}

.spec-label {
    color: #6b7280;
    font-size: 0.085in;
    font-weight: 700;
}

.spec-value {
    min-width: 0;
    overflow-wrap: anywhere;
    font-size: 0.09in;
    font-weight: 700;
}

.features-section {
    break-inside: avoid;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.055in 0.14in;
}

.feature-item {
    min-width: 0;
    overflow-wrap: anywhere;
    color: #374151;
    font-size: 0.085in;
    font-weight: 700;
}

.feature-item::first-letter {
    color: #991b1b;
}

.feature-overflow {
    margin: 0.04in 0 0;
    color: #6b7280;
    font-size: 0.075in;
}

.sticker-footer {
    align-items: stretch;
    gap: 0.22in;
    margin-top: 0.15in;
    padding-top: 0.12in;
    border-top: 3px solid #991b1b;
}

.contact-block {
    display: flex;
    flex: 1 1 auto;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}

.qr-label {
    margin-bottom: 0.1in;
    color: #991b1b;
    font-size: 0.12in;
    font-weight: 900;
    letter-spacing: 0.08em;
}

.contact-line,
.website-line {
    overflow-wrap: anywhere;
    color: #374151;
    font-size: 0.095in;
    line-height: 1.5;
}

.website-line {
    margin-top: 0.04in;
    font-weight: 800;
}

.qr-block {
    flex: 0 0 1.78in;
    text-align: center;
}

.qr-code {
    display: inline-flex;
    padding: 0.08in;
    background: #ffffff;
}

.qr-code :deep(canvas),
.qr-code :deep(img) {
    display: block;
    width: 1.52in !important;
    height: 1.52in !important;
}

.qr-caption {
    margin-top: 0.04in;
    color: #4b5563;
    font-size: 0.075in;
    font-weight: 700;
}

.qr-error {
    padding: 0.15in 0.08in;
    color: #991b1b;
    border: 1px solid #fecaca;
    font-size: 0.085in;
    font-weight: 700;
}

.sticker-contact {
    flex-wrap: wrap;
    gap: 0.02in 0.12in;
    margin-top: 0.1in;
    padding-top: 0.07in;
    color: #6b7280;
    border-top: 1px solid #d1d5db;
    font-size: 0.075in;
}

.sticker-contact span + span::before {
    content: '•';
    margin-right: 0.12in;
    color: #991b1b;
}

@media screen and (max-width: 700px) {
    .window-sticker {
        width: 100%;
        min-height: auto;
        padding: 1rem;
    }

    .vehicle-heading,
    .sticker-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .vehicle-photo-frame {
        height: 42vw;
        min-height: 2in;
    }

    .qr-block {
        align-self: center;
    }
}

@page {
    size: Letter portrait;
    margin: 0.35in;
}

@media print {
    .window-sticker {
        width: 100%;
        min-height: 0;
        margin: 0;
        padding: 0;
        border: 0;
    }

    .print-action {
        display: none !important;
    }
}
</style>

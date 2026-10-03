<script setup>
import { nextTick, reactive, ref, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WholesaleBillOfSalePrintTemplate from '@/Pages/WholesaleBillOfSale/PrintTemplate.vue';
import { calculateHst, calculateWholesaleTotals } from './calculations.js';

const props = defineProps({
    car: { type: Object, required: true },
    dealer: { type: Object, default: () => ({}) },
});

const today = new Date().toISOString().slice(0, 10);
const vinTenthDigit = props.car.vin?.charAt(9) ?? '';

const party = (defaults = {}) => ({
    mvda_registration_number: '',
    name: '',
    address: '',
    city_province_postal: '',
    telephone: '',
    fax: '',
    salesperson_registration_number: '',
    salesperson_name: '',
    signature: '',
    hst_registration_number: '',
    ...defaults,
});

const form = reactive({
    data: {
        date: today,
        vin_tenth_digit: vinTenthDigit,
        seller: party({
            mvda_registration_number: props.dealer.registration_number ?? '',
            name: props.dealer.name ?? '',
            address: props.dealer.address ?? '',
            telephone: props.dealer.phone ?? '',
            hst_registration_number: props.dealer.hst_registration_number ?? '',
        }),
        purchaser: party(),
        vehicle: {
            stock_number: props.car.stock_number ?? '',
            year: props.car.year ?? '',
            make: props.car.make ?? '',
            model: props.car.model ?? '',
            colour: props.car.ext_color ?? '',
            trim_level: props.car.trim ?? '',
            fuel: props.car.fuel ?? '',
            vin: props.car.vin ?? '',
            distance_travelled: props.car.mileage ?? '',
            mileage_unit: props.car.mileage_unit ?? 'km',
        },
        financial: {
            hst_rate: props.dealer.hst_rate ?? 0.13,
            price: props.car.price ?? 0,
            hst: calculateHst(props.car.price ?? 0, props.dealer.hst_rate ?? 0.13),
            licencing: 0,
            total: 0,
        },
        searches: {
            ucda_lien: false,
            out_of_province_lien: false,
            auto_check: false,
            ontario_vehicle_history: false,
            carfax: false,
            can_check: false,
        },
        mto_registration_brand: 'none',
        disclosures: {
            out_of_province_vehicle: false,
            us_vehicle: false,
            jurisdiction_details: '',
            daily_rental: false,
            fire_damaged: false,
            water_damaged: false,
            odometer_issue: false,
            odometer_section: '',
            previous_odometer_reading: '',
            previous_odometer_unit: 'km',
            previous_odometer_date: '',
            police_cruiser: false,
            emergency_services_vehicle: false,
            taxi_or_limo: false,
            anti_lock_brakes: false,
            anti_lock_not_applicable: false,
            air_bags: false,
            air_bags_not_applicable: false,
            pollution_control: false,
            total_loss: false,
            theft_recovery: false,
            warranty_cancelled: false,
            body_panels_painted_or_replaced: false,
            suspension_subframe_repairs: false,
            structural_parts: false,
            previous_damage_over_3000: false,
            badges_or_specs_changed: false,
            other_disclosures: '',
            details: '',
            no_disclosures: false,
        },
    },
});

const previewMode = ref(false);
const hstEdited = ref(false);
const financial = form.data.financial;
const disclosures = form.data.disclosures;

watch(() => [financial.price, financial.hst_rate], () => {
    if (!hstEdited.value) financial.hst = calculateHst(financial.price, financial.hst_rate);
}, { immediate: true });

watch(() => [financial.price, financial.hst, financial.licencing], () => {
    Object.assign(financial, calculateWholesaleTotals(financial));
}, { immediate: true });

const preview = async () => {
    previewMode.value = true;
    await nextTick();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const edit = () => { previewMode.value = false; };
const print = () => window.print();
</script>

<template>
    <AdminLayout :title="`Wholesale Bill of Sale - ${car.name}`">
        <section v-if="!previewMode" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 print:hidden">
            <div class="flex flex-col gap-4 border-b pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-red-800">Wholesale Bill of Sale</p>
                    <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ car.year }} {{ car.make }} {{ car.model }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Vehicle snapshot: {{ form.data.vehicle.vin || 'VIN not recorded' }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <SecondaryButton type="button" @click="preview">Preview Wholesale Bill of Sale</SecondaryButton>
                    <PrimaryButton type="button" @click="print">Print Wholesale Bill of Sale</PrimaryButton>
                </div>
            </div>

            <div class="mt-6 space-y-6">
                <section class="card">
                    <h2 class="card-title">Document</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel value="Date" /><input v-model="form.data.date" type="date" class="input" /></div>
                        <div><InputLabel value="VIN 10th digit" /><input v-model="form.data.vin_tenth_digit" maxlength="1" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Seller</h2>
                    <p class="mb-4 text-sm text-gray-500">Dealer values are copied from the existing dealer settings and remain editable only on this temporary document.</p>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel value="MVDA Registration #" /><input v-model="form.data.seller.mvda_registration_number" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="Name" /><input v-model="form.data.seller.name" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="Address" /><input v-model="form.data.seller.address" class="input" /></div>
                        <div><InputLabel value="City / Province / Postal Code" /><input v-model="form.data.seller.city_province_postal" class="input" /></div>
                        <div><InputLabel value="Telephone" /><input v-model="form.data.seller.telephone" class="input" /></div>
                        <div><InputLabel value="Fax" /><input v-model="form.data.seller.fax" class="input" /></div>
                        <div><InputLabel value="Salesperson's Registration #" /><input v-model="form.data.seller.salesperson_registration_number" class="input" /></div>
                        <div><InputLabel value="Salesperson's Name" /><input v-model="form.data.seller.salesperson_name" class="input" /></div>
                        <div><InputLabel value="Signature" /><input v-model="form.data.seller.signature" class="input" /></div>
                        <div><InputLabel value="HST Registration #" /><input v-model="form.data.seller.hst_registration_number" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Purchasing Dealer</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel value="MVDA Registration #" /><input v-model="form.data.purchaser.mvda_registration_number" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="Name" /><input v-model="form.data.purchaser.name" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="Address" /><input v-model="form.data.purchaser.address" class="input" /></div>
                        <div><InputLabel value="City / Province / Postal Code" /><input v-model="form.data.purchaser.city_province_postal" class="input" /></div>
                        <div><InputLabel value="Telephone" /><input v-model="form.data.purchaser.telephone" class="input" /></div>
                        <div><InputLabel value="Fax" /><input v-model="form.data.purchaser.fax" class="input" /></div>
                        <div><InputLabel value="Salesperson's Registration #" /><input v-model="form.data.purchaser.salesperson_registration_number" class="input" /></div>
                        <div><InputLabel value="Salesperson's Name" /><input v-model="form.data.purchaser.salesperson_name" class="input" /></div>
                        <div><InputLabel value="Signature" /><input v-model="form.data.purchaser.signature" class="input" /></div>
                        <div><InputLabel value="HST Registration #" /><input v-model="form.data.purchaser.hst_registration_number" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Vehicle and Financial Information</h2>
                    <p class="mb-4 text-sm text-gray-500">These values were copied from inventory. Changes here do not update the Car record.</p>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div><InputLabel value="Stock #" /><input v-model="form.data.vehicle.stock_number" class="input" /></div>
                        <div><InputLabel value="Year" /><input v-model="form.data.vehicle.year" class="input" /></div>
                        <div><InputLabel value="Make" /><input v-model="form.data.vehicle.make" class="input" /></div>
                        <div><InputLabel value="Model" /><input v-model="form.data.vehicle.model" class="input" /></div>
                        <div><InputLabel value="Colour" /><input v-model="form.data.vehicle.colour" class="input" /></div>
                        <div><InputLabel value="Trim level" /><input v-model="form.data.vehicle.trim_level" class="input" /></div>
                        <div><InputLabel value="Gas / Diesel / Hybrid" /><input v-model="form.data.vehicle.fuel" class="input" /></div>
                        <div><InputLabel value="Serial or V.I.N. #" /><input v-model="form.data.vehicle.vin" class="input" /></div>
                        <div><InputLabel value="Distance travelled" /><input v-model="form.data.vehicle.distance_travelled" type="number" min="0" class="input" /></div>
                        <div><InputLabel value="KM / Miles" /><select v-model="form.data.vehicle.mileage_unit" class="input"><option value="km">KMS</option><option value="mi">MILES</option></select></div>
                        <div><InputLabel value="Price" /><input v-model="financial.price" type="number" min="0" step="0.01" class="input" /></div>
                        <div><InputLabel value="HST rate" /><input v-model="financial.hst_rate" type="number" min="0" max="1" step="0.0001" class="input" /></div>
                        <div><InputLabel value="HST" /><input v-model="financial.hst" @input="hstEdited = true" type="number" min="0" step="0.01" class="input" /></div>
                        <div><InputLabel value="Licencing" /><input v-model="financial.licencing" type="number" min="0" step="0.01" class="input" /></div>
                        <div><InputLabel value="Total" /><div class="calculated">{{ financial.total }}</div></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Searches Provided</h2>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        <label class="check"><input v-model="form.data.searches.ucda_lien" type="checkbox" /> UCDA Lien Search &amp; Kwik Check™</label>
                        <label class="check"><input v-model="form.data.searches.out_of_province_lien" type="checkbox" /> Out-of-Province Lien Search</label>
                        <label class="check"><input v-model="form.data.searches.auto_check" type="checkbox" /> Auto Check™</label>
                        <label class="check"><input v-model="form.data.searches.ontario_vehicle_history" type="checkbox" /> Ontario Vehicle History Search</label>
                        <label class="check"><input v-model="form.data.searches.carfax" type="checkbox" /> CARFAX™</label>
                        <label class="check"><input v-model="form.data.searches.can_check" type="checkbox" /> CAN/CHECK™</label>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Mandatory Disclosure Statement</h2>
                    <div class="mb-5">
                        <InputLabel value="MTO Registration Brand" />
                        <div class="mt-2 flex flex-wrap gap-4">
                            <label v-for="brand in ['irreparable', 'rebuilt', 'salvage', 'none']" :key="brand" class="check"><input v-model="form.data.mto_registration_brand" :value="brand" type="radio" name="mto-registration-brand" /> {{ brand.toUpperCase() }}</label>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <div class="rounded border p-4">
                            <h3 class="font-semibold">Distance Travelled</h3>
                            <label class="mt-3 check"><input v-model="disclosures.odometer_issue" type="checkbox" /> Is odometer faulty, broken, replaced or rolled back: Yes</label>
                            <div v-if="disclosures.odometer_issue" class="mt-3 space-y-3">
                                <div><InputLabel value="If yes, check appropriate box" /><div class="mt-2 flex gap-4"><label class="check"><input v-model="disclosures.odometer_section" value="1A" type="radio" /> 1A</label><label class="check"><input v-model="disclosures.odometer_section" value="1B" type="radio" /> 1B</label></div></div>
                                <div v-if="disclosures.odometer_section === '1A'" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                                    <div><InputLabel value="Previous odometer reading" /><input v-model="disclosures.previous_odometer_reading" class="input" /></div>
                                    <div><InputLabel value="KM / Miles" /><select v-model="disclosures.previous_odometer_unit" class="input"><option value="km">Km</option><option value="mi">Miles</option></select></div>
                                    <div><InputLabel value="Date of previous reading" /><input v-model="disclosures.previous_odometer_date" type="date" class="input" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded border p-4">
                            <h3 class="font-semibold">Within the last seven years was this an:</h3>
                            <div class="mt-3 space-y-3">
                                <label class="check"><input v-model="disclosures.out_of_province_vehicle" type="checkbox" /> Out-of-province vehicle: Yes</label>
                                <label class="check"><input v-model="disclosures.us_vehicle" type="checkbox" /> U.S. vehicle: Yes</label>
                                <div v-if="disclosures.out_of_province_vehicle || disclosures.us_vehicle"><InputLabel value="If yes identify province(s) and/or state(s)" /><textarea v-model="disclosures.jurisdiction_details" rows="2" class="input"></textarea></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2">
                        <label class="check"><input v-model="disclosures.daily_rental" type="checkbox" /> Daily rental: Yes</label>
                        <label class="check"><input v-model="disclosures.police_cruiser" type="checkbox" /> Police cruiser: Yes</label>
                        <label class="check"><input v-model="disclosures.fire_damaged" type="checkbox" /> Fire damaged: Yes</label>
                        <label class="check"><input v-model="disclosures.emergency_services_vehicle" type="checkbox" /> Emerg. services vehicle: Yes</label>
                        <label class="check"><input v-model="disclosures.water_damaged" type="checkbox" /> Water damaged: Yes</label>
                        <label class="check"><input v-model="disclosures.taxi_or_limo" type="checkbox" /> Taxi or limo: Yes</label>
                        <label class="check"><input v-model="disclosures.suspension_subframe_repairs" type="checkbox" /> Does vehicle require repairs to suspension/subframe: Yes</label>
                        <label class="check"><input v-model="disclosures.structural_parts" type="checkbox" /> Structural parts damaged altered or repaired: Yes</label>
                        <label class="check"><input v-model="disclosures.previous_damage_over_3000" type="checkbox" /> Any previous damage repaired exceeding $3,000: Yes</label>
                        <label class="check"><input v-model="disclosures.badges_or_specs_changed" type="checkbox" /> Manufacturer's badges or decals changed/original production specifications changed: Yes</label>
                        <label class="check"><input v-model="disclosures.total_loss" type="checkbox" /> Has vehicle ever been declared a total loss by an insurer: Yes</label>
                        <label class="check"><input v-model="disclosures.theft_recovery" type="checkbox" /> Theft recovery: Yes</label>
                        <label class="check"><input v-model="disclosures.warranty_cancelled" type="checkbox" /> Manufacturer's warranty cancelled: Yes</label>
                        <label class="check"><input v-model="disclosures.body_panels_painted_or_replaced" type="checkbox" /> Any body panels painted or replaced: Yes</label>
                        <label class="check"><input v-model="disclosures.pollution_control" type="checkbox" /> Pollution control inoperable: Yes</label>
                        <div class="flex flex-wrap gap-4"><label class="check"><input v-model="disclosures.anti_lock_brakes" type="checkbox" /> Anti-lock brakes inoperable: Yes</label><label class="check"><input v-model="disclosures.anti_lock_not_applicable" type="checkbox" /> Not Applicable</label></div>
                        <div class="flex flex-wrap gap-4"><label class="check"><input v-model="disclosures.air_bags" type="checkbox" /> Air bags missing/inoperable: Yes</label><label class="check"><input v-model="disclosures.air_bags_not_applicable" type="checkbox" /> Not Applicable</label></div>
                    </div>
                    <div class="mt-5 grid grid-cols-1 gap-4">
                        <div><InputLabel value="Any other disclosures" /><textarea v-model="disclosures.other_disclosures" rows="2" class="input"></textarea></div>
                        <div><InputLabel value="If yes to any of the above, give details" /><textarea v-model="disclosures.details" rows="3" class="input"></textarea></div>
                        <label class="check"><input v-model="disclosures.no_disclosures" type="checkbox" /> No disclosures are required to be made for this vehicle</label>
                    </div>
                </section>
            </div>

            <div class="mt-6 flex justify-end gap-3"><SecondaryButton type="button" @click="preview">Preview Wholesale Bill of Sale</SecondaryButton><PrimaryButton type="button" @click="print">Print Wholesale Bill of Sale</PrimaryButton></div>
        </section>

        <section v-else class="wholesale-preview-wrap">
            <div class="preview-toolbar print:hidden"><SecondaryButton type="button" @click="edit">Back to editor</SecondaryButton><PrimaryButton type="button" @click="print">Print Wholesale Bill of Sale</PrimaryButton></div>
            <WholesaleBillOfSalePrintTemplate :data="form.data" />
        </section>
        <WholesaleBillOfSalePrintTemplate v-if="!previewMode" class="print-only-template" :data="form.data" />
    </AdminLayout>
</template>

<style scoped>
.card { @apply rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200; }
.card-title { @apply mb-4 text-lg font-semibold text-gray-900; }
.input { @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500; }
.check { @apply flex items-center gap-2 text-sm text-gray-700; }
.calculated { @apply mt-1 rounded-md bg-gray-50 px-3 py-2 font-semibold text-gray-800 ring-1 ring-gray-200; }
.preview-toolbar { @apply mx-auto flex max-w-[612pt] justify-end gap-3 px-4 py-6; }
.print-only-template { display: none; }

@media print {
    .print-only-template { display: block !important; }
    .wholesale-preview-wrap { display: none !important; }
}
</style>

<script setup>
import { computed, nextTick, onBeforeUnmount, reactive, ref, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { calculateSettlement } from './calculations.js';

const props = defineProps({
    car: { type: Object, required: true },
    dealer: { type: Object, default: () => ({}) },
});

const emptyData = (car, dealer) => ({
    dealer: { ...dealer },
    purchaser: {
        first_name: '', middle_initial: '', last_name: '', address: '', city: '', province: 'ON',
        postal_code: '', home_phone: '', business_phone: '', driver_licence_number: '',
        driver_licence_expiry: '', email: '', initials: '', co_signer_name: '', co_signer_signature: '',
    },
    vehicle: {
        year: car.year ?? '', make: car.make ?? '', model: car.model ?? '', trim: car.trim ?? '',
        colour: car.ext_color ?? '', vin: car.vin ?? '', stock_number: '',
        distance_travelled: car.mileage ?? '', mileage_unit: car.mileage_unit ?? 'km',
        condition: car.technical_condition ?? '', delivery_date: '', warranty_in_service_date: '',
        delivery_details: '', certificate_number: '', safety_certificate: 'yes',
        distance_unknown: false, true_distance_higher: false, true_distance_date: '',
        camvap: '', as_is: false,
    },
    insurance: {
        company: '', policy_number: '', expiry_date: '', agent: '', agent_phone: '',
    },
    trade_in: {
        enabled: false, year: '', make: '', model: '', trim: '', colour: '', vin: '',
        distance_travelled: '', mileage_unit: 'km', distance_unknown: false, lien: false,
        hst_status: '', exact_distance: '', hst_non_registrant: false, hst_registrant: false,
    },
    dealer_guaranty: { enabled: false, days: '', km: '', description: '' },
    third_party_warranty: { enabled: false, retail_value: '', company: '', months: '', km: '', description: '' },
    comments: '',
    settlement: {
        hst_rate: dealer.hst_rate ?? 0.13, hst_method: 'net_difference', payment_method: 'cash', sale_price: car.price ?? 0,
        extended_warranty: 0, anti_rust_module: 0, safety_e_test: 0, finance_fee: 0, omvic: 0,
        trade_in_allowance: 0, subtotal_hst_taxable: 0, net_difference: 0, hst_on_net_difference: 0,
        hst_on_subtotal: 0, licence_fee: 0, gasoline: 0, payout_lien_on_trade_in: 0,
        hst_payable_on_trade_in: 0, balance_due: 0, deposit: 0, payable_on_delivery: 0,
        insurance: 0, hst_on_insurance: 0, lien_registration_fee: 0,
        balance_financed_subject_to_approval: 0, net_amount_to_be_financed: 0,
        cost_of_borrowing: 0, total_balance_due: 0,
    },
    financing: { amount_of_payments: '', number_of_payments: '', payments_start_on: '', credit_approval: '', incentive: '', customer_received_disclosure: false },
    salesperson: { name: '', registration_number: '', signature: '' },
    vendor_acceptance: { dealer_registration_number: dealer.registration_number ?? '', official_name: '', title: '', acceptor_registration_number: '', date: '' },
    acknowledgements: { purchaser_signature: '', co_signer_signature: '', privacy_consent: false },
});

const mergeData = (base, override) => Object.keys(base).reduce((result, key) => {
    const baseValue = base[key];
    const overrideValue = override?.[key];
    result[key] = baseValue && typeof baseValue === 'object' && !Array.isArray(baseValue)
        ? mergeData(baseValue, overrideValue || {})
        : (overrideValue ?? baseValue);
    return result;
}, {});

const form = reactive({ data: mergeData(emptyData(props.car, props.dealer), {}) });
const previewMode = ref(false);
const pdfUrl = ref('');
const pdfLoading = ref(false);
const pdfError = ref('');
const settlement = computed(() => form.data.settlement);
const settlementInputs = [
    'hst_rate', 'hst_method', 'sale_price', 'extended_warranty', 'anti_rust_module', 'safety_e_test',
    'finance_fee', 'omvic', 'trade_in_allowance', 'licence_fee', 'gasoline', 'payout_lien_on_trade_in',
    'hst_payable_on_trade_in', 'deposit', 'insurance', 'hst_on_insurance', 'lien_registration_fee',
    'cost_of_borrowing',
];

watch(() => settlementInputs.map((key) => settlement.value[key]), () => {
    Object.assign(settlement.value, calculateSettlement(settlement.value));
}, { immediate: true });

const releasePdf = () => {
    if (pdfUrl.value) {
        URL.revokeObjectURL(pdfUrl.value);
    }
    pdfUrl.value = '';
};

const generatePdf = async () => {
    pdfLoading.value = true;
    pdfError.value = '';
    releasePdf();

    try {
        const response = await window.axios.post(
            route('bill-of-sales.pdf', { car: props.car.id }),
            { data: form.data },
            { responseType: 'blob' },
        );

        pdfUrl.value = URL.createObjectURL(response.data);
        return true;
    } catch (error) {
        pdfError.value = 'The approved PDF could not be generated. Please try again or contact an administrator.';
        return false;
    } finally {
        pdfLoading.value = false;
    }
};

const preview = async () => {
    previewMode.value = true;
    await nextTick();
    await generatePdf();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const edit = () => {
    previewMode.value = false;
    pdfError.value = '';
    releasePdf();
};

const print = async () => {
    const printWindow = window.open('', '_blank');
    const generated = pdfUrl.value || await generatePdf();

    if (!generated && !pdfUrl.value) {
        printWindow?.close();
        return;
    }

    if (printWindow) {
        printWindow.addEventListener('load', () => {
            window.setTimeout(() => printWindow.print(), 250);
        }, { once: true });
        printWindow.location.href = pdfUrl.value;
        return;
    }

    window.open(pdfUrl.value, '_blank', 'noopener,noreferrer');
};

onBeforeUnmount(releasePdf);
</script>

<template>
    <AdminLayout :title="`Retail Bill of Sale - ${car.name}`">
        <section v-if="!previewMode" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 print:hidden">
            <div class="flex flex-col gap-4 border-b pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-red-800">Retail Bill of Sale</p>
                    <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ car.year }} {{ car.make }} {{ car.model }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Vehicle snapshot: {{ form.data.vehicle.vin || 'VIN not recorded' }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <SecondaryButton type="button" @click="preview">Preview Bill of Sale</SecondaryButton>
                    <PrimaryButton type="button" @click="print">Print Bill of Sale</PrimaryButton>
                </div>
            </div>

            <div class="mt-6 space-y-6">
                <section class="card">
                    <h2 class="card-title">Purchaser Information</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel for="first-name" value="First name" /><input id="first-name" v-model="form.data.purchaser.first_name" class="input" /></div>
                        <div><InputLabel for="middle-initial" value="Middle initial" /><input id="middle-initial" v-model="form.data.purchaser.middle_initial" class="input" /></div>
                        <div><InputLabel for="last-name" value="Last name" /><input id="last-name" v-model="form.data.purchaser.last_name" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel for="purchaser-address" value="Address" /><input id="purchaser-address" v-model="form.data.purchaser.address" class="input" /></div>
                        <div><InputLabel for="purchaser-city" value="City / Town" /><input id="purchaser-city" v-model="form.data.purchaser.city" class="input" /></div>
                        <div><InputLabel for="purchaser-province" value="Province" /><input id="purchaser-province" v-model="form.data.purchaser.province" class="input" /></div>
                        <div><InputLabel for="postal-code" value="Postal code" /><input id="postal-code" v-model="form.data.purchaser.postal_code" class="input" /></div>
                        <div><InputLabel for="home-phone" value="Home telephone" /><input id="home-phone" v-model="form.data.purchaser.home_phone" class="input" /></div>
                        <div><InputLabel for="business-phone" value="Business / mobile telephone" /><input id="business-phone" v-model="form.data.purchaser.business_phone" class="input" /></div>
                        <div><InputLabel for="licence-number" value="Driver's licence number" /><input id="licence-number" v-model="form.data.purchaser.driver_licence_number" class="input" /></div>
                        <div><InputLabel for="licence-expiry" value="Driver's licence expiry date" /><input id="licence-expiry" v-model="form.data.purchaser.driver_licence_expiry" type="date" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel for="email" value="E-mail address" /><input id="email" v-model="form.data.purchaser.email" type="email" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Vehicle Information</h2>
                    <p class="mb-4 text-sm text-gray-500">Values below were copied from inventory and are editable only on this Bill of Sale.</p>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div><InputLabel value="Year" /><input v-model="form.data.vehicle.year" class="input" /></div>
                        <div><InputLabel value="Make" /><input v-model="form.data.vehicle.make" class="input" /></div>
                        <div><InputLabel value="Model" /><input v-model="form.data.vehicle.model" class="input" /></div>
                        <div><InputLabel value="Trim level" /><input v-model="form.data.vehicle.trim" class="input" /></div>
                        <div><InputLabel value="Colour" /><input v-model="form.data.vehicle.colour" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="VIN" /><input v-model="form.data.vehicle.vin" class="input" /></div>
                        <div><InputLabel value="Stock #" /><input v-model="form.data.vehicle.stock_number" class="input" /></div>
                        <div><InputLabel value="Distance travelled" /><input v-model="form.data.vehicle.distance_travelled" type="number" min="0" class="input" /></div>
                        <div><InputLabel value="Mileage unit" /><select v-model="form.data.vehicle.mileage_unit" class="input"><option value="km">KM</option><option value="mi">Miles</option></select></div>
                        <div><InputLabel value="Condition" /><input v-model="form.data.vehicle.condition" class="input" /></div>
                        <div><InputLabel value="Delivery date" /><input v-model="form.data.vehicle.delivery_date" type="date" class="input" /></div>
                        <div><InputLabel value="MFR warranty in-service date" /><input v-model="form.data.vehicle.warranty_in_service_date" type="date" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="Details of delivery" /><input v-model="form.data.vehicle.delivery_details" class="input" /></div>
                    </div>
                    <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <label class="check"><input v-model="form.data.vehicle.distance_unknown" type="checkbox" /> Distance unknown</label>
                        <label class="check"><input v-model="form.data.vehicle.true_distance_higher" type="checkbox" /> True distance believed to be higher</label>
                        <label class="check"><input v-model="form.data.vehicle.as_is" type="checkbox" /> Vehicle sold “AS IS”</label>
                        <label class="check"><input v-model="form.data.vehicle.camvap" value="yes" type="radio" name="camvap" /> Manufacturer participates in CAMVAP: YES</label>
                        <label class="check"><input v-model="form.data.vehicle.camvap" value="no" type="radio" name="camvap" /> Manufacturer participates in CAMVAP: NO</label>
                    </div>
                    <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel value="Safety Standards Certificate" /><select v-model="form.data.vehicle.safety_certificate" class="input"><option value="yes">YES</option><option value="no">NO</option></select></div>
                        <div><InputLabel value="Certificate number" /><input v-model="form.data.vehicle.certificate_number" class="input" /></div>
                        <div><InputLabel value="True distance date / as of" /><input v-model="form.data.vehicle.true_distance_date" type="date" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Insurance Information</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                        <div><InputLabel value="Insurance company" /><input v-model="form.data.insurance.company" class="input" /></div>
                        <div><InputLabel value="Policy number" /><input v-model="form.data.insurance.policy_number" class="input" /></div>
                        <div><InputLabel value="Expiry date" /><input v-model="form.data.insurance.expiry_date" type="date" class="input" /></div>
                        <div><InputLabel value="Insurance agent" /><input v-model="form.data.insurance.agent" class="input" /></div>
                        <div><InputLabel value="Agent phone number" /><input v-model="form.data.insurance.agent_phone" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <div class="flex flex-wrap items-center justify-between gap-3"><h2 class="card-title mb-0">Vehicle to be Traded-in</h2><label class="check"><input v-model="form.data.trade_in.enabled" type="checkbox" /> Trade-in: YES</label></div>
                    <div v-if="form.data.trade_in.enabled" class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div><InputLabel value="Year" /><input v-model="form.data.trade_in.year" class="input" /></div>
                        <div><InputLabel value="Make" /><input v-model="form.data.trade_in.make" class="input" /></div>
                        <div><InputLabel value="Model" /><input v-model="form.data.trade_in.model" class="input" /></div>
                        <div><InputLabel value="Trim level" /><input v-model="form.data.trade_in.trim" class="input" /></div>
                        <div><InputLabel value="Colour" /><input v-model="form.data.trade_in.colour" class="input" /></div>
                        <div class="md:col-span-2"><InputLabel value="VIN #" /><input v-model="form.data.trade_in.vin" class="input" /></div>
                        <div><InputLabel value="Distance travelled" /><input v-model="form.data.trade_in.distance_travelled" type="number" min="0" class="input" /></div>
                        <div><InputLabel value="KM / Miles" /><select v-model="form.data.trade_in.mileage_unit" class="input"><option value="km">KM</option><option value="mi">Miles</option></select></div>
                        <div><InputLabel value="Exact distance travelled" /><input v-model="form.data.trade_in.exact_distance" class="input" /></div>
                        <label class="check"><input v-model="form.data.trade_in.lien" type="checkbox" /> Is there a lien against this vehicle?</label>
                        <label class="check"><input v-model="form.data.trade_in.hst_non_registrant" type="checkbox" /> HST non-registrant</label>
                        <label class="check"><input v-model="form.data.trade_in.hst_registrant" type="checkbox" /> HST registrant</label>
                    </div>
                    <p v-else class="mt-3 text-sm text-gray-500">Trade-in fields are disabled because Trade-in is NO.</p>
                </section>

                <section class="card">
                    <h2 class="card-title">Dealer Guaranty and Third-Party Warranty</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <label class="check"><input v-model="form.data.dealer_guaranty.enabled" type="checkbox" /> Is there a dealer guaranty? YES</label>
                        <div><InputLabel value="Days" /><input v-model="form.data.dealer_guaranty.days" :disabled="!form.data.dealer_guaranty.enabled" type="number" class="input" /></div>
                        <div><InputLabel value="KM" /><input v-model="form.data.dealer_guaranty.km" :disabled="!form.data.dealer_guaranty.enabled" type="number" class="input" /></div>
                        <div><InputLabel value="Description" /><input v-model="form.data.dealer_guaranty.description" :disabled="!form.data.dealer_guaranty.enabled" class="input" /></div>
                        <label class="check"><input v-model="form.data.third_party_warranty.enabled" type="checkbox" /> Is there a third-party warranty? YES</label>
                        <div><InputLabel value="Retail value" /><input v-model="form.data.third_party_warranty.retail_value" :disabled="!form.data.third_party_warranty.enabled" type="number" class="input" /></div>
                        <div><InputLabel value="Company" /><input v-model="form.data.third_party_warranty.company" :disabled="!form.data.third_party_warranty.enabled" class="input" /></div>
                        <div><InputLabel value="Months or KM" /><input v-model="form.data.third_party_warranty.months" :disabled="!form.data.third_party_warranty.enabled" class="input" /></div>
                        <div><InputLabel value="KM" /><input v-model="form.data.third_party_warranty.km" :disabled="!form.data.third_party_warranty.enabled" type="number" class="input" /></div>
                        <div class="md:col-span-3"><InputLabel value="Description" /><input v-model="form.data.third_party_warranty.description" :disabled="!form.data.third_party_warranty.enabled" class="input" /></div>
                    </div>
                </section>

                <section class="card">
                    <h2 class="card-title">Terms of Settlement</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div v-for="field in [
                            ['sale_price', 'Sale price'], ['extended_warranty', 'Extended warranty'], ['anti_rust_module', 'Anti rust module'], ['safety_e_test', 'Safety & E-Test'], ['finance_fee', 'Finance fee'], ['omvic', 'OMVIC'], ['trade_in_allowance', 'Trade-in allowance'], ['licence_fee', 'Licence fee'], ['gasoline', 'Gasoline'], ['payout_lien_on_trade_in', 'Payout lien on trade-in'], ['hst_payable_on_trade_in', 'HST payable on trade-in'], ['deposit', 'Deposit'], ['insurance', 'Insurance'], ['hst_on_insurance', 'HST on insurance'], ['lien_registration_fee', 'Lien registration fee'], ['cost_of_borrowing', 'Cost of borrowing']
                        ]" :key="field[0]"><InputLabel :value="field[1]" /><input v-model="form.data.settlement[field[0]]" type="number" min="0" step="0.01" class="input" /></div>
                        <div><InputLabel value="HST rate" /><input v-model="form.data.settlement.hst_rate" type="number" min="0" max="1" step="0.0001" class="input" /></div>
                        <div><InputLabel value="HST calculation basis" /><select v-model="form.data.settlement.hst_method" class="input"><option value="net_difference">HST on net difference</option><option value="subtotal">HST on subtotal</option></select></div>
                        <div><InputLabel value="Deposit payment method" /><select v-model="form.data.settlement.payment_method" class="input"><option value="cash">Cash</option><option value="cheque">Cheque</option><option value="credit_card">Credit Card</option></select></div>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-4 border-t pt-4 md:grid-cols-4">
                        <div v-for="field in [
                            ['subtotal_hst_taxable', 'Sub-total HST taxable'], ['net_difference', 'Net difference'], ['hst_on_net_difference', 'HST on net difference'], ['hst_on_subtotal', 'HST on sub-total'], ['balance_due', 'Balance due'], ['payable_on_delivery', 'Payable on delivery'], ['balance_financed_subject_to_approval', 'Balance financed subject to approval'], ['net_amount_to_be_financed', 'Net amount to be financed'], ['total_balance_due', 'Total balance due']
                        ]" :key="field[0]"><InputLabel :value="field[1]" /><div class="calculated">{{ form.data.settlement[field[0]] }}</div></div>
                    </div>
                    <p class="mt-4 text-xs text-gray-500">Calculated values use the configured HST rate and the selected HST basis. Review them against the transaction before finalizing.</p>
                </section>

                <section class="card">
                    <h2 class="card-title">Terms of Financing</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                        <div><InputLabel value="Amount of payments" /><input v-model="form.data.financing.amount_of_payments" type="number" min="0" step="0.01" class="input" /></div>
                        <div><InputLabel value="Number of payments" /><input v-model="form.data.financing.number_of_payments" type="number" min="0" class="input" /></div>
                        <div><InputLabel value="Payments start on" /><input v-model="form.data.financing.payments_start_on" type="date" class="input" /></div>
                        <div><InputLabel value="Credit approval" /><select v-model="form.data.financing.credit_approval" class="input"><option value="">Select</option><option>YES</option><option>NO</option></select></div>
                        <div><InputLabel value="Financing incentive" /><select v-model="form.data.financing.incentive" class="input"><option value="">Select</option><option>YES</option><option>NO</option></select></div>
                    </div>
                    <label class="mt-4 check"><input v-model="form.data.financing.customer_received_disclosure" type="checkbox" /> Customer has received the financing disclosure statement from the lending institution.</label>
                </section>

                <section class="card">
                    <h2 class="card-title">Comments</h2>
                    <textarea v-model="form.data.comments" rows="6" class="input" placeholder="Identify any items, inducements or specific repairs included in the sale price and indicate retail value of items or inducements."></textarea>
                </section>

                <section class="card">
                    <h2 class="card-title">Salesperson and Vendor's Acceptance</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div><InputLabel value="Salesperson's name" /><input v-model="form.data.salesperson.name" class="input" /></div>
                        <div><InputLabel value="Salesperson registration number" /><input v-model="form.data.salesperson.registration_number" class="input" /></div>
                        <div><InputLabel value="Dealer registration number" /><input v-model="form.data.vendor_acceptance.dealer_registration_number" class="input" /></div>
                        <div><InputLabel value="Name of official" /><input v-model="form.data.vendor_acceptance.official_name" class="input" /></div>
                        <div><InputLabel value="Title" /><input v-model="form.data.vendor_acceptance.title" class="input" /></div>
                        <div><InputLabel value="Acceptor's registration number" /><input v-model="form.data.vendor_acceptance.acceptor_registration_number" class="input" /></div>
                        <div><InputLabel value="Acceptance date" /><input v-model="form.data.vendor_acceptance.date" type="date" class="input" /></div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div><InputLabel value="Salesperson's signature" /><input v-model="form.data.salesperson.signature" class="input" /></div>
                        <div><InputLabel value="Purchaser's signature" /><input v-model="form.data.acknowledgements.purchaser_signature" class="input" /></div>
                        <div><InputLabel value="Purchaser's initials" /><input v-model="form.data.purchaser.initials" class="input" /></div>
                    </div>
                    <label class="mt-4 check"><input v-model="form.data.acknowledgements.privacy_consent" type="checkbox" /> Purchaser acknowledges the privacy statement and consent to future contact/sharing described in the approved form.</label>
                </section>
            </div>
            <div class="mt-6 flex justify-end gap-3"><SecondaryButton type="button" @click="preview">Preview Bill of Sale</SecondaryButton><PrimaryButton type="button" @click="print">Print Bill of Sale</PrimaryButton></div>
        </section>

        <section v-else class="bill-of-sale-preview-wrap">
            <div class="preview-toolbar print:hidden">
                <SecondaryButton type="button" @click="edit">Back to editor</SecondaryButton>
                <PrimaryButton type="button" :disabled="pdfLoading || !pdfUrl" @click="print">Print Bill of Sale</PrimaryButton>
            </div>
            <div v-if="pdfLoading" class="pdf-status">Generating the approved Retail Bill of Sale PDF…</div>
            <div v-else-if="pdfError" class="pdf-status pdf-error">{{ pdfError }}</div>
            <iframe v-else :src="pdfUrl" class="retail-pdf-preview" title="Retail Bill of Sale PDF preview"></iframe>
        </section>
    </AdminLayout>
</template>

<style scoped>
.card { @apply rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-200; }
.card-title { @apply mb-4 text-lg font-semibold text-gray-900; }
.input { @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500; }
.check { @apply flex items-center gap-2 text-sm text-gray-700; }
.calculated { @apply mt-1 rounded-md bg-gray-50 px-3 py-2 font-semibold text-gray-800 ring-1 ring-gray-200; }
.preview-toolbar { @apply mx-auto flex max-w-[612pt] justify-end gap-3 px-4 py-6; }
.pdf-status { @apply mx-auto flex min-h-[50vh] max-w-[612pt] items-center justify-center bg-white p-8 text-sm text-gray-600 shadow-sm; }
.pdf-error { @apply text-red-700; }
.retail-pdf-preview { display: block; width: 612pt; height: 1680pt; max-width: 100%; margin: 0 auto 24px; border: 0; background: white; box-shadow: 0 2px 12px rgb(0 0 0 / 12%); }

@media print {
    .bill-of-sale-preview-wrap { display: none !important; }
}
</style>

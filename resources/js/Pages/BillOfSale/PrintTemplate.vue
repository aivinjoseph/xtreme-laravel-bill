<script setup>
import { computed } from 'vue';
import { formatCurrency } from './calculations.js';

const props = defineProps({
    data: { type: Object, required: true },
    dealer: { type: Object, default: () => ({}) },
    car: { type: Object, default: () => ({}) },
});

const d = computed(() => props.data);
const dealerInfo = computed(() => ({ ...props.dealer, ...(d.value.dealer || {}) }));
const v = (section, key, fallback = '') => d.value?.[section]?.[key] ?? fallback;
const section = (name) => d.value?.[name] ?? {};
const s = (key) => formatCurrency(v('settlement', key, 0));
const distance = (vehicle) => `${vehicle?.distance_travelled ?? ''} ${vehicle?.mileage_unit === 'mi' ? 'MILES' : 'KMS.'}`.trim();
const checked = (value) => value ? '☒' : '☐';
</script>

<template>
    <div class="bos-document">
        <article class="bos-page bos-page-one">
            <header class="bos-header">
                <div class="dealer-name">{{ dealerInfo.name || ' ' }}</div>
                <div class="dealer-contact">{{ dealerInfo.address || ' ' }}<br />{{ dealerInfo.phone || ' ' }} {{ dealerInfo.email || '' }}</div>
                <div class="document-title">RETAIL BILL OF SALE</div>
                <div class="document-date">DATE: ____ / ____ / ______</div>
            </header>

            <section class="bos-box purchaser-box">
                <h2>PURCHASER'S INFORMATION</h2>
                <div class="line-grid purchaser-grid">
                    <div><b>PURCHASER'S NAME:</b> {{ v('purchaser', 'first_name') }} {{ v('purchaser', 'middle_initial') }} {{ v('purchaser', 'last_name') }}</div>
                    <div><b>ADDRESS:</b> {{ v('purchaser', 'address') }}</div>
                    <div><b>CITY / TOWN:</b> {{ v('purchaser', 'city') }}</div>
                    <div><b>PROVINCE:</b> {{ v('purchaser', 'province') }}</div>
                    <div><b>POSTAL CODE:</b> {{ v('purchaser', 'postal_code') }}</div>
                    <div><b>HOME TELEPHONE No.:</b> {{ v('purchaser', 'home_phone') }}</div>
                    <div><b>BUSINESS TELEPHONE No.:</b> {{ v('purchaser', 'business_phone') }}</div>
                    <div><b>DRIVER'S LICENCE No.:</b> {{ v('purchaser', 'driver_licence_number') }}</div>
                    <div><b>EXPIRY DATE:</b> {{ v('purchaser', 'driver_licence_expiry') }}</div>
                    <div class="wide"><b>E-MAIL ADDRESS:</b> {{ v('purchaser', 'email') }}</div>
                </div>
            </section>

            <section class="bos-box vehicle-box">
                <h2>VEHICLE INFORMATION</h2>
                <div class="line-grid vehicle-grid">
                    <div><b>YEAR</b> {{ v('vehicle', 'year') }}</div><div><b>MAKE</b> {{ v('vehicle', 'make') }}</div><div><b>MODEL</b> {{ v('vehicle', 'model') }}</div>
                    <div><b>TRIM LEVEL</b> {{ v('vehicle', 'trim') }}</div><div><b>COLOUR</b> {{ v('vehicle', 'colour') }}</div><div><b>STOCK #</b> {{ v('vehicle', 'stock_number') }}</div>
                    <div class="wide"><b>V.I.N. #</b> {{ v('vehicle', 'vin') }}</div>
                    <div><b>DISTANCE TRAVELLED</b> {{ distance(section('vehicle')) }}</div><div><b>CONDITION</b> {{ v('vehicle', 'condition') }}</div><div><b>DELIVERY DATE</b> {{ v('vehicle', 'delivery_date') }}</div>
                    <div class="wide"><b>DETAILS OF DELIVERY</b> {{ v('vehicle', 'delivery_details') }}</div>
                </div>
                <div class="options"><span>{{ checked(v('vehicle', 'distance_unknown')) }} DISTANCE UNKNOWN</span><span>{{ checked(v('vehicle', 'true_distance_higher')) }} TRUE DISTANCE BELIEVED TO BE HIGHER</span><span>{{ checked(v('vehicle', 'as_is')) }} VEHICLE SOLD “AS IS”</span></div>
                <div class="options"><span>SAFETY STANDARDS CERTIFICATE: <b>{{ v('vehicle', 'safety_certificate').toUpperCase() }}</b></span><span>CERTIFICATE NUMBER: {{ v('vehicle', 'certificate_number') }}</span><span>CAMVAP: {{ v('vehicle', 'camvap') }}</span></div>
            </section>

            <section class="bos-box insurance-box">
                <h2>INSURANCE INFORMATION</h2>
                <div class="line-grid insurance-grid">
                    <div><b>NAME OF INSURANCE COMPANY</b> {{ v('insurance', 'company') }}</div><div><b>POLICY NO.</b> {{ v('insurance', 'policy_number') }}</div><div><b>EXPIRY DATE</b> {{ v('insurance', 'expiry_date') }}</div>
                    <div class="wide"><b>INSURANCE AGENT & PHONE NO.</b> {{ v('insurance', 'agent') }} {{ v('insurance', 'agent_phone') }}</div>
                </div>
            </section>

            <section class="bos-box trade-box">
                <h2>VEHICLE TO BE TRADED-IN</h2>
                <div v-if="v('trade_in', 'enabled')" class="line-grid trade-grid">
                    <div><b>YEAR</b> {{ v('trade_in', 'year') }}</div><div><b>MAKE</b> {{ v('trade_in', 'make') }}</div><div><b>MODEL</b> {{ v('trade_in', 'model') }}</div><div><b>TRIM LEVEL</b> {{ v('trade_in', 'trim') }}</div><div><b>COLOUR</b> {{ v('trade_in', 'colour') }}</div>
                    <div class="wide"><b>V.I.N. #</b> {{ v('trade_in', 'vin') }}</div><div><b>DISTANCE TRAVELLED</b> {{ distance(section('trade_in')) }}</div><div><b>LIEN</b> {{ v('trade_in', 'lien') ? 'YES' : 'NO' }}</div>
                    <div class="wide"><b>EXACT DISTANCE THAT THE VEHICLE HAS TRAVELLED</b> {{ v('trade_in', 'exact_distance') }}</div><div><b>HST STATUS</b> {{ v('trade_in', 'hst_registrant') ? 'REGISTRANT' : (v('trade_in', 'hst_non_registrant') ? 'NON-REGISTRANT' : '') }}</div>
                </div>
                <div v-else class="empty-trade">TRADE-IN: NO</div>
            </section>

            <section class="bos-box warranty-box">
                <h2>DEALER GUARANTY / THIRD-PARTY WARRANTY</h2>
                <div class="line-grid warranty-grid">
                    <div><b>DEALER GUARANTY:</b> {{ v('dealer_guaranty', 'enabled') ? 'YES' : 'NO' }}</div><div><b>DAYS</b> {{ v('dealer_guaranty', 'days') }}</div><div><b>KM</b> {{ v('dealer_guaranty', 'km') }}</div><div class="wide"><b>DESCRIPTION</b> {{ v('dealer_guaranty', 'description') }}</div>
                    <div><b>THIRD-PARTY WARRANTY:</b> {{ v('third_party_warranty', 'enabled') ? 'YES' : 'NO' }}</div><div><b>RETAIL VALUE</b> {{ formatCurrency(v('third_party_warranty', 'retail_value', 0)) }}</div><div><b>COMPANY</b> {{ v('third_party_warranty', 'company') }}</div><div><b>MONTHS / KM</b> {{ v('third_party_warranty', 'months') }} {{ v('third_party_warranty', 'km') }}</div>
                    <div class="wide"><b>DESCRIPTION</b> {{ v('third_party_warranty', 'description') }}</div>
                </div>
            </section>

            <section class="bos-box settlement-box">
                <h2>TERMS OF SETTLEMENT</h2>
                <div class="settlement-grid">
                    <div><span>SALE PRICE</span><b>{{ s('sale_price') }}</b></div><div><span>EXTENDED WARRANTY</span><b>{{ s('extended_warranty') }}</b></div><div><span>ANTI RUST MODULE</span><b>{{ s('anti_rust_module') }}</b></div><div><span>SAFETY &amp; E-TEST</span><b>{{ s('safety_e_test') }}</b></div><div><span>FINANCE FEE</span><b>{{ s('finance_fee') }}</b></div><div><span>OMVIC</span><b>{{ s('omvic') }}</b></div>
                    <div><span>SUB-TOTAL HST TAXABLE</span><b>{{ s('subtotal_hst_taxable') }}</b></div><div><span>TRADE-IN ALLOWANCE</span><b>{{ s('trade_in_allowance') }}</b></div><div><span>NET DIFFERENCE</span><b>{{ s('net_difference') }}</b></div><div><span>HST ON NET DIFFERENCE</span><b>{{ s('hst_on_net_difference') }}</b></div><div><span>HST ON SUB-TOTAL</span><b>{{ s('hst_on_subtotal') }}</b></div><div><span>LICENCE FEE</span><b>{{ s('licence_fee') }}</b></div>
                    <div><span>GASOLINE</span><b>{{ s('gasoline') }}</b></div><div><span>PAYOUT LIEN ON TRADE-IN</span><b>{{ s('payout_lien_on_trade_in') }}</b></div><div><span>HST PAYABLE ON TRADE-IN</span><b>{{ s('hst_payable_on_trade_in') }}</b></div><div><span>BALANCE DUE</span><b>{{ s('balance_due') }}</b></div><div><span>DEPOSIT</span><b>{{ s('deposit') }}</b></div><div><span>PAYABLE ON DELIVERY</span><b>{{ s('payable_on_delivery') }}</b></div>
                    <div><span>INSURANCE</span><b>{{ s('insurance') }}</b></div><div><span>HST ON INSURANCE</span><b>{{ s('hst_on_insurance') }}</b></div><div><span>LIEN REGISTRATION FEE</span><b>{{ s('lien_registration_fee') }}</b></div><div><span>BALANCE FINANCED SUBJECT TO APPROVAL</span><b>{{ s('balance_financed_subject_to_approval') }}</b></div><div><span>NET AMOUNT TO BE FINANCED</span><b>{{ s('net_amount_to_be_financed') }}</b></div><div><span>COST OF BORROWING</span><b>{{ s('cost_of_borrowing') }}</b></div>
                    <div class="total"><span>TOTAL BALANCE DUE</span><b>{{ s('total_balance_due') }}</b></div>
                </div>
                <div class="settlement-footer">DEPOSIT: {{ v('settlement', 'payment_method', '').replace('_', ' ').toUpperCase() }} &nbsp;&nbsp; TERMS OF FINANCING: AMOUNT OF PAYMENTS {{ v('financing', 'amount_of_payments') }} &nbsp;&nbsp; NO. OF PAYMENTS {{ v('financing', 'number_of_payments') }} &nbsp;&nbsp; PAYMENTS START ON {{ v('financing', 'payments_start_on') }} &nbsp;&nbsp; CREDIT APPROVAL {{ v('financing', 'credit_approval') }}</div>
            </section>

            <section class="bos-box comments-box"><h2>COMMENTS</h2><div class="comments">{{ d.comments }}</div></section>

            <section class="ack-text"><b>VEHICLE SOLD “AS IS”:</b> The motor vehicle sold under this contract is being sold “as-is” and is not represented as being in roadworthy condition, mechanically sound or maintained at any guaranteed level of quality. The vehicle may not be fit for use as a means of transportation and may require substantial repairs at the purchaser’s expense. It may not be possible to register the vehicle to be driven in its current condition.<br /><b>ACKNOWLEDGE HAVING READ ALL THE TERMS OF THE CONTRACT INCLUDING THOSE ON THE REVERSE AND ON ATTACHED PAGES. YOU UNDERSTAND THESE TERMS MAKE UP THE ENTIRE CONTRACT.</b><br /><b>SALES FINAL:</b> Please review the entire contract, including all attached statements, before signing. This contract is final and binding once you have signed it, unless the motor vehicle dealer has failed to comply with certain legal obligations.<br /><b>PRIVACY STATEMENT:</b> By signing this contract you consent to the dealer contacting you in the future and to the sharing of information with associated businesses so that they may provide you with timely information about their services. You may withdraw your consent in writing at any time.</section>

            <section class="bos-signatures"><div><b>SALESPERSON'S NAME (PLEASE PRINT)</b> {{ v('salesperson', 'name') }}<br /><b>REGISTRATION NO.</b> {{ v('salesperson', 'registration_number') }}<br /><b>SALESPERSON'S SIGNATURE</b> {{ v('salesperson', 'signature') }}</div><div><b>VENDOR'S ACCEPTANCE</b><br /><b>DEALER REGISTRATION NO.</b> {{ v('vendor_acceptance', 'dealer_registration_number') }}<br /><b>NAME OF OFFICIAL</b> {{ v('vendor_acceptance', 'official_name') }}<br /><b>TITLE</b> {{ v('vendor_acceptance', 'title') }}<br /><b>ACCEPTOR'S REGISTRATION NO.</b> {{ v('vendor_acceptance', 'acceptor_registration_number') }}<br /><b>DATE</b> {{ v('vendor_acceptance', 'date') }}</div></section>
        </article>

        <article class="bos-page bos-page-two">
            <section class="legal-section"><h1>IMPORTANT INFORMATION RESPECTING MOTOR VEHICLE SALES</h1><p>In case of any concerns with this sale, you should first contact your motor vehicle dealer. For concerns designated for administering the Motor Vehicle Dealers Act, 2002, you may be eligible for compensation from the Motor Vehicle Dealers Compensation Fund, if you suffer financial loss from this trade and if your dealer is unable or unwilling to make good on the loss. You may have additional rights at law. Contact OMVIC at 1-800-943-6002 or www.omvic.on.ca</p></section>
            <section class="legal-section"><h1>SAFETY STANDARDS CERTIFICATE</h1><p>A safety standards certificate is only an indication that the motor vehicle met certain basic standards of vehicle safety on the date of inspection.</p></section>
            <section class="legal-section"><h1>TERMS AND CONDITIONS</h1><h2>TRADE-IN VEHICLE</h2><p>Any vehicle you trade-in shall be equipped and in the same condition, other than reasonable wear and tear, at the time of delivery to the dealer as it was at the date of this agreement. You agree to be responsible for any repairs or maintenance needed to maintain this condition until the delivery date. If the trade-in vehicle has been damaged between the date of this agreement and the delivery date, or is in need of repair, the dealer may cancel this agreement and deduct any damages from the deposit or, if you agree, may reduce the amount of the trade-in allowance to compensate for the repairs needed. You also agree that you will be liable to compensate the dealer for any loss suffered by the dealer because of any misrepresentation about the declared distance travelled, the declared prior use, or the condition of the vehicle traded-in.</p></section>
            <section class="legal-section"><h2>TAXES AND FINANCING</h2><p>You agree to pay the dealer an amount equal to any increase in taxes payable relating to the purchase of the vehicle, between the date of this agreement and delivery of the vehicle to you. Should the amount of tax payable be reduced, the dealer agrees to deduct this amount from the total amount owed by you. You agree that you will be responsible for any damages suffered by the dealer if financing contract cannot be arranged because of any default or misrepresentation by you.</p></section>
            <section class="legal-section"><h2>LEGAL OWNERSHIP AND PURCHASER'S OBLIGATIONS</h2><p>The dealer shall remain the legal owner of the vehicle until the purchase price has been paid in full. You agree that until that time, you shall:</p><ol><li>maintain insurance on the vehicle with the dealer as the named beneficiary in the event of a loss;</li><li>not sell or transfer the vehicle to anyone else;</li><li>not allow any lien or other interest to be taken in or against the vehicle;</li><li>not allow the vehicle to be used in the commission of any illegal act; and</li><li>reimburse the dealer for any costs the dealer may incur due to your failure to comply with any of (a), (b), (c) or (d) above.</li></ol></section>
            <section class="legal-section"><h2>ACCEPTANCE BY PURCHASER</h2><p>If you refuse to take delivery of the vehicle when it is made available to you, or on the delivery date specified in this agreement, the dealer shall notify you, by registered mail, sent to your last address known to the dealer, that the vehicle is available for delivery. If you fail to take delivery of the vehicle within seven days of signed receipt of this notice, or if the notice is returned to the dealer unclaimed, the dealer may resell the vehicle with no further notice to you. When the dealer resells the vehicle, you agree to pay the dealer for all losses the dealer incurs. Any deposit or vehicle traded-in may be kept by the dealer to apply against any loss suffered by the dealer. If the loss is greater than the total of the amount paid as deposit and the value of the trade-in, you agree to pay the difference to the dealer. The dealer agrees to provide you with detailed accounting of the resale and list of expenses incurred. The dealer shall maintain the right to use any legal means available to collect any sum owing by you under this agreement.</p></section>
            <section class="legal-section"><h2>CANADIAN MOTOR VEHICLE ARBITRATION PLAN</h2><p>The Canadian Motor Vehicle Arbitration Plan may be available to resolve disputes concerning alleged manufacturer's defects or implementation of the manufacturer's new motor vehicle warranty.</p><p><b>FOR CANADIAN MOTOR VEHICLE ARBITRATION PLAN NOT AVAILABLE</b><br />The manufacturer of this vehicle is not a participant in the Canadian Motor Vehicle Arbitration Plan. Manufacturer's defects or implementation of the manufacturer's new motor vehicle warranty. Currently BMW, Mitsubishi and most exotic foreign sports car manufacturers, do not participate in CAMVAP. Further information can be found at www.camvap.ca</p></section>
            <footer class="page-two-footer">Purchaser's initials: {{ v('purchaser', 'initials') }} &nbsp;&nbsp; Purchaser's signature: {{ v('acknowledgements', 'purchaser_signature') }}</footer>
        </article>
    </div>
</template>

<style>
.bos-document { color: #111; font-family: Arial, Helvetica, sans-serif; }
.bos-page { box-sizing: border-box; position: relative; width: 612pt; min-height: 840pt; margin: 0 auto; overflow: hidden; background: #fff; font-size: 6.2pt; line-height: 1.15; }
.bos-page-one { padding: 18pt; }
.bos-header { position: relative; height: 46pt; border-bottom: 1pt solid #111; }
.dealer-name { font-size: 10pt; font-weight: 700; text-transform: uppercase; }
.dealer-contact { font-size: 6pt; margin-top: 2pt; }
.document-title { position: absolute; top: 0; left: 240pt; font-size: 12pt; font-weight: 700; }
.document-date { position: absolute; right: 0; bottom: 4pt; }
.bos-box { position: relative; border: .7pt solid #111; margin-top: 4pt; padding: 12pt 4pt 3pt; }
.bos-box h2 { position: absolute; top: -1pt; left: 4pt; margin: 0; padding: 0 2pt; background: #fff; font-size: 7.2pt; font-weight: 700; }
.purchaser-box { height: 83pt; }
.vehicle-box { height: 105pt; }
.insurance-box { height: 37pt; }
.trade-box { height: 53pt; }
.warranty-box { height: 50pt; }
.settlement-box { height: 118pt; }
.comments-box { height: 54pt; }
.line-grid { display: grid; gap: 2pt 4pt; }
.line-grid > div { border-bottom: .35pt solid #777; min-height: 9pt; overflow: hidden; white-space: nowrap; }
.line-grid b, .bos-signatures b { font-size: 5.2pt; }
.purchaser-grid { grid-template-columns: 1.2fr 1fr 1fr; }
.purchaser-grid .wide, .vehicle-grid .wide, .insurance-grid .wide, .trade-grid .wide, .warranty-grid .wide { grid-column: span 2; }
.vehicle-grid { grid-template-columns: repeat(6, 1fr); }
.vehicle-grid > div:nth-child(7), .vehicle-grid > div:last-child { grid-column: span 6; }
.insurance-grid { grid-template-columns: 1.7fr 1fr 1fr; }
.trade-grid { grid-template-columns: repeat(5, 1fr); }
.warranty-grid { grid-template-columns: 1.4fr .7fr .7fr 1.6fr; }
.options { display: flex; gap: 12pt; margin-top: 3pt; white-space: nowrap; font-size: 5.4pt; }
.empty-trade { padding-top: 8pt; font-weight: 700; }
.settlement-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1pt 4pt; }
.settlement-grid > div { display: flex; justify-content: space-between; border-bottom: .35pt solid #777; min-height: 8pt; gap: 3pt; }
.settlement-grid span { font-size: 5.2pt; }
.settlement-grid b { white-space: nowrap; font-size: 6pt; }
.settlement-grid .total { grid-column: span 3; border-top: 1pt solid #111; border-bottom: 1pt solid #111; padding: 2pt 0; font-size: 7pt; }
.settlement-footer { margin-top: 3pt; border-top: .35pt solid #777; padding-top: 2pt; font-size: 5pt; white-space: nowrap; overflow: hidden; }
.comments { white-space: pre-wrap; height: 42pt; overflow: hidden; padding: 1pt 2pt; }
.ack-text { margin-top: 3pt; font-size: 5.1pt; line-height: 1.06; }
.bos-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 8pt; margin-top: 4pt; border-top: .7pt solid #111; padding-top: 3pt; font-size: 5.5pt; line-height: 1.5; }
.bos-page-two { padding: 22pt 28pt; page-break-before: always; break-before: page; font-size: 6.7pt; line-height: 1.1; }
.legal-section { margin-bottom: 6pt; }
.legal-section h1 { font-size: 8.8pt; margin: 0 0 2pt; text-align: center; font-weight: 700; }
.legal-section h2 { font-size: 7.5pt; margin: 3pt 0 2pt; font-weight: 700; }
.legal-section p { margin: 0 0 3pt; text-align: justify; }
.legal-section ol { margin: 2pt 0 0 18pt; padding: 0; }
.legal-section li { padding-left: 2pt; margin-bottom: 1pt; }
.page-two-footer { position: absolute; left: 28pt; right: 28pt; bottom: 18pt; border-top: .7pt solid #111; padding-top: 4pt; font-size: 7pt; }

@media screen {
    .bos-document { padding: 24px 0; background: #e5e7eb; }
    .bos-page { box-shadow: 0 2px 12px rgb(0 0 0 / 12%); margin-bottom: 24px; }
}

@media print {
    @page { size: letter portrait; margin: 0; }
    html, body { margin: 0 !important; padding: 0 !important; background: #fff !important; }
    .bos-document { padding: 0; }
    .bos-page { margin: 0; box-shadow: none; }
    .bos-page-one { page-break-after: always; break-after: page; }
}
</style>

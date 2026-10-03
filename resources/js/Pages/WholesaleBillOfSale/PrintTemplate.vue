<script setup>
import { computed } from 'vue';
import { formatCurrency } from './calculations.js';

const props = defineProps({
    data: { type: Object, required: true },
});

const d = computed(() => props.data);
const v = (section, key, fallback = '') => d.value?.[section]?.[key] ?? fallback;
const party = (name) => d.value?.[name] ?? {};
const financial = computed(() => d.value?.financial ?? {});
const disclosures = computed(() => d.value?.disclosures ?? {});
const searches = computed(() => d.value?.searches ?? {});
const vehicle = computed(() => d.value?.vehicle ?? {});
const years = ['2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020'];
const vinDigits = ['5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L'];
const isSelected = (value) => String(value).toLowerCase() === String(d.value?.vin_tenth_digit ?? '').toLowerCase();
const isChecked = (value) => Boolean(value);
const distanceUnit = (unit) => unit === 'mi' ? 'MILES' : 'KMS';
const dateText = (value) => value ? String(value).replaceAll('-', ' / ') : '____ / ____ / ______';
</script>

<template>
    <div class="wholesale-document">
        <article class="wholesale-page wholesale-page-one">
            <div class="vin-decoder">
                <div class="vin-label">VIN: 10<sup>TH</sup><br />DIGIT</div>
                <div v-for="year in years" :key="year" class="decoder-cell" :class="{ selected: String(vehicle.year) === year }"><b>{{ year }}</b><span>{{ vinDigits[years.indexOf(year)] }}</span></div>
            </div>
            <div class="form-code">37145 WHOLESALE</div>

            <header class="wholesale-header">
                <div class="ucda">UCDA</div>
                <div class="wholesale-title">WHOLESALE BILL OF SALE</div>
                <div class="date-line">DATE: <span>{{ dateText(d.date) }}</span></div>
            </header>

            <section class="party-grid">
                <div class="party-block">
                    <h2>SELLER</h2>
                    <div class="line"><b>MVDA REG #</b><span>{{ party('seller').mvda_registration_number }}</span></div>
                    <div class="line"><b>NAME</b><span>{{ party('seller').name }}</span></div>
                    <div class="line"><b>ADDRESS</b><span>{{ party('seller').address }}</span></div>
                    <div class="line"><b>CITY / PROV / PC</b><span>{{ party('seller').city_province_postal }}</span></div>
                    <div class="split-lines"><div class="line"><b>TEL #</b><span>{{ party('seller').telephone }}</span></div><div class="line"><b>FAX #</b><span>{{ party('seller').fax }}</span></div></div>
                </div>
                <div class="party-block">
                    <h2>PURCHASER</h2>
                    <div class="line"><b>MVDA REG #</b><span>{{ party('purchaser').mvda_registration_number }}</span></div>
                    <div class="line"><b>NAME</b><span>{{ party('purchaser').name }}</span></div>
                    <div class="line"><b>ADDRESS</b><span>{{ party('purchaser').address }}</span></div>
                    <div class="line"><b>CITY / PROV / PC</b><span>{{ party('purchaser').city_province_postal }}</span></div>
                    <div class="split-lines"><div class="line"><b>TEL #</b><span>{{ party('purchaser').telephone }}</span></div><div class="line"><b>FAX #</b><span>{{ party('purchaser').fax }}</span></div></div>
                </div>
            </section>

            <section class="vehicle-financial">
                <div class="vehicle-table">
                    <div class="vehicle-top">
                        <div><b>STOCK #</b><span>{{ vehicle.stock_number }}</span></div><div><b>YEAR</b><span>{{ vehicle.year }}</span></div><div><b>MAKE</b><span>{{ vehicle.make }}</span></div><div><b>MODEL</b><span>{{ vehicle.model }}</span></div><div><b>COLOUR</b><span>{{ vehicle.colour }}</span></div><div><b>TRIM LEVEL</b><span>{{ vehicle.trim_level }}</span></div><div><b>GAS / DIESEL / HYBRID</b><span>{{ vehicle.fuel }}</span></div>
                    </div>
                    <div class="vehicle-bottom">
                        <div class="vin-field"><b>SERIAL OR V.I.N. #</b><span>{{ vehicle.vin }}</span></div>
                        <div class="distance-field"><b>DISTANCE TRAVELLED</b><span>{{ vehicle.distance_travelled }}</span></div>
                        <div class="unit-field"><span class="radio" :class="{ selected: vehicle.mileage_unit === 'km' }"></span>KMS<br /><span class="radio" :class="{ selected: vehicle.mileage_unit === 'mi' }"></span>MILES</div>
                    </div>
                </div>
                <div class="financial-box">
                    <div class="money-row money-price"><b>PRICE</b><strong>{{ formatCurrency(financial.price) }}</strong></div>
                    <div class="money-row"><b>HST</b><strong>{{ formatCurrency(financial.hst) }}</strong></div>
                    <div class="money-row"><b>LICENCING</b><strong>{{ formatCurrency(financial.licencing) }}</strong></div>
                    <div class="money-row total"><b>TOTAL</b><strong>{{ formatCurrency(financial.total) }}</strong></div>
                </div>
            </section>

            <section class="dealer-financial-grid">
                <div class="dealer-info">
                    <div class="dealer-column">
                        <h3>SELLING DEALER'S INFORMATION</h3>
                        <div class="line"><b>Salesperson’s Registration #</b><span>{{ party('seller').salesperson_registration_number }}</span></div>
                        <div class="line"><b>Salesperson’s Name</b><span>{{ party('seller').salesperson_name }}</span></div>
                        <div class="line"><b>Signature</b><span>{{ party('seller').signature }}</span></div>
                        <div class="line"><b>HST Registration #</b><span>{{ party('seller').hst_registration_number }}</span></div>
                    </div>
                    <div class="dealer-column">
                        <h3>PURCHASING DEALER'S INFORMATION</h3>
                        <div class="line"><b>Salesperson’s Registration #</b><span>{{ party('purchaser').salesperson_registration_number }}</span></div>
                        <div class="line"><b>Salesperson’s Name</b><span>{{ party('purchaser').salesperson_name }}</span></div>
                        <div class="line"><b>Signature</b><span>{{ party('purchaser').signature }}</span></div>
                        <div class="line"><b>HST Registration #</b><span>{{ party('purchaser').hst_registration_number }}</span></div>
                    </div>
                </div>
                <div class="agreement"><b>TERMS OF THIS AGREEMENT:</b><p>The buyer and seller acknowledge having read the terms of the contract, including those on the reverse and understand and agree that the written terms on this contract form the entire agreement.</p></div>
            </section>

            <section class="searches section-block">
                <h2>SEARCHES PROVIDED</h2>
                <div class="search-grid">
                    <span><i class="check-box" :class="{ selected: isChecked(searches.ucda_lien) }"></i> UCDA Lien Search &amp; Kwik Check™</span>
                    <span><i class="check-box" :class="{ selected: isChecked(searches.auto_check) }"></i> Auto Check™</span>
                    <span><i class="check-box" :class="{ selected: isChecked(searches.carfax) }"></i> CARFAX™</span>
                    <span><i class="check-box" :class="{ selected: isChecked(searches.out_of_province_lien) }"></i> Out-of-Province Lien Search</span>
                    <span><i class="check-box" :class="{ selected: isChecked(searches.ontario_vehicle_history) }"></i> Ontario Vehicle History Search</span>
                    <span><i class="check-box" :class="{ selected: isChecked(searches.can_check) }"></i> CAN/CHECK™</span>
                </div>
                <div class="search-contact">www.ucdasearches.com or call: 416-599-7412 or 1-800-668-8265</div>
            </section>

            <section class="mandatory section-block">
                <h2>MANDATORY DISCLOSURE STATEMENT AS REQUIRED BY MVDA, 2002</h2>
                <div class="mandatory-grid">
                    <div class="mandatory-left">
                        <div class="brand-row"><b>MTO REGISTRATION BRAND:</b><span><i class="radio" :class="{ selected: d.mto_registration_brand === 'irreparable' }"></i> IRREPARABLE</span><span><i class="radio" :class="{ selected: d.mto_registration_brand === 'rebuilt' }"></i> REBUILT</span><span><i class="radio" :class="{ selected: d.mto_registration_brand === 'salvage' }"></i> SALVAGE</span><span><i class="radio" :class="{ selected: d.mto_registration_brand === 'none' }"></i> NONE</span></div>
                        <div class="odometer-box"><b>DISTANCE TRAVELLED</b><div>IS ODOMETER FAULTY, BROKEN, REPLACED OR ROLLED BACK <span><i class="check-box" :class="{ selected: disclosures.odometer_issue }"></i> Yes</span></div><div>IF YES, SEE SECTION 1 ON REVERSE AND CHECK APPROPRIATE BOX HERE <span><i class="radio" :class="{ selected: disclosures.odometer_section === '1A' }"></i> 1A</span><span><i class="radio" :class="{ selected: disclosures.odometer_section === '1B' }"></i> 1B</span></div><div>IF 1A IS CHECKED SHOW PREVIOUS ODOMETER READING <span class="written">{{ disclosures.previous_odometer_reading }} {{ distanceUnit(disclosures.previous_odometer_unit) }}</span></div><div>AND DATE OF PREVIOUS READING <span class="written">{{ dateText(disclosures.previous_odometer_date) }}</span></div></div>
                        <div class="two-col-disclosures"><div><div>DAILY RENTAL <span><i class="check-box" :class="{ selected: disclosures.daily_rental }"></i> Yes</span></div><div>FIRE DAMAGED <span><i class="check-box" :class="{ selected: disclosures.fire_damaged }"></i> Yes</span></div><div>WATER DAMAGED <span><i class="check-box" :class="{ selected: disclosures.water_damaged }"></i> Yes</span></div></div><div><div>POLICE CRUISER <span><i class="check-box" :class="{ selected: disclosures.police_cruiser }"></i> Yes</span></div><div>EMERG. SERVICES VEHICLE <span><i class="check-box" :class="{ selected: disclosures.emergency_services_vehicle }"></i> Yes</span></div><div>TAXI OR LIMO <span><i class="check-box" :class="{ selected: disclosures.taxi_or_limo }"></i> Yes</span></div></div></div>
                        <div class="disclosure-lines"><div>DOES VEHICLE REQUIRE REPAIRS TO SUSPENSION/SUBFRAME <span><i class="check-box" :class="{ selected: disclosures.suspension_subframe_repairs }"></i> Yes</span></div><div>STRUCTURAL PARTS DAMAGED ALTERED OR REPAIRED <span><i class="check-box" :class="{ selected: disclosures.structural_parts }"></i> Yes</span></div><div>ANY PREVIOUS DAMAGE REPAIRED EXCEEDING $3,000 <span><i class="check-box" :class="{ selected: disclosures.previous_damage_over_3000 }"></i> Yes</span></div><div>HAVE THE MANUFACTURER’S BADGES OR DECALS BEEN CHANGED OR HAVE<br />THE ORIGINAL PRODUCTION SPECIFICATIONS BEEN CHANGED <span><i class="check-box" :class="{ selected: disclosures.badges_or_specs_changed }"></i> Yes</span></div></div>
                    </div>
                    <div class="mandatory-right">
                        <div class="history-box"><b>WITHIN THE LAST SEVEN YEARS WAS THIS AN:</b><div>OUT-OF-PROVINCE VEHICLE <span><i class="check-box" :class="{ selected: disclosures.out_of_province_vehicle }"></i> Yes</span></div><div>U.S. VEHICLE <span><i class="check-box" :class="{ selected: disclosures.us_vehicle }"></i> Yes</span></div><div>IF YES IDENTIFY PROVINCE(S) AND/OR STATE(S):<br /><span class="multi-line">{{ disclosures.jurisdiction_details }}</span></div></div>
                        <div class="right-disclosure-lines"><div>ANTI-LOCK BRAKES INOPERABLE <span><i class="check-box" :class="{ selected: disclosures.anti_lock_brakes }"></i> Yes</span> <span><i class="check-box" :class="{ selected: disclosures.anti_lock_not_applicable }"></i> Not Applicable</span></div><div>AIR BAGS MISSING / INOPERABLE <span><i class="check-box" :class="{ selected: disclosures.air_bags }"></i> Yes</span> <span><i class="check-box" :class="{ selected: disclosures.air_bags_not_applicable }"></i> Not Applicable</span></div><div>POLLUTION CONTROL INOPERABLE <span><i class="check-box" :class="{ selected: disclosures.pollution_control }"></i> Yes</span></div><div class="bold-line">HAS VEHICLE EVER BEEN DECLARED<br />A TOTAL LOSS BY AN INSURER <span><i class="check-box" :class="{ selected: disclosures.total_loss }"></i> Yes</span></div><div>THEFT RECOVERY <span><i class="check-box" :class="{ selected: disclosures.theft_recovery }"></i> Yes</span></div><div>MANUFACTURER’S WARRANTY CANCELLED <span><i class="check-box" :class="{ selected: disclosures.warranty_cancelled }"></i> Yes</span></div><div>ANY BODY PANELS PAINTED OR REPLACED <span><i class="check-box" :class="{ selected: disclosures.body_panels_painted_or_replaced }"></i> Yes</span></div></div>
                    </div>
                </div>
                <div class="other-disclosures"><div>ANY OTHER DISCLOSURES: <span class="written">{{ disclosures.other_disclosures }}</span></div><div>IF YES TO ANY OF THE ABOVE, GIVE DETAILS: <span class="written">{{ disclosures.details }}</span></div><div class="no-disclosures">NO DISCLOSURES ARE REQUIRED TO BE MADE FOR THIS VEHICLE <i class="check-box" :class="{ selected: disclosures.no_disclosures }"></i></div></div>
            </section>

            <footer class="page-one-footer"><span>© 2014 <b>UCDA Used Car Dealers Association Of Ontario</b></span><span>SEE TERMS &amp; CONDITIONS ON REVERSE</span></footer>
        </article>

        <article class="wholesale-page wholesale-page-two">
            <section class="terms">
                <h2>1. DISTANCE TRAVELLED <small>- See distance travelled box on front page</small></h2>
                <p><b>(a).</b> The dealer cannot determine the total distance that the vehicle has been driven but can determine the distance that the vehicle has been driven as of some past date. The total distance that the vehicle has been driven is believed to be higher than the previously recorded distance.</p>
                <div class="or">or</div>
                <p><b>(b).</b> The dealer can determine neither the total distance that the vehicle has been driven, nor the distance that the vehicle has been driven as of some past date. The total distance that this vehicle has been driven is unknown and may be substantially higher than the reading shown on the odometer.</p>
            </section>
            <section class="terms"><h2>2. &nbsp; WARRANTIES AND CONDITIONS</h2><p>No implied conditions or warranties or verbal representations apply to the vehicle described in this agreement. All conditions, warranties, and representations other than those included in writing in this agreement are expressly excluded.</p></section>
            <section class="terms"><h2>3. &nbsp; LIENS</h2><p>The seller warrants that the vehicle described in this agreement is free of any registered or unregistered liens, security interests, judgments, chattel mortgages, or encumbrances of any kind.</p></section>
            <section class="terms"><h2>4. &nbsp; SELLER WARRANTS TITLE</h2><p>The seller warrants to the buyer that the seller has good title to the vehicle, is the legal owner of the vehicle and has the right to sell the vehicle.</p></section>
            <section class="terms"><h2>5. &nbsp; LEGAL OWNERSHIP</h2><p>Legal ownership of the vehicle shall not pass to the buyer until the entire purchase price has been paid in full.</p></section>
            <section class="terms"><h2>6. &nbsp; RIGHT TO REPOSSESS</h2><p>Should the total purchase price as shown on the front of this agreement not be paid in full within three days of the buyer taking delivery, then the seller shall have the right to repossess the vehicle from the buyer without notice. The seller may sell any vehicle repossessed and maintains all legal rights to recover any resulting loss.</p></section>
            <section class="terms"><h2>7. &nbsp; RISK OF DAMAGE</h2><p>All risk of damage to the vehicle is the responsibility of the buyer once delivery has been taken.</p></section>
        </article>
    </div>
</template>

<style>
.wholesale-document { color: #191919; font-family: Arial, Helvetica, sans-serif; }
.wholesale-page { box-sizing: border-box; width: 612pt; min-height: 792pt; margin: 0 auto; position: relative; overflow: hidden; background: #fff; font-size: 6.6pt; line-height: 1.15; }
.wholesale-page-one { padding: 14pt 18pt 10pt; }
.form-code { position: absolute; top: 2pt; right: 0; font-size: 6pt; font-weight: 700; }
.vin-decoder { display: grid; grid-template-columns: 35pt repeat(16, 1fr); height: 22pt; border: .8pt solid #222; margin-bottom: 11pt; }
.vin-label { background: #222; color: #fff; padding: 2pt; font-weight: 700; font-size: 6pt; line-height: 1.05; }
.vin-label sup { font-size: 4pt; }
.decoder-cell { border-left: .5pt solid #999; display: flex; flex-direction: column; text-align: center; font-size: 6.5pt; }
.decoder-cell b { background: #e9e9e9; height: 11pt; }
.decoder-cell span { height: 11pt; }
.decoder-cell.selected b, .decoder-cell.selected span { background: #d8d8d8; }
.wholesale-header { display: flex; align-items: center; height: 34pt; position: relative; }
.ucda { background: #222; color: #fff; border-radius: 5pt; font-family: Georgia, serif; font-size: 18pt; font-weight: 700; padding: 0 5pt; margin-right: 6pt; }
.wholesale-title { font-size: 17pt; font-weight: 800; letter-spacing: -.5pt; }
.date-line { position: absolute; right: 0; bottom: 6pt; font-size: 8pt; }
.date-line span { display: inline-block; min-width: 120pt; border-bottom: .5pt solid #888; text-align: center; }
.party-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24pt; margin-top: 5pt; height: 122pt; }
.party-block h2, .section-block h2 { background: #222; color: #fff; margin: 0; padding: 3pt 5pt; font-size: 8.4pt; }
.party-block h2 { width: 82pt; }
.line { display: flex; align-items: end; min-height: 18pt; gap: 4pt; border-bottom: .45pt solid #aaa; }
.line b { flex: 0 0 auto; font-size: 5.7pt; }
.line span { flex: 1; font-size: 7pt; overflow: hidden; white-space: nowrap; min-height: 8pt; }
.party-block > .line:first-of-type { margin-top: 1pt; }
.split-lines { display: grid; grid-template-columns: 1fr 1fr; gap: 7pt; }
.vehicle-financial { display: grid; grid-template-columns: 1fr 91pt; height: 68pt; border: 1pt solid #222; }
.vehicle-table { min-width: 0; }
.vehicle-top { display: grid; grid-template-columns: 1.05fr .45fr 1.25fr 1.35fr .8fr 1.05fr 1fr; height: 40pt; border-bottom: .7pt solid #222; }
.vehicle-top > div { border-right: .5pt solid #aaa; padding: 3pt; overflow: hidden; }
.vehicle-top b, .vehicle-bottom b { display: block; font-size: 5.7pt; }
.vehicle-top span { display: block; margin-top: 9pt; font-size: 7pt; white-space: nowrap; }
.vehicle-bottom { display: grid; grid-template-columns: 1fr 96pt 26pt; height: 27pt; }
.vehicle-bottom > div { border-right: .5pt solid #aaa; padding: 2pt 3pt; }
.vin-field span, .distance-field span { display: block; margin-top: 8pt; font-size: 7pt; white-space: nowrap; }
.unit-field { line-height: 11pt; font-size: 6pt; padding-left: 3pt !important; }
.financial-box { border-left: 1pt solid #222; }
.money-row { display: flex; justify-content: space-between; align-items: center; height: 17pt; border-bottom: .6pt solid #777; padding: 0 5pt; font-size: 7pt; }
.money-row strong { font-size: 7.2pt; font-weight: 400; }
.money-price { height: 40pt; align-items: start; padding-top: 5pt; }
.money-price strong { font-size: 8pt; }
.money-row.total { background: #222; color: #fff; border-bottom: 0; }
.dealer-financial-grid { display: grid; grid-template-columns: 1fr 91pt; min-height: 105pt; }
.dealer-info { display: grid; grid-template-columns: 1fr 1fr; gap: 18pt; padding-top: 3pt; }
.dealer-column h3 { font-size: 6.8pt; margin: 0 0 2pt; }
.dealer-column .line { min-height: 22pt; display: block; }
.dealer-column .line b, .dealer-column .line span { display: block; }
.dealer-column .line span { min-height: 9pt; margin-top: 3pt; }
.agreement { border-left: 0; padding: 36pt 2pt 0 3pt; font-size: 6.7pt; }
.agreement b { font-size: 6.8pt; }
.agreement p { margin: 4pt 0; line-height: 1.25; }
.section-block { margin-top: 4pt; }
.searches h2, .mandatory h2 { text-align: center; font-size: 9pt; letter-spacing: .2pt; }
.search-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 4pt 10pt; padding: 7pt 3pt 3pt; font-size: 7pt; font-weight: 700; }
.search-grid span { white-space: nowrap; }
.search-contact { text-align: center; font-weight: 700; font-size: 8.5pt; padding: 1pt 0 4pt; }
.mandatory { margin-top: 3pt; }
.mandatory-grid { display: grid; grid-template-columns: 1.25fr .95fr; gap: 9pt; padding-top: 5pt; }
.brand-row { display: flex; align-items: center; justify-content: space-between; font-size: 6.5pt; white-space: nowrap; margin-bottom: 4pt; }
.brand-row > b { font-size: 7pt; }
.odometer-box, .history-box { border: .7pt solid #222; padding: 3pt; font-size: 6.6pt; }
.odometer-box > b, .history-box > b { display: block; margin-bottom: 3pt; }
.odometer-box > div, .history-box > div { min-height: 12pt; }
.odometer-box span, .history-box span { float: right; white-space: nowrap; }
.odometer-box .written, .history-box .multi-line { float: none; display: inline-block; min-width: 90pt; border-bottom: .45pt solid #999; }
.two-col-disclosures { display: grid; grid-template-columns: 1fr 1fr; gap: 10pt; padding-top: 3pt; font-size: 6.5pt; }
.two-col-disclosures > div > div, .disclosure-lines > div, .right-disclosure-lines > div { min-height: 13pt; }
.disclosure-lines { padding-top: 3pt; font-size: 6.2pt; }
.disclosure-lines span, .right-disclosure-lines span { float: right; white-space: nowrap; }
.right-disclosure-lines { padding-top: 6pt; font-size: 6.2pt; }
.bold-line { font-weight: 700; }
.other-disclosures { padding-top: 2pt; font-size: 6.5pt; }
.other-disclosures > div { min-height: 20pt; }
.other-disclosures .written { display: inline-block; min-width: 280pt; border-bottom: .45pt solid #999; }
.no-disclosures { padding-top: 2pt; }
.page-one-footer { position: absolute; left: 18pt; right: 18pt; bottom: 5pt; display: flex; justify-content: space-between; font-size: 6pt; }
.check-box, .radio { display: inline-block; width: 9pt; height: 9pt; border: .8pt solid #222; vertical-align: -2pt; margin-right: 2pt; background: #fff; }
.radio { border-radius: 50%; }
.check-box.selected::after { content: '✓'; display: block; font-size: 10pt; line-height: 7pt; text-align: center; font-weight: 700; }
.radio.selected::after { content: ''; display: block; width: 5pt; height: 5pt; margin: 1.2pt; border-radius: 50%; background: #222; }
.wholesale-page-two { padding: 39pt 54pt; font-size: 8.4pt; line-height: 1.18; }
.terms { margin-bottom: 14pt; }
.terms h2 { margin: 0 0 2pt; font-size: 9pt; font-weight: 800; }
.terms h2 small { font-size: 8.4pt; }
.terms p { margin: 0; text-align: left; }
.terms .or { margin: 10pt 0 10pt 16pt; }

@media screen {
    .wholesale-document { padding: 24px 0; background: #e5e7eb; }
    .wholesale-page { box-shadow: 0 2px 12px rgb(0 0 0 / 12%); margin-bottom: 24px; }
}

@media print {
    @page { size: letter portrait; margin: 0; }
    html, body { margin: 0 !important; padding: 0 !important; background: #fff !important; }
    .wholesale-document { padding: 0; }
    .wholesale-page { margin: 0; box-shadow: none; }
    .wholesale-page-one { page-break-after: always; break-after: page; }
}
</style>

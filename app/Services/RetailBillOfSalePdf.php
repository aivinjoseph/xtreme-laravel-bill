<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use RuntimeException;
use setasign\Fpdi\Fpdi;

class RetailBillOfSalePdf
{
    private const PAGE_WIDTH = 612.0;
    private const PAGE_HEIGHT = 840.0;

    /**
     * Coordinates are the rectangles from the approved PDF's AcroForm.
     * PDF coordinates use a bottom-left origin; FPDF uses a top-left origin.
     */
    private const FIELDS = [
        'dealer_name' => [60.568, 702.126, 210.568, 717.811],
        'day' => [485.16, 701.88, 519.96, 720.48],
        'month' => [521.16, 701.88, 555.96, 720.48],
        'year' => [557.16, 701.88, 592.56, 720.48],
        'purchaser_first_name' => [62.63, 671.129, 141.545, 685.769],
        'purchaser_address' => [18.69, 651.133, 304.938, 665.773],
        'purchaser_middle_initial' => [142.303, 670.916, 222.797, 685.556],
        'purchaser_last_name' => [223.555, 670.703, 305.102, 685.343],
        'vehicle_year' => [307.324, 671.129, 328.355, 685.769],
        'vehicle_make' => [330.24, 670.394, 396.0, 685.034],
        'vehicle_model' => [397.08, 670.92, 458.64, 685.56],
        'vehicle_trim' => [459.72, 670.92, 508.8, 685.56],
        'vehicle_colour' => [509.88, 670.92, 548.16, 685.56],
        'vehicle_stock' => [549.24, 670.92, 592.68, 685.56],
        'vehicle_vin' => [306.228, 648.84, 592.627, 670.56],
        'purchaser_city' => [18.84, 629.88, 159.48, 645.6],
        'purchaser_province' => [160.8, 629.88, 230.52, 645.6],
        'purchaser_postal_code' => [231.84, 629.88, 304.68, 645.6],
        'vehicle_distance' => [310.08, 621.36, 404.88, 639.6],
        'vehicle_true_distance' => [467.4, 633.362, 512.16, 641.191],
        'vehicle_true_distance_date' => [527.52, 633.178, 579.96, 641.375],
        'purchaser_home_phone' => [18.84, 609.24, 159.48, 625.08],
        'purchaser_business_phone' => [160.8, 609.24, 304.68, 624.96],
        'vehicle_warranty_date' => [310.909, 599.844, 356.869, 610.764],
        'vehicle_delivery_date' => [358.32, 599.88, 404.28, 610.8],
        'vehicle_delivery_details' => [405.24, 599.88, 592.68, 614.76],
        'purchaser_driver_licence' => [19.171, 594.415, 217.63, 604.615],
        'purchaser_driver_licence_expiry' => [219.6, 594.48, 304.92, 604.68],
        'vehicle_condition' => [18.72, 577.44, 304.8, 590.04],
        'vehicle_certificate_number' => [447.0, 588.48, 587.76, 599.52],
        'insurance_company' => [88.68, 547.32, 228.0, 561.0],
        'insurance_policy' => [46.32, 531.36, 126.48, 545.04],
        'insurance_expiry' => [157.2, 531.36, 226.92, 545.04],
        'insurance_agent_phone' => [89.88, 515.4, 227.16, 529.08],
        'dealer_guaranty_terms' => [320.28, 533.04, 413.16, 546.72],
        'trade_year' => [19.47, 481.003, 41.637, 496.483],
        'trade_make' => [42.314, 480.72, 104.474, 496.2],
        'trade_model' => [106.32, 480.72, 157.08, 496.2],
        'trade_trim' => [158.4, 480.72, 200.28, 496.2],
        'trade_colour' => [201.6, 480.72, 231.36, 496.2],
        'trade_vin' => [18.691, 463.92, 231.417, 480.24],
        'trade_exact_distance' => [21.12, 435.96, 115.92, 452.52],
        'trade_hst_value' => [89.52, 401.4, 167.16, 412.92],
        'trade_lien_value' => [181.8, 401.52, 227.16, 408.36],
        'warranty_company_1' => [431.4, 518.04, 529.08, 532.8],
        'warranty_value_1' => [530.539, 517.938, 575.059, 532.698],
        'warranty_company_2' => [431.4, 501.84, 529.08, 516.6],
        'warranty_value_2' => [530.226, 501.412, 574.746, 516.172],
        'warranty_description' => [236.788, 478.271, 425.729, 515.532],
        'warranty_company_3' => [431.4, 485.52, 529.08, 500.4],
        'warranty_value_3' => [529.913, 485.938, 574.433, 500.698],
        'amount_sale_price' => [530.126, 550.45, 574.646, 565.21],
        'amount_extended_warranty' => [530.04, 534.24, 574.56, 549.0],
        'amount_anti_rust' => [530.539, 517.938, 575.059, 532.698],
        'amount_safety_test' => [530.226, 501.412, 574.746, 516.172],
        'amount_finance_fee' => [529.913, 485.938, 574.433, 500.698],
        'amount_omvic' => [530.04, 469.32, 574.56, 484.08],
        'amount_subtotal' => [530.04, 420.6, 574.56, 435.48],
        'amount_trade_allowance' => [530.04, 404.4, 574.56, 419.16],
        'amount_net_difference' => [530.04, 388.2, 574.56, 402.96],
        'amount_hst_net_difference' => [530.539, 372.7, 575.059, 387.46],
        'amount_licence_fee' => [529.913, 323.861, 574.433, 338.621],
        'amount_hst_subtotal' => [530.16, 355.2, 574.44, 370.44],
        'amount_hst_trade_in' => [530.16, 339.0, 574.44, 354.48],
        'amount_gasoline' => [530.04, 307.08, 574.56, 321.84],
        'amount_payout_lien' => [530.04, 290.76, 574.56, 305.64],
        'amount_hst_payable_trade_in' => [530.04, 274.56, 574.56, 289.32],
        'financing_amount' => [233.839, 286.8, 330.799, 297.6],
        'financing_number' => [332.457, 287.587, 429.417, 298.387],
        'financing_start_date' => [233.76, 272.88, 330.72, 283.68],
        'amount_balance_due' => [530.04, 258.36, 574.56, 273.12],
        'amount_deposit' => [530.04, 242.16, 574.56, 256.92],
        'amount_payable_delivery' => [530.04, 225.84, 574.56, 240.72],
        'amount_insurance' => [530.04, 209.64, 574.56, 224.4],
        'amount_hst_insurance' => [530.04, 193.44, 574.56, 208.2],
        'amount_lien_registration' => [530.04, 177.12, 574.56, 192.0],
        'amount_balance_financed' => [530.04, 160.92, 574.56, 175.68],
        'amount_net_financed' => [530.04, 144.72, 574.56, 159.48],
        'amount_cost_borrowing' => [530.16, 127.8, 574.44, 143.16],
        'amount_total_balance' => [501.716, 107.183, 572.834, 125.7],
        'comments' => [236.801, 317.034, 425.742, 379.554],
        'purchaser_initials' => [248.04, 114.12, 309.12, 127.8],
        'salesperson_name' => [18.84, 138.48, 167.64, 157.08],
        'salesperson_signature' => [18.96, 115.32, 231.24, 134.16],
        'dealer_registration' => [18.724, 81.703, 107.044, 100.663],
        'official_name' => [108.922, 80.963, 230.92, 99.923],
        'acceptor_registration' => [18.96, 58.56, 107.28, 77.52],
        'official_title' => [109.154, 59.26, 231.314, 77.85],
        'vendor_date' => [18.724, 35.921, 107.044, 54.881],
        'title_date' => [108.96, 34.68, 231.12, 57.48],
        'purchaser_signature' => [439.68, 60.36, 586.44, 74.04],
        'cosigner_name' => [444.72, 45.96, 586.44, 59.64],
        'cosigner_signature' => [438.36, 30.96, 586.44, 44.64],
    ];

    private const CHECKBOXES = [
        'vehicle_km' => [358.08, 641.4, 363.6, 646.92],
        'vehicle_miles' => [385.08, 641.4, 390.6, 646.92],
        'distance_unknown' => [411.12, 641.4, 416.64, 646.92],
        'distance_unknown_detail' => [411.12, 634.08, 416.64, 639.6],
        'true_distance_higher' => [411.12, 621.0, 416.64, 626.52],
        'camvap_yes' => [166.44, 234.84, 174.36, 242.76],
        'camvap_no' => [197.4, 234.84, 205.44, 242.76],
        'safety_yes' => [410.409, 589.966, 418.569, 598.006],
        'safety_no' => [410.04, 578.4, 418.2, 586.44],
        'dealer_guaranty_yes' => [372.0, 555.48, 380.04, 563.52],
        'dealer_guaranty_no' => [400.979, 555.144, 409.019, 563.184],
        'trade_in_lien_yes' => [382.8, 449.16, 390.84, 457.2],
        'trade_in_lien_no' => [406.122, 448.981, 414.162, 457.021],
        'trade_in_km' => [132.96, 440.88, 141.0, 448.8],
        'trade_in_miles' => [171.36, 440.88, 179.4, 448.8],
        'trade_in_yes' => [162.041, 422.328, 170.081, 430.368],
        'trade_in_no' => [195.265, 422.165, 203.305, 430.205],
        'hst_non_registrant' => [40.408, 400.287, 50.326, 410.573],
        'hst_registrant' => [77.143, 401.205, 87.061, 411.491],
        'payment_cash' => [473.52, 250.8, 479.04, 256.2],
        'credit_approval_yes' => [381.346, 244.532, 389.386, 252.572],
        'credit_approval_no' => [408.367, 244.696, 416.407, 252.736],
        'payment_credit_card' => [473.52, 242.88, 479.04, 248.4],
        'payment_cheque' => [435.96, 242.88, 441.48, 248.4],
    ];

    /**
     * Comb fields from the approved PDF. Each field's rectangle is divided by
     * the original AcroForm MaxLen into its printed character boxes.
     */
    private const CHARACTER_BOX_FIELDS = [
        'vehicle_vin' => [306.228, 648.84, 592.627, 670.56, 17],
        'vehicle_distance' => [310.08, 621.36, 404.88, 639.6, 6],
        'trade_vin' => [18.691, 463.92, 231.417, 480.24, 17],
        'trade_exact_distance' => [21.12, 435.96, 115.92, 452.52, 6],
    ];

    public function render(array $data, Car $car, array $dealer): string
    {
        $template = base_path('Retail Bill of sale supreme.pdf');

        if (!is_file($template)) {
            throw new RuntimeException('The approved Retail Bill of Sale PDF template is missing.');
        }

        $pdf = new Fpdi('P', 'pt', [self::PAGE_WIDTH, self::PAGE_HEIGHT]);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pageCount = $pdf->setSourceFile($template);

        if ($pageCount < 2) {
            throw new RuntimeException('The approved Retail Bill of Sale PDF must contain two pages.');
        }

        $pdf->AddPage('P', [self::PAGE_WIDTH, self::PAGE_HEIGHT]);
        $pdf->useTemplate($pdf->importPage(1), 0, 0, self::PAGE_WIDTH, self::PAGE_HEIGHT, true);
        $this->populateFirstPage($pdf, $data, $car, $dealer);

        $pdf->AddPage('P', [self::PAGE_WIDTH, self::PAGE_HEIGHT]);
        $pdf->useTemplate($pdf->importPage(2), 0, 0, self::PAGE_WIDTH, self::PAGE_HEIGHT, true);

        return $pdf->Output('S');
    }

    private function populateFirstPage(Fpdi $pdf, array $data, Car $car, array $dealer): void
    {
        $today = Carbon::now();
        $vehicle = Arr::get($data, 'vehicle', []);
        $purchaser = Arr::get($data, 'purchaser', []);
        $insurance = Arr::get($data, 'insurance', []);
        $trade = Arr::get($data, 'trade_in', []);
        $settlement = Arr::get($data, 'settlement', []);
        $financing = Arr::get($data, 'financing', []);
        $guaranty = Arr::get($data, 'dealer_guaranty', []);
        $warranty = Arr::get($data, 'third_party_warranty', []);
        $salesperson = Arr::get($data, 'salesperson', []);
        $vendor = Arr::get($data, 'vendor_acceptance', []);

        $this->text($pdf, 'dealer_name', Arr::get($dealer, 'name'));
        $this->text($pdf, 'day', $today->format('d'), 9, 'C');
        $this->text($pdf, 'month', $today->format('m'), 9, 'C');
        $this->text($pdf, 'year', $today->format('Y'), 9, 'C');

        $this->text($pdf, 'purchaser_first_name', Arr::get($purchaser, 'first_name'));
        $this->text($pdf, 'purchaser_middle_initial', Arr::get($purchaser, 'middle_initial'));
        $this->text($pdf, 'purchaser_last_name', Arr::get($purchaser, 'last_name'));
        $this->text($pdf, 'purchaser_address', Arr::get($purchaser, 'address'), 7);
        $this->text($pdf, 'purchaser_city', Arr::get($purchaser, 'city'));
        $this->text($pdf, 'purchaser_province', Arr::get($purchaser, 'province'));
        $this->text($pdf, 'purchaser_postal_code', Arr::get($purchaser, 'postal_code'));
        $this->text($pdf, 'purchaser_home_phone', Arr::get($purchaser, 'home_phone'));
        $this->text($pdf, 'purchaser_business_phone', Arr::get($purchaser, 'business_phone'));
        $this->text($pdf, 'purchaser_driver_licence', Arr::get($purchaser, 'driver_licence_number'), 7);
        $this->text($pdf, 'purchaser_driver_licence_expiry', $this->date(Arr::get($purchaser, 'driver_licence_expiry')));

        $this->text($pdf, 'vehicle_year', Arr::get($vehicle, 'year', $car->year));
        $this->text($pdf, 'vehicle_make', Arr::get($vehicle, 'make', $car->make));
        $this->text($pdf, 'vehicle_model', Arr::get($vehicle, 'model', $car->model));
        $this->text($pdf, 'vehicle_trim', Arr::get($vehicle, 'trim', $car->trim));
        $this->text($pdf, 'vehicle_colour', Arr::get($vehicle, 'colour', $car->ext_color));
        $this->text($pdf, 'vehicle_stock', Arr::get($vehicle, 'stock_number'));
        $this->characterBoxText($pdf, 'vehicle_vin', Arr::get($vehicle, 'vin', $car->vin), 8, 'vin');
        $this->characterBoxText($pdf, 'vehicle_distance', Arr::get($vehicle, 'distance_travelled', $car->mileage), 8, 'digits');
        $this->text($pdf, 'vehicle_true_distance_date', $this->date(Arr::get($vehicle, 'true_distance_date')), 6.5);
        $this->text($pdf, 'vehicle_warranty_date', $this->date(Arr::get($vehicle, 'warranty_in_service_date')), 6.5);
        $this->text($pdf, 'vehicle_delivery_date', $this->date(Arr::get($vehicle, 'delivery_date')), 6.5);
        $this->text($pdf, 'vehicle_delivery_details', Arr::get($vehicle, 'delivery_details'), 7);
        $this->text($pdf, 'vehicle_condition', $this->join(
            Arr::get($vehicle, 'condition'),
            Arr::get($vehicle, 'as_is') ? 'AS IS' : ''
        ), 7);
        $this->text($pdf, 'vehicle_certificate_number', Arr::get($vehicle, 'certificate_number'), 7);

        $this->text($pdf, 'insurance_company', Arr::get($insurance, 'company'), 7);
        $this->text($pdf, 'insurance_policy', Arr::get($insurance, 'policy_number'));
        $this->text($pdf, 'insurance_expiry', $this->date(Arr::get($insurance, 'expiry_date')), 6.5);
        $this->text($pdf, 'insurance_agent_phone', $this->join(Arr::get($insurance, 'agent'), Arr::get($insurance, 'agent_phone')), 7);

        $this->text($pdf, 'trade_year', Arr::get($trade, 'year'));
        $this->text($pdf, 'trade_make', Arr::get($trade, 'make'));
        $this->text($pdf, 'trade_model', Arr::get($trade, 'model'));
        $this->text($pdf, 'trade_trim', Arr::get($trade, 'trim'));
        $this->text($pdf, 'trade_colour', Arr::get($trade, 'colour'));
        $this->characterBoxText($pdf, 'trade_vin', Arr::get($trade, 'vin'), 7, 'vin');
        $this->characterBoxText($pdf, 'trade_exact_distance', Arr::get($trade, 'exact_distance'), 7, 'digits');
        $this->text($pdf, 'trade_hst_value', $this->tradeHstLabel($trade), 6.5);
        $this->text($pdf, 'trade_lien_value', Arr::get($trade, 'lien') ? 'YES' : 'NO', 6.5);
        $this->text($pdf, 'dealer_guaranty_terms', $this->join(
            Arr::get($guaranty, 'days') ? Arr::get($guaranty, 'days') . ' DAYS' : '',
            Arr::get($guaranty, 'km') ? Arr::get($guaranty, 'km') . ' KM' : ''
        ), 6.5);

        $this->multiline($pdf, 'warranty_description', $this->join(
            Arr::get($warranty, 'company'),
            Arr::get($warranty, 'months') ? Arr::get($warranty, 'months') . ' MONTHS' : '',
            Arr::get($warranty, 'km') ? Arr::get($warranty, 'km') . ' KM' : '',
            Arr::get($warranty, 'description')
        ), 6.5);

        $extendedWarranty = Arr::get($warranty, 'enabled')
            ? Arr::get($warranty, 'retail_value')
            : Arr::get($settlement, 'extended_warranty');
        $this->text($pdf, 'amount_sale_price', $this->money(Arr::get($settlement, 'sale_price')), 7, 'R');
        $this->text($pdf, 'amount_extended_warranty', $this->money($extendedWarranty), 7, 'R');
        $this->text($pdf, 'amount_anti_rust', $this->money(Arr::get($settlement, 'anti_rust_module')), 7, 'R');
        $this->text($pdf, 'amount_safety_test', $this->money(Arr::get($settlement, 'safety_e_test')), 7, 'R');
        $this->text($pdf, 'amount_finance_fee', $this->money(Arr::get($settlement, 'finance_fee')), 7, 'R');
        $this->text($pdf, 'amount_omvic', $this->money(Arr::get($settlement, 'omvic')), 7, 'R');
        $this->text($pdf, 'amount_subtotal', $this->money(Arr::get($settlement, 'subtotal_hst_taxable')), 7, 'R');
        $this->text($pdf, 'amount_trade_allowance', $this->money(Arr::get($settlement, 'trade_in_allowance')), 7, 'R');
        $this->text($pdf, 'amount_net_difference', $this->money(Arr::get($settlement, 'net_difference')), 7, 'R');
        $this->text($pdf, 'amount_hst_net_difference', $this->money(Arr::get($settlement, 'hst_on_net_difference')), 7, 'R');
        $this->text($pdf, 'amount_hst_subtotal', $this->money(Arr::get($settlement, 'hst_on_subtotal')), 7, 'R');
        $this->text($pdf, 'amount_licence_fee', $this->money(Arr::get($settlement, 'licence_fee')), 7, 'R');
        $this->text($pdf, 'amount_hst_trade_in', $this->money(Arr::get($settlement, 'hst_payable_on_trade_in')), 7, 'R');
        $this->text($pdf, 'amount_gasoline', $this->money(Arr::get($settlement, 'gasoline')), 7, 'R');
        $this->text($pdf, 'amount_payout_lien', $this->money(Arr::get($settlement, 'payout_lien_on_trade_in')), 7, 'R');
        $this->text($pdf, 'amount_hst_payable_trade_in', $this->money(Arr::get($settlement, 'hst_payable_on_trade_in')), 7, 'R');
        $this->text($pdf, 'amount_balance_due', $this->money(Arr::get($settlement, 'balance_due')), 7, 'R');
        $this->text($pdf, 'amount_deposit', $this->money(Arr::get($settlement, 'deposit')), 7, 'R');
        $this->text($pdf, 'amount_payable_delivery', $this->money(Arr::get($settlement, 'payable_on_delivery')), 7, 'R');
        $this->text($pdf, 'amount_insurance', $this->money(Arr::get($settlement, 'insurance')), 7, 'R');
        $this->text($pdf, 'amount_hst_insurance', $this->money(Arr::get($settlement, 'hst_on_insurance')), 7, 'R');
        $this->text($pdf, 'amount_lien_registration', $this->money(Arr::get($settlement, 'lien_registration_fee')), 7, 'R');
        $this->text($pdf, 'amount_balance_financed', $this->money(Arr::get($settlement, 'balance_financed_subject_to_approval')), 7, 'R');
        $this->text($pdf, 'amount_net_financed', $this->money(Arr::get($settlement, 'net_amount_to_be_financed')), 7, 'R');
        $this->text($pdf, 'amount_cost_borrowing', $this->money(Arr::get($settlement, 'cost_of_borrowing')), 7, 'R');
        $this->text($pdf, 'amount_total_balance', $this->money(Arr::get($settlement, 'total_balance_due')), 8, 'R');

        $this->text($pdf, 'financing_amount', $this->money(Arr::get($financing, 'amount_of_payments')), 7, 'R');
        $this->text($pdf, 'financing_number', Arr::get($financing, 'number_of_payments'), 7, 'R');
        $this->text($pdf, 'financing_start_date', $this->date(Arr::get($financing, 'payments_start_on')), 6.5);
        $this->multiline($pdf, 'comments', Arr::get($data, 'comments'), 6.5);
        $this->text($pdf, 'purchaser_initials', Arr::get($purchaser, 'initials'));

        $this->text($pdf, 'salesperson_name', Arr::get($salesperson, 'name'), 7);
        $this->text($pdf, 'salesperson_signature', Arr::get($salesperson, 'signature'), 7);
        $this->text($pdf, 'dealer_registration', Arr::get($vendor, 'dealer_registration_number', Arr::get($dealer, 'registration_number')), 7);
        $this->text($pdf, 'official_name', Arr::get($vendor, 'official_name'), 7);
        $this->text($pdf, 'acceptor_registration', Arr::get($vendor, 'acceptor_registration_number'), 7);
        $this->text($pdf, 'official_title', Arr::get($vendor, 'title'), 7);
        $this->text($pdf, 'vendor_date', $this->date(Arr::get($vendor, 'date')), 6.5);
        $this->text($pdf, 'title_date', $this->date(Arr::get($vendor, 'date')), 6.5);
        $this->text($pdf, 'purchaser_signature', Arr::get($data, 'acknowledgements.purchaser_signature'), 7);
        $this->text($pdf, 'cosigner_name', Arr::get($purchaser, 'co_signer_name'), 7);
        $this->text($pdf, 'cosigner_signature', Arr::get($purchaser, 'co_signer_signature', Arr::get($data, 'acknowledgements.co_signer_signature')), 7);

        $this->checkbox($pdf, 'vehicle_km', Arr::get($vehicle, 'mileage_unit', 'km') === 'km');
        $this->checkbox($pdf, 'vehicle_miles', Arr::get($vehicle, 'mileage_unit') === 'mi');
        $this->checkbox($pdf, 'distance_unknown', (bool) Arr::get($vehicle, 'distance_unknown'));
        $this->checkbox($pdf, 'distance_unknown_detail', (bool) Arr::get($vehicle, 'distance_unknown'));
        $this->checkbox($pdf, 'true_distance_higher', (bool) Arr::get($vehicle, 'true_distance_higher'));
        $this->checkbox($pdf, 'camvap_yes', Arr::get($vehicle, 'camvap') === 'yes');
        $this->checkbox($pdf, 'camvap_no', Arr::get($vehicle, 'camvap') === 'no');
        $this->checkbox($pdf, 'safety_yes', Arr::get($vehicle, 'safety_certificate', 'yes') === 'yes');
        $this->checkbox($pdf, 'safety_no', Arr::get($vehicle, 'safety_certificate') === 'no');
        $this->checkbox($pdf, 'dealer_guaranty_yes', (bool) Arr::get($guaranty, 'enabled'));
        $this->checkbox($pdf, 'dealer_guaranty_no', !Arr::get($guaranty, 'enabled'));
        $this->checkbox($pdf, 'trade_in_lien_yes', (bool) Arr::get($trade, 'lien'));
        $this->checkbox($pdf, 'trade_in_lien_no', !Arr::get($trade, 'lien'));
        $this->checkbox($pdf, 'trade_in_km', Arr::get($trade, 'mileage_unit', 'km') === 'km');
        $this->checkbox($pdf, 'trade_in_miles', Arr::get($trade, 'mileage_unit') === 'mi');
        $this->checkbox($pdf, 'trade_in_yes', (bool) Arr::get($trade, 'enabled'));
        $this->checkbox($pdf, 'trade_in_no', !Arr::get($trade, 'enabled'));
        $this->checkbox($pdf, 'hst_non_registrant', (bool) Arr::get($trade, 'hst_non_registrant'));
        $this->checkbox($pdf, 'hst_registrant', (bool) Arr::get($trade, 'hst_registrant'));
        $this->checkbox($pdf, 'payment_cash', Arr::get($settlement, 'payment_method') === 'cash');
        $this->checkbox($pdf, 'payment_cheque', Arr::get($settlement, 'payment_method') === 'cheque');
        $this->checkbox($pdf, 'payment_credit_card', Arr::get($settlement, 'payment_method') === 'credit_card');
        $this->checkbox($pdf, 'credit_approval_yes', strtoupper((string) Arr::get($financing, 'credit_approval')) === 'YES');
        $this->checkbox($pdf, 'credit_approval_no', strtoupper((string) Arr::get($financing, 'credit_approval')) === 'NO');
    }

    private function text(Fpdi $pdf, string $field, mixed $value, float $fontSize = 8.0, string $align = 'L'): void
    {
        if (!isset(self::FIELDS[$field])) {
            return;
        }

        [$x1, $y1, $x2, $y2] = self::FIELDS[$field];
        $width = $x2 - $x1;
        $height = $y2 - $y1;
        $value = $this->plain($value);

        if ($value === '') {
            return;
        }

        $fontSize = $this->fitFontSize($pdf, $value, $width - 2, $fontSize);
        $pdf->SetFont('Helvetica', '', $fontSize);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($x1 + 1, self::PAGE_HEIGHT - $y2 + 0.5);
        $pdf->Cell($width - 2, $height - 1, $this->fitText($pdf, $value, $width - 2), 0, 0, $align);
    }

    private function characterBoxText(Fpdi $pdf, string $field, mixed $value, float $fontSize, string $mode): void
    {
        if (!isset(self::CHARACTER_BOX_FIELDS[$field])) {
            return;
        }

        [$x1, $y1, $x2, $y2, $maxLength] = self::CHARACTER_BOX_FIELDS[$field];
        $value = $this->plain($value);

        if ($value === '') {
            return;
        }

        $value = $mode === 'vin'
            ? preg_replace('/[^A-Z0-9]/', '', strtoupper($value))
            : preg_replace('/[^0-9]/', '', $value);

        if ($value === '') {
            return;
        }

        $value = substr($value, 0, $maxLength);
        $slotWidth = ($x2 - $x1) / $maxLength;
        $slotInset = 1.0;
        $slotHeight = ($y2 - $y1) - ($slotInset * 2);
        $top = self::PAGE_HEIGHT - $y2;

        $pdf->SetFont('Helvetica', '', $fontSize);
        $pdf->SetTextColor(0, 0, 0);

        foreach (str_split($value) as $index => $character) {
            $slotX = $x1 + ($index * $slotWidth);
            $pdf->SetXY($slotX + $slotInset, $top + $slotInset);
            $pdf->Cell($slotWidth - ($slotInset * 2), $slotHeight, $character, 0, 0, 'C');
        }
    }

    private function multiline(Fpdi $pdf, string $field, mixed $value, float $fontSize): void
    {
        if (!isset(self::FIELDS[$field])) {
            return;
        }

        $value = trim($this->plain($value));
        if ($value === '') {
            return;
        }

        [$x1, $y1, $x2, $y2] = self::FIELDS[$field];
        $width = $x2 - $x1 - 3;
        $height = $y2 - $y1 - 3;
        $pdf->SetFont('Helvetica', '', $fontSize);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($x1 + 1.5, self::PAGE_HEIGHT - $y2 + 1.5);
        $lineHeight = max(7.0, $fontSize + 1.0);
        $pdf->MultiCell($width, $lineHeight, $this->fitMultiline($pdf, $value, $width, $height, $lineHeight), 0, 'L');
    }

    private function checkbox(Fpdi $pdf, string $field, bool $checked): void
    {
        [$x1, $y1, $x2, $y2] = self::CHECKBOXES[$field];
        $top = self::PAGE_HEIGHT - $y2;
        $width = $x2 - $x1;
        $height = $y2 - $y1;

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.35);
        $pdf->Rect($x1, $top, $width, $height);

        if (!$checked) {
            return;
        }

        $pdf->SetLineWidth(0.8);
        $pdf->Line($x1 + 1.0, $top + 1.0, $x2 - 0.9, $top + $height - 1.0);
        $pdf->Line($x1 + 1.0, $top + $height - 1.0, $x2 - 0.9, $top + 1.0);
    }

    private function fitFontSize(Fpdi $pdf, string $value, float $width, float $fontSize): float
    {
        for ($size = $fontSize; $size >= 4.5; $size -= 0.5) {
            $pdf->SetFont('Helvetica', '', $size);
            if ($pdf->GetStringWidth($value) <= $width) {
                return $size;
            }
        }

        return 4.5;
    }

    private function fitText(Fpdi $pdf, string $value, float $width): string
    {
        if ($pdf->GetStringWidth($value) <= $width) {
            return $value;
        }

        while ($value !== '' && $pdf->GetStringWidth($value . '...') > $width) {
            $value = substr($value, 0, -1);
        }

        return rtrim($value) . '...';
    }

    private function fitMultiline(Fpdi $pdf, string $value, float $width, float $height, float $lineHeight): string
    {
        $lines = [];
        foreach (preg_split('/\R/', $value) as $paragraph) {
            $words = preg_split('/\s+/', trim($paragraph), -1, PREG_SPLIT_NO_EMPTY);
            $line = '';
            foreach ($words as $word) {
                $candidate = $line === '' ? $word : $line . ' ' . $word;
                if ($pdf->GetStringWidth($candidate) <= $width) {
                    $line = $candidate;
                    continue;
                }

                if ($line !== '') {
                    $lines[] = $line;
                }
                $line = $word;
            }
            if ($line !== '') {
                $lines[] = $line;
            }
        }

        $maxLines = max(1, (int) floor($height / $lineHeight));
        if (count($lines) > $maxLines) {
            $lines = array_slice($lines, 0, $maxLines);
            $last = rtrim($lines[$maxLines - 1], '. ');
            $lines[$maxLines - 1] = $last . '...';
        }

        return implode("\n", $lines);
    }

    private function plain(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'YES' : 'NO';
        }

        if (!is_scalar($value)) {
            return '';
        }

        return trim(str_replace(["\r", "\n"], ' ', (string) $value));
    }

    private function date(mixed $value): string
    {
        if (!$value) {
            return '';
        }

        try {
            return Carbon::parse((string) $value)->format('d/m/Y');
        } catch (\Throwable) {
            return $this->plain($value);
        }
    }

    private function money(mixed $value): string
    {
        return number_format((float) $value, 2, '.', ',');
    }

    private function join(mixed ...$values): string
    {
        return implode(' / ', array_values(array_filter(array_map(fn ($value) => $this->plain($value), $values))));
    }

    private function tradeHstLabel(array $trade): string
    {
        if (Arr::get($trade, 'hst_registrant')) {
            return 'REGISTRANT';
        }

        if (Arr::get($trade, 'hst_non_registrant')) {
            return 'NON-REGISTRANT';
        }

        return '';
    }
}

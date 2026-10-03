export const money = (value) => Number.isFinite(Number(value)) ? Number(value) : 0;

export const calculateSettlement = (settlement = {}) => {
    const subtotal = [
        'sale_price',
        'extended_warranty',
        'anti_rust_module',
        'safety_e_test',
        'finance_fee',
        'omvic',
    ].reduce((sum, key) => sum + money(settlement[key]), 0);
    const tradeInAllowance = money(settlement.trade_in_allowance);
    const netDifference = Math.max(0, subtotal - tradeInAllowance);
    const hstRate = Math.max(0, money(settlement.hst_rate));
    const hstOnNetDifference = Number((netDifference * hstRate).toFixed(2));
    const hstOnSubtotal = Number((subtotal * hstRate).toFixed(2));
    const hst = settlement.hst_method === 'subtotal' ? hstOnSubtotal : hstOnNetDifference;
    const balanceDue = Number((
        netDifference + hst + money(settlement.licence_fee) + money(settlement.gasoline)
        + money(settlement.payout_lien_on_trade_in) + money(settlement.hst_payable_on_trade_in)
        + money(settlement.insurance) + money(settlement.hst_on_insurance)
        + money(settlement.lien_registration_fee)
    ).toFixed(2));
    const payableOnDelivery = Number(Math.max(0, balanceDue - money(settlement.deposit)).toFixed(2));
    const totalBalanceDue = Number((payableOnDelivery + money(settlement.cost_of_borrowing)).toFixed(2));

    return {
        subtotal_hst_taxable: Number(subtotal.toFixed(2)),
        net_difference: Number(netDifference.toFixed(2)),
        hst_on_net_difference: hstOnNetDifference,
        hst_on_subtotal: hstOnSubtotal,
        balance_due: balanceDue,
        payable_on_delivery: payableOnDelivery,
        balance_financed_subject_to_approval: payableOnDelivery,
        net_amount_to_be_financed: payableOnDelivery,
        total_balance_due: totalBalanceDue,
    };
};

export const formatCurrency = (value) => new Intl.NumberFormat('en-CA', {
    style: 'currency',
    currency: 'CAD',
}).format(money(value));

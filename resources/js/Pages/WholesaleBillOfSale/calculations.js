export const money = (value) => Number.isFinite(Number(value)) ? Number(value) : 0;

export const calculateWholesaleTotals = ({ price, hst, licencing }) => ({
    price: money(price),
    hst: money(hst),
    licencing: money(licencing),
    total: Number((money(price) + money(hst) + money(licencing)).toFixed(2)),
});

export const calculateHst = (price, rate) => Number((money(price) * Math.max(0, money(rate))).toFixed(2));

export const formatCurrency = (value) => new Intl.NumberFormat('en-CA', {
    style: 'currency',
    currency: 'CAD',
}).format(money(value));

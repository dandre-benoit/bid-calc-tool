const currency = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

export function toCurrency(value: number): string {
    return Number.isNaN(value) ? '0' : currency.format(value);
}

export function toNumber(value: string): number
{
    return parseFloat(value.replace(/[^0-9.-]+/g,''));
}
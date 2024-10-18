import { h } from 'vue'
import App from '@/App.vue'
import { expect, test } from 'vitest'
import { render } from '@testing-library/vue'
import testCases from '@/../../test-cases.json'
import { toCurrency, toNumber, wait } from '@/helpers'
import { page, type Locator } from '@vitest/browser/context'

let vehiculeTypeInput: Locator,
    vehiculePriceInput: Locator;

test('setup web page', async () => {
    expect(App).toBeTruthy();

    render(() => h('div', { id: 'app' }, [h(App, { endpoint: process.env.APP_URL })]));

    vehiculeTypeInput = page.getByTestId('vehicule_type');
    vehiculePriceInput = page.getByTestId('vehicule_price');
});

test('auto formating vehicule prices', async () => {
    async function expectVehiculePriceToBeFormated(value: string) {
        await vehiculePriceInput.fill(value);
        await expect.element(vehiculePriceInput).toHaveProperty('value', toCurrency(toNumber(value)));
    }

    await expectVehiculePriceToBeFormated('501.25');
    await expectVehiculePriceToBeFormated('$1000.05');
    await expectVehiculePriceToBeFormated('0');
    await expectVehiculePriceToBeFormated('-99.99');
})

test('calcul total cost for test cases', async () => {
    async function expectContentToBe(testId: string, contentExpected: string) {
        return expect(page.getByTestId(testId).element()).toHaveTextContent(contentExpected);
    }

    for (const testCase of testCases) {
        const [type, priceUsd, basicFeeUsd, specialFeeUsd, associationFeeUsd, storageFeeUsd, totalPriceUsd] = testCase;

        await vehiculeTypeInput.selectOptions(type as string);
        await vehiculePriceInput.fill((priceUsd as number).toFixed(2));

        await wait(500);

        await waitForIt('vehicule_total_price_usd');

        await expectContentToBe('basic_fee_usd', toCurrency(basicFeeUsd as number));
        await expectContentToBe('special_fee_usd', toCurrency(specialFeeUsd as number));
        await expectContentToBe('association_fee_usd', toCurrency(associationFeeUsd as number));
        await expectContentToBe('storage_fee_usd', toCurrency(storageFeeUsd as number));
        await expectContentToBe('vehicule_total_price_usd', toCurrency(totalPriceUsd as number));
    }
})

test('receive error messages when vehicule price is less or equal to zero', async () => {
    async function expectErrorMessageWhenPriceIsLessOrEqualToZero(value: string) {
        await vehiculePriceInput.fill(value);
        expect(await waitForIt('error_message')).toBeTruthy();
    }

    await expectErrorMessageWhenPriceIsLessOrEqualToZero('0');
    await expectErrorMessageWhenPriceIsLessOrEqualToZero('-99.99');
})

async function waitForIt(testId: string) {
    let el;
    while (!el) {
        try {
            el = page.getByTestId(testId).element();
        } catch (err) {
            await wait(1);
        }
    }
    return el;
}

<script setup lang="ts">
import { debouncedWatch, useFetch } from '@vueuse/core'
import { reactive, ref } from 'vue';
import { toCurrency, toNumber } from './helpers';

const props = defineProps({
    endpoint: {
        type: String,
        default: ''
    }
});

export interface TotalCost {
    vehicule_price_usd: number,
    basic_fee_usd: number,
    special_fee_usd: number,
    association_fee_usd: number,
    storage_fee_usd: number,
    vehicule_total_price_usd: number
}

const errorMsg = ref();
const vehiculeType = ref('common');
const vehiculePriceUsd = ref();

const cost = reactive<TotalCost>({
    vehicule_price_usd: 0,
    basic_fee_usd: 0,
    special_fee_usd: 0,
    association_fee_usd: 0,
    storage_fee_usd: 0,
    vehicule_total_price_usd: 0
});

const { isFetching, post } = useFetch(`${props.endpoint}/api/calc-total-cost`, {
    /** @ts-ignore */
    afterFetch: ({ data }) => {
        Object.assign(cost, data);
        errorMsg.value = null;
    },
    onFetchError: (ctx) => {
        errorMsg.value = ctx.data.message
        return ctx;
    },
    immediate: false,
}).json();

debouncedWatch([vehiculeType, vehiculePriceUsd], ([vehicule_type, vehicule_price_usd], [old_vehicule_type]) => {
    vehicule_price_usd = toNumber(vehicule_price_usd)
    // Prevents it from posting again while formating the price
    if (cost.vehicule_price_usd != vehicule_price_usd || vehicule_type != old_vehicule_type) {
        post({
            vehicule_type,
            vehicule_price_usd
        })?.execute();
        // Format the price
        vehiculePriceUsd.value = toCurrency(vehicule_price_usd);
    }
}, { debounce: 500 });
</script>

<template>
    <div class="main-content">
        <img src="https://progi.com/wp-content/uploads/2018/02/Progi_forme_99x45.png"
            srcset="https://progi.com/wp-content/uploads/2018/02/Progi_forme_99x45.png 1x, https://progi.com/wp-content/uploads/2018/02/Progi_forme_197x89.png 2x"
            width="99" height="45" style="max-height:45px;height:auto;" alt="Progi Logo"
            data-retina_logo_url="https://progi.com/wp-content/uploads/2018/02/Progi_forme_197x89.png"
            class="fusion-standard-logo">
        <h1>The Bid Calculation&nbsp;Tool</h1>
        <div class="content">
            <div>
                <table>
                    <tbody>
                        <tr>
                            <td>Vehicule Type</td>
                            <td>
                                <select data-testid="vehicule_type" v-model="vehiculeType">
                                    <option value="common">Common</option>
                                    <option value="luxury">Luxury</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Vehicule Price</td>
                            <td><input data-testid="vehicule_price" ref="priceInput" type="text"
                                    v-model="vehiculePriceUsd"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Transition>
                <div v-if="isFetching" class="message">Please wait...</div>
                <div v-else-if="errorMsg" class="error" data-testid="error_message">{{ errorMsg }}</div>
                <div v-else-if="cost.vehicule_total_price_usd">
                    <table class="cost">
                        <tbody>
                            <tr>
                                <td>Basic fee </td>
                                <td data-testid="basic_fee_usd">{{ toCurrency(cost.basic_fee_usd) }}</td>
                            </tr>
                            <tr>
                                <td>Special Fee</td>
                                <td data-testid="special_fee_usd">{{ toCurrency(cost.special_fee_usd) }}</td>
                            </tr>
                            <tr>
                                <td>Association fee</td>
                                <td data-testid="association_fee_usd">{{ toCurrency(cost.association_fee_usd) }}</td>
                            </tr>
                            <tr>
                                <td>Storage fee</td>
                                <td data-testid="storage_fee_usd">{{ toCurrency(cost.storage_fee_usd) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td data-testid="vehicule_total_price_usd">{{ toCurrency(cost.vehicule_total_price_usd)
                                    }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

.v-enter-active {
    transition: opacity 0.5s ease;
}

.v-leave-active {
    transition: opacity 0s ease;
}

.v-enter-from {
    opacity: 0;
}

:root,
select,
input {
    font-family: Roboto, serif;
    color: #00629c;

    @media only screen and (min-width: 0px) and (max-width: 576px) {
        font-size: 16px;
    }

    @media only screen and (min-width: 576px) and (max-width: 768px) {
        font-size: 20px;
    }

    @media only screen and (min-width: 768px) {
        font-size: 24px;
    }
}

body {
    margin: 0;
}

#app {
    display: flex;
    justify-content: center;

    .main-content {
        margin: 20px;

        .content {
            max-width: 600px;
        }

        .error,
        .message {
            margin-top: 1rem;
        }

        .error {
            color: rgb(202, 44, 44);
        }

        text-align: center;

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        select,
        input {
            border: 1px solid silver;
            padding: 2px 4px;
            border-radius: 4px;

            &:focus-visible {
                outline: 2px solid currentColor;
            }
        }

        input {
            width: 7rem;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            td {
                padding: 4px 16px 4px 16px;
            }

            td:first-child {
                font-weight: bold;
                text-align: left;
            }

            td:nth-child(2) {
                text-align: right;
            }
        }

        table.cost {
            tr:last-child td {
                padding-bottom: 8px;
            }

            tfoot td {
                padding-top: 8px;
                font-weight: bold;
                border-top: 1px solid currentColor;
            }
        }
    }
}
</style>

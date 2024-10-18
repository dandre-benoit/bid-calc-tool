<?php

namespace Tests\Unit;

use Tests\TestCase;

class CalcToolTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_access_web_page() : void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_calcul_total_cost_for_test_cases() : void
    {
        $this->get('/')->assertStatus(200);
        
        $testCases = json_decode(file_get_contents(__DIR__ . '/../../test-cases.json'));

        foreach ($testCases as $testCase) {
            [$type, $priceUsd, $basicFee, $specialFee, $associationFee, $storageFee, $totalPriceUsd] = $testCase;

            $this
                ->post('/api/calc-total-cost', [
                    'vehicule_type' => $type,
                    'vehicule_price_usd' => $priceUsd,
                ])
                ->assertStatus(200)
                ->assertJson([
                    'vehicule_price_usd' => $priceUsd,
                    'basic_fee_usd' => $basicFee,
                    'special_fee_usd' => $specialFee,
                    'association_fee_usd' => $associationFee,
                    'storage_fee_usd' => $storageFee,
                    'vehicule_total_price_usd' => $totalPriceUsd
                ]);
        }
    }

    public function test_receive_error_messages_when_vehicule_price_is_less_or_equal_to_zero() : void
    {
        $this
            ->post('/api/calc-total-cost', [
                'vehicule_type' => 'luxury',
                'vehicule_price_usd' => 0,
            ])
            ->assertStatus(200)
            ->assertJson([
                'message' => "The vehicule price must be a number higher than 0.",
                'vehicule_price_usd' => 0,
            ]);

        $this
            ->post('/api/calc-total-cost', [
                'vehicule_type' => 'luxury',
                'vehicule_price_usd' => -99,
            ])
            ->assertStatus(200)
            ->assertJson([
                'message' => "The vehicule price must be a number higher than 0.",
                'vehicule_price_usd' => -99,
            ]);
    }
}

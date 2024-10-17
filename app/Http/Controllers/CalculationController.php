<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CalculationController extends Controller
{
    public function calculateTotalCost() : JsonResponse
    {
        $type = request()->string('vehicule_type', '');
        $price = request()->float('vehicule_price_usd', 0);

        $fees = $this->getFeesForVehiculeType($type);

        if (! $price) {
            throw new BadRequestHttpException("Invalid vehicule price!");
        }

        $cost = [
            'vehicule_price_usd' => $price,
            'basic_fee_usd' => clamp(
                $price * $fees['basic_fee_rate'],
                $fees['basic_fee_min_usd'],
                $fees['basic_fee_max_usd']
            ),
            'special_fee_usd' => $price * $fees['special_fee_rate'],
            'association_fee_usd' => between(
                $price, 
                $fees['association_fee_range']
            ),
            'storage_fee_usd' => $fees['storage_fee_usd'],
        ];

        return response()->json([
            'vehicule_type' => $type,
            ...$cost,
            'vehicule_total_price_usd' => array_sum($cost)
        ]);
    }

    public function getFeesForVehiculeType(string $type) : array
    {
        $config = config('fees');

        if (! key_exists($type, $config['vehicule_types'])) {
            throw new BadRequestHttpException("Invalid vehicule type!");
        }

        return array_replace_recursive(
            $config['defaults'],
            $config['vehicule_types'][$type]
        );
    }

}

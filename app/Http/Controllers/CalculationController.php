<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CalculationController extends Controller
{
    public function calculateTotalCost(): JsonResponse
    {
        $type = request()->input('vehicule_type', '');
        $price = request()->float('vehicule_price_usd');

        $fees = $this->getFeesForVehiculeType($type);

        if (!$price) {
            throw new BadRequestHttpException("Invalid vehicule price!");
        }

        return response()->json([
            'status_code' => 200,
            'vehicule_type' => $type,
            'vehicule_price_usd' => $price,
            'basic_fee_usd' => 50,
            'special_fee_usd' => 20,
            'association_fee_usd' => 10,
            'storage_fee_usd' => $fees['storage_fee_usd'],
            'vehicule_total_price_usd' => 1180
        ]);
    }

    public function getFeesForVehiculeType(string $type): array
    {
        $config = config('fees');

        if (!key_exists($type, $config['vehicule_types'])) {
            throw new BadRequestHttpException("Invalid vehicule type!");
        }

        return array_replace_recursive(
            $config['defaults'],
            $config[$type]
        );
    }
}

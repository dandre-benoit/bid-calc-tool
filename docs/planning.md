# The Bid Calculation Tool

## Planning

### Configuration
```php
<?php # /config/fees.php

return [
    'defaults' => [
        'basic_fee_rate' => 0.1,
        'association_fee_range' => [
            3001 => 20,
            1001 => 15,
            501 => 10
            1 => 5,
        ],
        'storage_fee_usd' => 100,
    ],
    'vehicule_types' => [
        'common' => [
            // 'basic_fee_rate' => 0.1,
            'basic_fee_min_usd' => 10,
            'basic_fee_max_usd' => 50,            
            'special_fee_rate' => 0.02,          
            // 'storage_fee_usd' => 100,
        ],
        'luxury' => [
            // 'basic_fee_rate' => 0.1,
            'basic_fee_min_usd' => 25,
            'basic_fee_max_usd' => 200,
            'special_fee_rate' => 0.04,
            // 'storage_fee_usd' => 100,
        ],
    ],
]
```

### Route Provider

#### Calculating the Total Cost

Request
```HTTP
POST /api/calc-total-cost HTTP/1.1
```
```JSON
{
    "vehicule_type": "common",
    "vehicule_price_usd": 1000,
    "_token": "..."
}
```

Response
```JSON
{
    "vehicule_type": "common",
    "vehicule_price_usd": 1000,
    "basic_fee_usd": 50,
    "special_fee_usd": 20,
    "association_fee_usd": 10,
    "storage_fee_usd": 100,
    "vehicule_total_price_usd": 1180
}
```

### Calculation Controller
```PHP
class CalculationController {
    public function calculateTotalCost(): JsonResponse;

    public function getFeesForVehiculeType(string $type): array;
}
```

### Unit Tests
Frontend unit testing only with Jest.
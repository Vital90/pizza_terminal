<?php

namespace App\api;

class OrderCalculator implements IOrderCalculator
{
    private $currencyConverter;

    public function __construct($currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    public function calculateSummary($products)
    {
        $total = 0;
        $result = [];

        foreach ($products as $product) {
            $sizePrice = round($product['basePrice'] * ($product['coef'] ?? 1), 2);
            $bynPrice = $this->currencyConverter->toBYN($sizePrice);
            $result[] = [
                'type' => $product['type'],
                'name' => $product['name'],
                'price' => $bynPrice,
                'size' => $product['size'] ?? null
            ];
            $total += $bynPrice;
        }

        return ['total' => round($total, 2), 'products' => $result];
    }
}

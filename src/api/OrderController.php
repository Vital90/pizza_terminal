<?php

namespace App\api;
use Exception;
use App\Storage;
use App\converters\NBRBCurrencyConverter;

class OrderController
{
    public function post($data)
    {
        $pizzaId = $this->extractParameter($data, 'pizzaId');
        $sizeId = $this->extractParameter($data, 'sizeId');
        $sauceId = $this->extractParameter($data, 'sauceId');

        $storage = Storage::getInstance();
        $pizza = $storage->getPizza($pizzaId, $sizeId);
        $sauce = $storage->getSause($sauceId);

        $currencyConverter = new NBRBCurrencyConverter();
        $calculator = new OrderCalculator($currencyConverter);

        return $calculator->calculateSummary([$pizza, $sauce]);
    }

    private function extractParameter($data, $name)
    {
        if (!isset($data[$name])) {
            throw new Exception("Missing ID for '" . $name . "'");
        }

        $id = filter_var($data[$name], FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception("Invalid ID for '" . $name . "'");
        }

        return $id;
    }
}

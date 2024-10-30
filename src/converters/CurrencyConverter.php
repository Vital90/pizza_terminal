<?php

namespace App\converters;

abstract class CurrencyConverter {
    private $rate = null;

    abstract protected function getRate();

    public function toBYN($value) {
        if ($this->rate === null) {
            $this->rate = $this->getRate();
        }
        return round($value * $this->rate, 2);
    }
}

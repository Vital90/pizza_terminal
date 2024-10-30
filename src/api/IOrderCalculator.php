<?php


namespace App\api;
interface IOrderCalculator
{
    public function calculateSummary($products);
}

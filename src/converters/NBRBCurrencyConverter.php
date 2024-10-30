<?php
namespace App\converters;

//use Exception;

class NBRBCurrencyConverter extends CurrencyConverter {
    private $sourceUrl = "https://api.nbrb.by/exrates/rates/USD?parammode=2";

    protected function getRate()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->sourceUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            throw new Exception("Can' get rate from NBRB. HTTP code: " . $httpCode);
        }

        curl_close($curl);
        $data = json_decode($response, true);
        return $data['Cur_OfficialRate'];
    }
}
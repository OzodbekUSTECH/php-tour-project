<?php

// app/Traits/ConvertsCurrencyTrait.php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ConverterCurrency
{
    /**
     * Convert the given price to the specified currency.
     *
     * @param float $price
     * @param string $targetCurrency
     * @return float
     */
    public static function convertCurrency($price, $targetCurrency = null)
    {
        if (!$targetCurrency) {
            return $price; // If no target currency is provided, return the original price
        }

        $reqUrl = "https://v6.exchangerate-api.com/v6/0f5d914610d764f3b8c595c5/pair/USD/{$targetCurrency}";
        $responseJson = file_get_contents($reqUrl);
        $response = json_decode($responseJson);

        return round($price * $response->conversion_rate);
    }
}

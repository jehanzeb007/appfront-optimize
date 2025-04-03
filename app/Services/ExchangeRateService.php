<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    /**
     * Fetch the exchange rate.
     *
     * @return float
     */
    public function getExchangeRate(): float
    {
        return Cache::remember('exchange_rate', 3600, function () {
            try {
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://open.er-api.com/v6/latest/USD",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if (!$err) {
                    $data = json_decode($response, true);
                    if (isset($data['rates']['EUR'])) {
                        return $data['rates']['EUR'];
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Failed to fetch exchange rate: ' . $e->getMessage());
            }

            return env('EXCHANGE_RATE', 0.85);
        });
    }
}

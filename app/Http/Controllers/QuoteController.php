<?php

namespace App\Http\Controllers;

use App\Models\Quote as QuoteModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use Scheb\YahooFinanceApi\Results\Quote;

class QuoteController extends Controller
{
    protected ?Authenticatable $user;
    private ApiClient $client;

    public function __construct(){
        $this->client = ApiClientFactory::createApiClient();
    }

    private function mapArray(Quote $quote): array
    {
        $new = [];
        $test = $quote->jsonSerialize();
        foreach ($test as $key => $data){
            if ($data instanceof \DateTimeInterface){
                $new[$this->camelCaseToUnderscore($key)] = $data->getTimestamp();
                continue;
            }
            $new[$this->camelCaseToUnderscore($key)] = $data;
        }
        return $new;
    }
    private function camelCaseToUnderscore($string): string
    {
        $str = lcfirst($string);
        $str = preg_replace("/[A-Z]/", "_"."$0", $str);
        return strtolower($str);
    }

    public function quote(Request $request): JsonResponse
    {
        $symbol = strtoupper($request->route('symbol')).'.SA';

        $dt = new \DateTime();
        $dt->sub(new \DateInterval("PT15M"));
        $db = QuoteModel::query()
            ->where('symbol', $symbol)
            ->where('created_at', '>', $dt->format('Y-m-d H:i:s'));
        $quote = $db->get()->first();
        if (!$quote){
            $quote = $this->client->getQuote($symbol);
            $mapped = $this->mapArray($quote);
            $quote = new QuoteModel($mapped);
            $quote->save();
            $quote->refresh();
        }
        return response()->json($quote);

//        $dividends = $this->client->getHistoricalDividendData($symbol, $bg, $dt);
//        $timestamp = $quote->getEarningsTimestamp()->getTimestamp();
//        $quoteHistory1d = $this->client->getHistoricalQuoteData($symbol, ApiClient::INTERVAL_1_DAY, $bg, $dt);
//        $split = $this->client->getHistoricalSplitData($symbol, $bg, $dt);


    }
}

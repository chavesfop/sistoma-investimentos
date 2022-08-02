<?php

namespace App\Http\Controllers;

use App\Models\Quote as QuoteModel;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;

class QuoteController extends Controller
{
    private ApiClient $client;

    public function __construct(){
        $this->client = ApiClientFactory::createApiClient();
        parent::__construct();
    }

    public function search(Request $request): JsonResponse
    {
        $symbol = strtoupper($request->route('symbol')).'.SA';

        $dt = new DateTime();
        $dt->sub(new DateInterval("PT15M"));
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

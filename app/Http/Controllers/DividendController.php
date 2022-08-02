<?php

namespace App\Http\Controllers;

use App\Models\Dividend;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;

class DividendController extends Controller
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = ApiClientFactory::createApiClient();
        parent::__construct();
    }

    public function search(Request $request): JsonResponse
    {
        $symbol = strtoupper($request->route('symbol'));
        $db = Dividend::query()->where('quote', $symbol)->orderByDesc('pay_date');
        $dividend = $db->get()->first();
        $maxDate = new DateTime();
        if ($dividend) {
            $maxDate = DateTime::createFromFormat('Y-m-d H:i:s', $dividend->created_at);
            $maxDate->add(new DateInterval('PT1M'));
        } else {
            $maxDate->sub(new DateInterval('P10Y'));
        }

        $tryUpdate = new DateTime();
        $tryUpdate->sub(new DateInterval('PT15M'));

        if ($maxDate < $tryUpdate) {
            $dividendsUpdated = $this->client->getHistoricalDividendData(rtrim($symbol, 'F') . '.SA', $maxDate, new DateTime());
            foreach ($dividendsUpdated as $new) {
                $add = new Dividend;
                $add->pay_date = $new->getDate()->format(DATE_RFC3339);
                $add->value = $new->getDividends();
                $add->quote = $symbol;
                $add->save();
            }
        }

        return response()->json(Dividend::query()->where('quote', $symbol)->get());
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Ticker;
use Illuminate\Console\Command;
use simplehtmldom\HtmlWeb;

class PopulateDatabase extends Command
{
    protected $signature = 'bovespa:load';
    protected $description = 'Load data from ibovespa to database';

    public function handle()
    {
        $tickers = Ticker::all();
        foreach ($tickers as $symbol){
            $client = new HtmlWeb();
            $client->load("http://localhost:8000/quote/{$symbol}");
            $client->load("http://localhost:8000/quote/dividend/{$symbol}");
            $this->info($symbol." - loaded");
        }
    }
}

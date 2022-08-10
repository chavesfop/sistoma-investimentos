<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use simplehtmldom\HtmlWeb;

class PopulateDatabase extends Command
{
    protected $signature = 'bovespa:load';
    protected $description = 'Load data from ibovespa to database';

    private $url = 'https://br.advfn.com/bolsa-de-valores/bovespa/';
    public function handle()
    {
        $index = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 
            'Y', 'Z', '0', '1', '2', '3', '4', '5',
            '6', '7', '8', '9'
        ];
        foreach ($index as $param){
            $this->info('Scanning for '.$param);
            $client = new HtmlWeb();
            $html = $client->load($this->url.$param);
            
            foreach($html->find('#id_'.$param) as $row){
                foreach ($row->children as $child){
                    if ($child->tag == 'tr'){
                        foreach ($child->children as $td){
                            if (strpos($td->attr['class'], 'ColumnLast') !== false){
                                $symbol = trim(strip_tags($td));
                                $client = new HtmlWeb();
                                $client->load("http://localhost:8000/quote/{$symbol}");
                                $client->load("http://localhost:8000/quote/dividend/{$symbol}");
                                $this->info($symbol." - loaded");
                            }
                        } 
                    }
                }
            }
        }
    }
}

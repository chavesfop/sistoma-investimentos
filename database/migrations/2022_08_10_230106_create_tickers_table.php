<?php

use App\Models\Ticker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tickers')){
            Schema::create('tickers', function (Blueprint $table) {
                $table->id();
                $table->string('symbol');
                $table->index('symbol');
            });
        }

        $tickers = file_get_contents('symbols.txt');
        $tickers = explode(',', $tickers);
        foreach ($tickers as $symbol){
            $obj = new Ticker;
            $obj->symbol = $symbol;
            $obj->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickers');
    }
}

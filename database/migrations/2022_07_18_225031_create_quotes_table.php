<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('ask')->nullable();
            $table->integer('ask_size')->nullable();
            $table->integer('average_daily_volume_10_day')->nullable();
            $table->integer('average_daily_volume_3_month')->nullable();
            $table->float('bid')->nullable();
            $table->integer('bid_size')->nullable();
            $table->float('book_value')->nullable();
            $table->string('currency')->nullable();
            $table->timestamp('dividend_date')->nullable();
            $table->timestamp('earnings_timestamp')->nullable();
            $table->timestamp('earnings_timestamp_start')->nullable();
            $table->timestamp('earnings_timestamp_end')->nullable();
            $table->float('eps_forward')->nullable();
            $table->float('eps_trailing_twelve_months')->nullable();
            $table->string('exchange')->nullable();
            $table->integer('exchange_data_delayed_by')->nullable();
            $table->string('exchange_timezone_name')->nullable();
            $table->string('exchange_timezone_short_name')->nullable();
            $table->float('fifty_day_average')->nullable();
            $table->float('fifty_day_average_change')->nullable();
            $table->float('fifty_day_average_change_percent')->nullable();
            $table->float('fifty_two_week_high')->nullable();
            $table->float('fifty_two_week_high_change')->nullable();
            $table->float('fifty_two_week_high_change_percent')->nullable();
            $table->float('fifty_two_week_low')->nullable();
            $table->float('fifty_two_week_low_change')->nullable();
            $table->float('fifty_two_week_low_change_percent')->nullable();
            $table->string('financial_currency')->nullable();
            $table->float('forward_p_e')->nullable();
            $table->string('full_exchange_name')->nullable();
            $table->integer('gtm_off_set_milliseconds')->nullable();
            $table->string('language')->nullable();
            $table->string('long_name')->nullable();
            $table->string('market')->nullable();
            $table->integer('market_cap')->nullable();
            $table->string('market_state')->nullable();
            $table->string('message_board_id')->nullable();
            $table->float('post_market_change')->nullable();
            $table->float('post_market_change_percent')->nullable();
            $table->float('post_market_price')->nullable();
            $table->timestamp('post_market_time')->nullable();
            $table->float('pre_market_change')->nullable();
            $table->float('pre_market_change_percent')->nullable();
            $table->float('pre_market_price')->nullable();
            $table->timestamp('pre_market_time')->nullable();
            $table->integer('price_hint')->nullable();
            $table->float('price_to_book')->nullable();
            $table->float('open_interest')->nullable();
            $table->string('quote_source_name')->nullable();
            $table->string('quote_type')->nullable();
            $table->float('regular_market_change')->nullable();
            $table->float('regular_market_change_percent')->nullable();
            $table->float('regular_market_day_high')->nullable();
            $table->float('regular_market_day_low')->nullable();
            $table->float('regular_market_open')->nullable();
            $table->float('regular_market_previous_close')->nullable();
            $table->float('regular_market_price')->nullable();
            $table->timestamp('regular_market_time')->nullable();
            $table->integer('regular_market_volume')->nullable();
            $table->integer('shares_outstanding')->nullable();
            $table->string('short_name')->nullable();
            $table->integer('source_interval')->nullable();
            $table->string('symbol')->nullable();
            $table->boolean('tradeable')->nullable();
            $table->float('trailing_annual_dividend_rate')->nullable();
            $table->float('trailing_annual_dividend_yield')->nullable();
            $table->float('trailing_p_e')->nullable();
            $table->float('two_hundred_day_average')->nullable();
            $table->float('two_hundred_day_average_change')->nullable();
            $table->float('two_hundred_day_average_change_percent')->nullable();

            $table->index('symbol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model implements \JsonSerializable
{
    protected $fillable = [
        'quote',
        'pay_date',
        'value'
    ];
}

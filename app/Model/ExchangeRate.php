<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rate';

    protected $fillable = [
        'date',
        'bank_id',
        'content'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
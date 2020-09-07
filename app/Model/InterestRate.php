<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InterestRate extends Model
{
    protected $table = 'interest_rate';

    protected $fillable = [
        'bank_id',
        'description',
        'content'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}

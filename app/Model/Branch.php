<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branchs';

    protected $fillable = [
    	'bank_id',
    	'district_id',
    	'name',
        'address',
        'other_info'
    ];

    public function province()
    {
    	return $this->belongsTo(Province::class);
    }

    public function district()
    {
    	return $this->belongsTo(District::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}

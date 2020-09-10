<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Atm extends Model
{
    protected $table = 'atms';

    protected $fillable = [
    	'bank_id',
    	// 'province_thebank_id',
		// 'district_thebank_id',
		'name',
		'slug',
		'province_id',
		'district_id',
		'address',
		'other_info',
	];
	
	public function bank()
	{
		return $this->belongsTo(Bank::class);
	}

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function district()
	{
		return $this->belongsTo(District::class);
	}
}

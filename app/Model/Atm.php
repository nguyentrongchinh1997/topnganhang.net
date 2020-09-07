<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Atm extends Model
{
    protected $table = 'atms';

    protected $fillable = [
    	'bank_id',
    	'province_thebank_id',
    	'district_thebank_id',
    	'address'
	];
	
	public function bank()
	{
		return $this->belongsTo(Bank::class);
	}

	public function provinceTheBank()
	{
		return $this->belongsTo(ProvinceTheBank::class);
	}

	public function districtTheBank()
	{
		return $this->belongsTo(DistrictTheBank::class);
	}
}

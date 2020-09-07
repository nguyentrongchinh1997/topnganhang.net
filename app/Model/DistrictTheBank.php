<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DistrictTheBank extends Model
{
    protected $table = 'district_thebank';

    protected $fillable = [
					'id',
			    	'name',
			    	'slug',
			    	'province_thebank_id'
			    ];

	public function provinceTheBank()
	{
		return $this->belongsTo(ProvinceTheBank::class);
	}

	public function atm()
	{
		return $this->hasMany(Atm::class);
	}
}

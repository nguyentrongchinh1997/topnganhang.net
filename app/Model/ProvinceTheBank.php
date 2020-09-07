<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProvinceTheBank extends Model
{
    protected $table = 'province_thebank';

    protected $fillable = [
        'id',
    	'name',
    	'slug',
    ];

    public function districtTheBank()
    {
    	return $this->hasMany(DistrictTheBank::class);
    }

    public function atm()
    {
        return $this->hasMany(Atm::class);
    }
}

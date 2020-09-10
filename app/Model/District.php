<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
			    	'name',
			    	'slug',
			    	'province_id'
			    ];

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function branch()
	{
		return $this->hasMany(Branch::class);
	}

	public function atm()
	{
		return $this->hasMany(Atm::class);
	}
}

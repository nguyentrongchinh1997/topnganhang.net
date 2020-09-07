<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    protected $fillable = [
    	'name_vi',
    	'name_en',
    	'slug',
    	'image',
    	'description',
    	'content'
	];
	
	public function atm()
	{
		return $this->hasMany(Atm::class);
	}

	public function interestRate()
	{
		return $this->hasOne(InterestRate::class);
	}

	public function exchangeRate()
	{
		return $this->hasMany(ExchangeRate::class);
	}

	public function branch()
	{
		return $this->hasMany(Branch::class);
	}
}


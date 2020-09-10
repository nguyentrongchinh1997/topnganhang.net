<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
    	'name',
    	'slug',
    ];

    public function district()
    {
    	return $this->hasMany(District::class);
    }

    public function branch()
    {
        return $this->hasManyThrough(Branch::class, District::class);
    }

    public function atm()
	{
		return $this->hasMany(Atm::class);
	}
}

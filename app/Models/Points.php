<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
  protected $table = 'points';
	protected $guarded = ['id'];

	public function points()
	{
		return $this->select(DB::raw('id, name, description, ST_AsGeoJSON(geom) as geom, created_at, updated_at'))->get();
	}
}

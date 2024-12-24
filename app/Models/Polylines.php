<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Polylines extends Model
{
  protected $table = 'polylines';
	protected $guarded = ['id'];

	public function polylines()
	{
		return $this->select(DB::raw('id, name, description, ST_AsGeoJSON(geom) as geom, ST_Length(ST_SRID(geom, 4326)) as length, created_at, updated_at'))->get();
	}

	public function polyline($id)
	{
		return $this->select(DB::raw('id, name, description, ST_AsGeoJSON(geom) as geom, ST_Length(ST_SRID(geom, 4326)) as length, created_at, updated_at'))->find($id);
	}
}

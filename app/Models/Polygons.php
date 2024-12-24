<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Polygons extends Model
{
  protected $table = 'polygons';
	protected $guarded = ['id'];

	public function polygons()
	{
		return $this->select(DB::raw('id, name, description, ST_AsGeoJSON(geom) as geom, ST_Area(ST_SRID(geom, 4326)) as area, created_at, updated_at'))->get();
	}
}

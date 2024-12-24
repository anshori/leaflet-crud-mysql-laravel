<?php

namespace App\Http\Controllers;

use App\Models\Points;
use App\Models\Polygons;
use App\Models\Polylines;
use Illuminate\Http\Request;

class ApiController extends Controller
{
	public function __construct()
	{
		$this->point = new Points();
		$this->polyline = new Polylines();
		$this->polygon = new Polygons();
	}

	public function points()
	{
		$points = $this->point->points();
		$feature = array();

		foreach ($points as $p) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($p->geom),
				'properties' => [
					'id' => $p->id,
					'name' => $p->name,
					'description' => $p->description,
					'created_at' => $p->created_at,
					'updated_at' => $p->updated_at
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function point(string $id)
	{
		$p = $this->point->point($id);

		$feature = array();

		$feature[] = [
			'type' => 'Feature',
			'geometry' => json_decode($p->geom),
			'properties' => [
				'id' => $p->id,
				'name' => $p->name,
				'description' => $p->description,
				'created_at' => $p->created_at,
				'updated_at' => $p->updated_at
			]
		];

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function polylines()
	{
		$polylines = $this->polyline->polylines();
		$feature = array();

		foreach ($polylines as $p) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($p->geom),
				'properties' => [
					'id' => $p->id,
					'name' => $p->name,
					'description' => $p->description,
					'length' => $p->length, // in meters
					'created_at' => $p->created_at,
					'updated_at' => $p->updated_at
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function polyline(string $id)
	{
		$p = $this->polyline->polyline($id);

		$feature = array();

		$feature[] = [
			'type' => 'Feature',
			'geometry' => json_decode($p->geom),
			'properties' => [
				'id' => $p->id,
				'name' => $p->name,
				'description' => $p->description,
				'length' => $p->length, // in square meters
				'created_at' => $p->created_at,
				'updated_at' => $p->updated_at
			]
		];

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function polygons()
	{
		$polygons = $this->polygon->polygons();
		$feature = array();

		foreach ($polygons as $p) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($p->geom),
				'properties' => [
					'id' => $p->id,
					'name' => $p->name,
					'description' => $p->description,
					'area' => $p->area, // in square meters
					'created_at' => $p->created_at,
					'updated_at' => $p->updated_at
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function polygon(string $id)
	{
		$p = $this->polygon->polygon($id);

		$feature = array();

		$feature[] = [
			'type' => 'Feature',
			'geometry' => json_decode($p->geom),
			'properties' => [
				'id' => $p->id,
				'name' => $p->name,
				'description' => $p->description,
				'area' => $p->area, // in square meters
				'created_at' => $p->created_at,
				'updated_at' => $p->updated_at
			]
		];

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}
}

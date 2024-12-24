<?php

namespace App\Http\Controllers;

use App\Models\Polygons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolygonController extends Controller
{
	public function __construct()
	{
		$this->polygon = new Polygons();
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$data = [
			'name' => $request->name,
			'description' => $request->description,
			'geom' => DB::raw("ST_GeomFromText('$request->geom_polygon')")
		];

		// create polygon
		if (!$this->polygon->create($data)) {
			return redirect()->back()->with('error', 'Failed to create polygon');
		}

		// redirect back
		return redirect()->back()->with('success', 'Polygon created successfully');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$data = [
			'title' => 'Edit Polygon',
			'page' => 'edit-polygon',
			'id' => $id
		];

		return view('edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$data = [
			'name' => $request->name,
			'description' => $request->description,
			'geom' => DB::raw("ST_GeomFromText('$request->geom')")
		];

		if (!$this->polygon->find($id)->update($data)) {
			return redirect()->back()->with('error', 'Failed to update polygon');
		}

		return redirect()->route('/')->with('success', 'Polygon updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (!$this->polygon->destroy($id)) {
			return redirect()->back()->with('error', 'Failed to delete polygon');
		}

		return redirect()->back()->with('success', 'Polygon deleted successfully');
	}
}

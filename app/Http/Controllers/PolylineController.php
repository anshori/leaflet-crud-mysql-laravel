<?php

namespace App\Http\Controllers;

use App\Models\Polylines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolylineController extends Controller
{
	public function __construct()
	{
		$this->polyline = new Polylines();
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
			'geom' => DB::raw("ST_GeomFromText('$request->geom_polyline')")
		];

		// create polyline
		if (!$this->polyline->create($data)) {
			return redirect()->back()->with('error', 'Failed to create polyline');
		}

		// redirect back
		return redirect()->back()->with('success', 'Polyline created successfully');
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
			'title' => 'Edit Polyline',
			'page' => 'edit-polyline',
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

		if (!$this->polyline->find($id)->update($data)) {
			return redirect()->back()->with('error', 'Failed to update polyline');
		}

		return redirect()->route('/')->with('success', 'Polyline updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (!$this->polyline->destroy($id)) {
			return redirect()->back()->with('error', 'Failed to delete polyline');
		}

		return redirect()->back()->with('success', 'Polyline deleted successfully');
	}
}

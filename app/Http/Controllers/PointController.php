<?php

namespace App\Http\Controllers;

use App\Models\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
	public function __construct()
	{
		$this->point = new Points();
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
			'geom' => DB::raw("ST_GeomFromText('$request->geom_point')")
		];

		// create point
		if (!$this->point->create($data)) {
			return redirect()->back()->with('error', 'Failed to create point');
		}

		// redirect back
		return redirect()->back()->with('success', 'Point created successfully');
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
			'title' => 'Edit Point',
			'page' => 'edit-point',
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

		if (!$this->point->find($id)->update($data)) {
			return redirect()->back()->with('error', 'Failed to update point');
		}

		return redirect()->route('/')->with('success', 'Point updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		if (!$this->point->destroy($id)) {
			return redirect()->back()->with('error', 'Failed to delete point');
		}

		return redirect()->back()->with('success', 'Point deleted successfully');
	}
}

<?php

class Unit_officesController extends BaseController {

	/**
	 * Unit_office Repository
	 *
	 * @var Unit_office
	 */
	protected $unit_office;

	public function __construct(Unit_office $unit_office)
	{
		$this->unit_office = $unit_office;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit_offices = DB::table('unit_offices')->get();

		return View::make('unit_offices.index', compact('unit_offices'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('unit_offices.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Unit_office::$rules);

		if ($validation->passes())
		{
			$this->unit_office->create($input);

			return Redirect::route('unit_offices.index');
		}

		return Redirect::route('unit_offices.index')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$unit_office = $this->unit_office->findOrFail($id);

		return View::make('unit_offices.show', compact('unit_office'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unit_office = $this->unit_office->find($id);

		if (is_null($unit_office))
		{
			return Redirect::route('unit_offices.index');
		}

		return View::make('unit_offices.edit', compact('unit_office'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Unit_office::$rules);

		if ($validation->passes())
		{
			$unit_office = $this->unit_office->find($id);
			$unit_office->update($input);

			return Redirect::route('unit_offices.show', $id);
		}

		return Redirect::route('unit_offices.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->unit_office->find($id)->delete();

		return Redirect::route('unit_offices.index');
	}

}

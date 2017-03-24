<?php

class Unit_office_secondariesController extends BaseController {

	/**
	 * Unit_office_secondary Repository
	 *
	 * @var Unit_office_secondary
	 */
	protected $unit_office_secondary;

	public function __construct(Unit_office_secondary $unit_office_secondary)
	{
		$this->unit_office_secondary = $unit_office_secondary;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit_office_secondaries = $this->unit_office_secondary->all();

		$unit_offices=DB::table('unit_offices')->get();
		$unit_offices_id=DB::table('unit_offices')->where('UnitOfficeHasField','=','True')
		->lists('UnitOfficeName','id');

		return View::make('unit_office_secondaries.index', compact('unit_office_secondaries'))
		->with('unit_offices', $unit_offices)
		->with('unit_offices_id',$unit_offices_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('unit_office_secondaries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Unit_office_secondary::$rules);

		if ($validation->passes())
		{
			$this->unit_office_secondary->create($input);

			return Redirect::route('unit_office_secondaries.index');
		}

		return Redirect::route('unit_office_secondaries.index')
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
		$unit_office_secondary = $this->unit_office_secondary->findOrFail($id);

		$unit_offices=DB::table('unit_offices')->get();
		$unit_offices_id=DB::table('unit_offices')->where('UnitOfficeHasField','=','True')
		->lists('UnitOfficeName','id');
		return View::make('unit_office_secondaries.show', compact('unit_office_secondary'))
		->with('unit_offices', $unit_offices)
		->with('unit_offices_id',$unit_offices_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unit_office_secondary = $this->unit_office_secondary->find($id);
		$unit_offices=DB::table('unit_offices')->get();
		$unit_offices_id=DB::table('unit_offices')->where('UnitOfficeHasField','=','True')
		->lists('UnitOfficeName','id');


		if (is_null($unit_office_secondary))
		{
			return Redirect::route('unit_office_secondaries.index');
		}

		return View::make('unit_office_secondaries.edit', compact('unit_office_secondary'))
		->with('unit_offices', $unit_offices)
		->with('unit_offices_id',$unit_offices_id);
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
		$validation = Validator::make($input, Unit_office_secondary::$rules);

		if ($validation->passes())
		{
			$unit_office_secondary = $this->unit_office_secondary->find($id);
			$unit_office_secondary->update($input);

			return Redirect::route('unit_office_secondaries.show', $id);
		}

		return Redirect::route('unit_office_secondaries.edit', $id)
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
		$this->unit_office_secondary->find($id)->delete();

		return Redirect::route('unit_office_secondaries.index');
	}

}

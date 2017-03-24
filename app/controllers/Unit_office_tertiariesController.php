<?php

class Unit_office_tertiariesController extends BaseController {

	/**
	 * Unit_office_tertiary Repository
	 *
	 * @var Unit_office_tertiary
	 */
	protected $unit_office_tertiary;

	public function __construct(Unit_office_tertiary $unit_office_tertiary)
	{
		$this->unit_office_tertiary = $unit_office_tertiary;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit_office_tertiaries = $this->unit_office_tertiary->all();

		$secondary_unit_offices=DB::table('unit_office_secondaries')->get();
		$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
		->lists('UnitOfficeSecondaryName','id');

		return View::make('unit_office_tertiaries.index', compact('unit_office_tertiaries'))
		->with('secondary_unit_offices', $secondary_unit_offices)
		->with('secondary_unit_offices_id',$secondary_unit_offices_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('unit_office_tertiaries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Unit_office_tertiary::$rules);

		if ($validation->passes())
		{
			$this->unit_office_tertiary->create($input);

			return Redirect::route('unit_office_tertiaries.index');
		}

		return Redirect::route('unit_office_tertiaries.index')
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
		$unit_office_tertiary = $this->unit_office_tertiary->findOrFail($id);
		$secondary_unit_offices=DB::table('unit_office_secondaries')->get();
		$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
		->lists('UnitOfficeSecondaryName','id');

		return View::make('unit_office_tertiaries.show', compact('unit_office_tertiary'))
		->with('secondary_unit_offices', $secondary_unit_offices)
		->with('secondary_unit_offices_id',$secondary_unit_offices_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unit_office_tertiary = $this->unit_office_tertiary->find($id);
		$secondary_unit_offices=DB::table('unit_office_secondaries')->get();
		$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
		->lists('UnitOfficeSecondaryName','id');


		if (is_null($unit_office_tertiary))
		{
			return Redirect::route('unit_office_tertiaries.index');
		}

		return View::make('unit_office_tertiaries.edit', compact('unit_office_tertiary'))
		->with('secondary_unit_offices', $secondary_unit_offices)
		->with('secondary_unit_offices_id',$secondary_unit_offices_id);
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
		$validation = Validator::make($input, Unit_office_tertiary::$rules);

		if ($validation->passes())
		{
			$unit_office_tertiary = $this->unit_office_tertiary->find($id);
			$unit_office_tertiary->update($input);

			return Redirect::route('unit_office_tertiaries.show', $id);
		}

		return Redirect::route('unit_office_tertiaries.edit', $id)
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
		$this->unit_office_tertiary->find($id)->delete();

		return Redirect::route('unit_office_tertiaries.index');
	}

}

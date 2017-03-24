<?php

class Unit_office_quaternariesController extends BaseController {

	/**
	 * Unit_office_quaternary Repository
	 *
	 * @var Unit_office_quaternary
	 */
	protected $unit_office_quaternary;

	public function __construct(Unit_office_quaternary $unit_office_quaternary)
	{
		$this->unit_office_quaternary = $unit_office_quaternary;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit_office_quaternaries = $this->unit_office_quaternary->all();

		$tertiary_unit_offices=DB::table('unit_office_tertiaries')->get();
		$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')->where('UnitOfficeHasQuaternary','=','True')
		->lists('UnitOfficeTertiaryName','id');

		return View::make('unit_office_quaternaries.index', compact('unit_office_quaternaries'))
		->with('tertiary_unit_offices', $tertiary_unit_offices)
		->with('tertiary_unit_offices_id',$tertiary_unit_offices_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('unit_office_quaternaries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Unit_office_quaternary::$rules);

		if ($validation->passes())
		{
			$this->unit_office_quaternary->create($input);

			return Redirect::route('unit_office_quaternaries.index');
		}

		return Redirect::route('unit_office_quaternaries.index')
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
		$unit_office_quaternary = $this->unit_office_quaternary->findOrFail($id);
		$tertiary_unit_offices=DB::table('unit_office_tertiaries')->get();
		$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')->where('UnitOfficeHasQuaternary','=','True')
		->lists('UnitOfficeTertiaryName','id');

		return View::make('unit_office_quaternaries.show', compact('unit_office_quaternary'))
		->with('tertiary_unit_offices', $tertiary_unit_offices)
		->with('tertiary_unit_offices_id',$tertiary_unit_offices_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unit_office_quaternary = $this->unit_office_quaternary->find($id);
		$tertiary_unit_offices=DB::table('unit_office_tertiaries')->get();
		$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')->where('UnitOfficeHasQuaternary','=','True')
		->lists('UnitOfficeTertiaryName','id');


		if (is_null($unit_office_quaternary))
		{
			return Redirect::route('unit_office_quaternaries.index');
		}

		return View::make('unit_office_quaternaries.edit', compact('unit_office_quaternary'))
		->with('tertiary_unit_offices', $tertiary_unit_offices)
		->with('tertiary_unit_offices_id',$tertiary_unit_offices_id);
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
		$validation = Validator::make($input, Unit_office_quaternary::$rules);

		if ($validation->passes())
		{
			$unit_office_quaternary = $this->unit_office_quaternary->find($id);
			$unit_office_quaternary->update($input);

			return Redirect::route('unit_office_quaternaries.show', $id);
		}

		return Redirect::route('unit_office_quaternaries.edit', $id)
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
		$this->unit_office_quaternary->find($id)->delete();

		return Redirect::route('unit_office_quaternaries.index');
	}


public function anyUnitQua()
	    {
	        
	        $unit_office_quaternaries = DB::table('unit_office_quaternaries')
				->join('unit_office_tertiaries', 'unit_office_quaternaries.UnitOfficeTertiaryID', '=', 'unit_office_tertiaries.id' )
				->select('unit_office_quaternaries.id', 'unit_office_quaternaries.UnitOfficeQuaternaryName as UnitOfficeQuaternaryName', 'unit_office_tertiaries.UnitOfficeTertiaryName as UnitOfficeTertiaryName')
				->where('unit_office_tertiaries.UnitOfficeHasQuaternary','=','True');
			

	        return Datatables::of($unit_office_quaternaries)
	        
	        ->add_column('Actions', '

	        	<a class = \'btn btn-warning\' href="{{ URL::to(\'unit_office_quaternaries/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_office_quaternaries/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>

	        	<br><br>

                <a class = \'btn btn-info\'  href="{{ URL::to(\'unit_office_quaternaries/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'unit_office_quaternaries/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
	        ->remove_column('$unit_office_quaternaries.id')
	        ->make(true);
	    }
}
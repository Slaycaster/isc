<?php

class UnitAdminQuaternaryOfficeController extends BaseController {

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
		if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');
			$unit_offices=DB::table('unit_offices')
			->where('id','=',$unitoffice_id)
			->get();

		$secondaryoffice = DB::table('unit_office_tertiaries')
		->where('id','=',$secondaryoffice_id)
		->get();


			$unit_office_quaternaries = $this->unit_office_quaternary->all();
			$tertiary_unit_offices=DB::table('unit_office_tertiaries')->get();
			$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')->where('UnitOfficeHasQuaternary','=','True')
			->lists('UnitOfficeTertiaryName','id');

				
				

		

		return View::make('UnitAdminQuaternaryOffice')
		->with('secondaryoffice',$secondaryoffice)
		->with('name',$name)
		->with('unit_offices',$unit_offices)
		->with('secondaryoffice_id',$secondaryoffice_id)
		->with('tertiary_unit_offices', $tertiary_unit_offices)
		->with('tertiary_unit_offices_id',$tertiary_unit_offices_id);

			}
		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
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


			return Redirect::route('UnitAdminQuaternaryOffice.index');
		}

		return Redirect::route('UnitAdminQuaternaryOffice.index')
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

		return View::make('UnitAdminShowQuaternaryOffice', compact('unit_office_quaternary'))
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
		$secondaryoffice_id = Session::get('secondaryunit','default');
$unitoffice_id = Session::get('primaryunit','default');
		if($secondaryoffice_id == '0')
		{
			$secondary = DB::table('unit_office_secondaries')
			->select('id')
			->where('UnitOfficeID','=',$unitoffice_id)
			->lists('id');

			$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')
			->where('UnitOfficeHasQuaternary','=','True')
			->whereIn('UnitOfficeSecondaryID',$secondary)
			->lists('UnitOfficeTertiaryName','id');

			$tertiary_unit_offices= DB::table('unit_office_tertiaries')
			->get();
		}
		else
		{
			$tertiary_unit_offices=DB::table('unit_office_tertiaries')
		->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
		->get();
		

		$tertiary_unit_offices_id=DB::table('unit_office_tertiaries')
		->where('UnitOfficeHasQuaternary','=','True')
		->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
		->lists('UnitOfficeTertiaryName','id');
		}
		


		if (is_null($unit_office_quaternary))
		{
			return Redirect::route('unit_office_quaternaries.index');
		}

		return View::make('UnitAdminEditQuaternaryOffice', compact('unit_office_quaternary'))
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

			return Redirect::route('UnitAdminQuaternaryOffice.show', $id);
		}

		return Redirect::route('UnitAdminQuaternaryOffice.edit', $id)
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

	public function anyUniQua()
        {
        	if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');
            
            $unit_office_quaternaries = DB::table('unit_office_quaternaries')
                ->join('unit_office_tertiaries', 'unit_office_quaternaries.UnitOfficeTertiaryID', '=', 'unit_office_tertiaries.id' )
                ->join('unit_office_secondaries', 'unit_office_tertiaries.UnitOfficeSecondaryID', '=', 'unit_office_secondaries.id' )
                ->select('unit_office_quaternaries.id', 'unit_office_quaternaries.UnitOfficeQuaternaryName as UnitOfficeQuaternaryName', 'unit_office_tertiaries.UnitOfficeTertiaryName as UnitOfficeTertiaryName')
                ->where('unit_office_tertiaries.UnitOfficeHasQuaternary','=','True')
				->where('unit_office_secondaries.UnitOfficeID', '=', $unitoffice_id);
            

            return Datatables::of($unit_office_quaternaries)
            
            ->add_column('Actions', '

                 <a class = \'btn btn-warning\' href="{{ URL::to(\'UnitAdminQuaternaryOffice/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UnitAdminQuaternaryOffice/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>
                        
                 <br><br>
                <a class = \'btn btn-info\'  href="{{ URL::to(\'UnitAdminQuaternaryOffice/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'UnitAdminQuaternaryOffice/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
            ->remove_column('$unit_office_quaternaries.id')
            ->make(true);
            }
		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}

        }

}

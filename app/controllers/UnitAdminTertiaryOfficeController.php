<?php

class UnitAdminTertiaryOfficeController extends BaseController {

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
		if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');
		$unit_offices=DB::table('unit_offices')
		->where('id','=',$unitoffice_id)
		->get();

		$secondaryoffice = DB::table('unit_office_secondaries')
		->where('id','=',$secondaryoffice_id)
		->get();
		
		

		if($secondaryoffice_id == '0')
		{
			//$unit_office_tertiaries = $this->unit_office_tertiary->all();

			$unit_office_tertiaries= DB::table('unit_office_secondaries')
			->join('unit_office_tertiaries', 'unit_office_secondaries.id','=','unit_office_tertiaries.UnitOfficeSecondaryID')
			->where('unit_office_secondaries.UnitOfficeID','=',$unitoffice_id)
			->get();

			$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
			->where('UnitOfficeID','=',$unitoffice_id)
			->lists('UnitOfficeSecondaryName','id');	


			$secondary_unit_offices=DB::table('unit_office_secondaries')
			->get();
		}
		else
		{
			$unit_office_tertiaries = $this->unit_office_tertiary->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)->get();


			$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
			->where('id','=',$secondaryoffice_id)
			->lists('UnitOfficeSecondaryName','id');


			$secondary_unit_offices=DB::table('unit_office_secondaries')
			->where('id','=',$secondaryoffice_id)
			->get();
		}
		return View::make('UnitAdminTertiaryOffice', compact('unit_office_tertiaries'))
		->with('secondary_unit_offices', $secondary_unit_offices)
		->with('secondaryoffice',$secondaryoffice)
		->with('name',$name)
		->with('unit_offices',$unit_offices)
		->with('secondaryoffice_id',$secondaryoffice_id)
		->with('secondary_unit_offices_id',$secondary_unit_offices_id);
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
		return View::make('unit_office_tertiaries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//$secondaryid = Input::get('secondaryid');
		//$tertiaryname = Input::get('UnitOfficeTertiaryName');
		//$ifhasquaternary = Input::get('UnitOfficeHasQuaternary');

		//DB::table('unit_office_tertiaries')
		//->insert(array('UnitOfficeTertiaryName' => $tertiaryname,'UnitOfficeHasQuaternary' => $ifhasquaternary, 'UnitOfficeSecondaryID' => $secondaryid));
	
		//return Redirect::route('UnitAdminTertiaryOffice.index');
		$input = Input::all();
		$validation = Validator::make($input, Unit_office_tertiary::$rules);

		if ($validation->passes())
		{
			$this->unit_office_tertiary->create($input);

			return Redirect::route('UnitAdminTertiaryOffice.index');
		}

		return Redirect::route('UnitAdminTertiaryOffice.index')
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

		return View::make('UnitAdminShowTertiaryOffice', compact('unit_office_tertiary'))
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
					$secondaryoffice_id = Session::get('secondaryunit','default');
$unitoffice_id = Session::get('primaryunit','default');
		
		if($secondaryoffice_id == '0')
		{
			$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
			->where('UnitOfficeID','=',$unitoffice_id)
			->lists('UnitOfficeSecondaryName','id');
		}
		else
		{

		$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
			->where('id','=',$secondaryoffice_id)
			->lists('UnitOfficeSecondaryName','id');

		}
	
			$secondary_unit_offices=DB::table('unit_office_secondaries')
		->where('id','=',$secondaryoffice_id)
		->get();
		//$secondary_unit_offices_id=DB::table('unit_office_secondaries')->where('UnitOfficeHasTertiary','=','True')
		//->lists('UnitOfficeSecondaryName','id');


		if (is_null($unit_office_tertiary))
		{
			return Redirect::route('unit_office_tertiaries.index');
		}

		return View::make('UnitAdminEditTertiaryOffice', compact('unit_office_tertiary'))
		->with('secondary_unit_offices', $secondary_unit_offices)
		->with('secondaryoffice_id',$secondaryoffice_id)
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
		
		
		//$secondaryid = Input::get('secondaryid');
		//$tertiaryname = Input::get('UnitOfficeTertiaryName');
		//$ifhasquaternary = Input::get('UnitOfficeHasQuaternary');

		//DB::table('unit_office_tertiaries')
		//->where('id','=',$id)
		//->update(array('UnitOfficeTertiaryName' => $tertiaryname,'UnitOfficeHasQuaternary' => $ifhasquaternary, 'UnitOfficeSecondaryID' => $secondaryid));
	
		//return Redirect::to('UnitAdminTertiaryOffice/' . $id);
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Unit_office_tertiary::$rules);

		if ($validation->passes())
		{
			$unit_office_tertiary = $this->unit_office_tertiary->find($id);
			$unit_office_tertiary->update($input);

			return Redirect::to('UnitAdminTertiaryOffice/' . $id);
		}

		return Redirect::route('UnitAdminTertiaryOffice.edit', $id)
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

	public function anyUniTer()
	    {
	    	if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			
	        
	        $unit_office_tertiaries = DB::table('unit_office_tertiaries')
				->join('unit_office_secondaries', 'unit_office_tertiaries.UnitOfficeSecondaryID', '=', 'unit_office_secondaries.id' )
				->select('unit_office_tertiaries.id', 'unit_office_tertiaries.UnitOfficeTertiaryName as UnitOfficeTertiaryName', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName', 'unit_office_tertiaries.UnitOfficeHasQuaternary as UnitOfficeHasQuaternary')
				->where('unit_office_secondaries.UnitOfficeHasTertiary','=','True')
				->where('unit_office_secondaries.UnitOfficeID', '=', $unitoffice_id);


	        return Datatables::of($unit_office_tertiaries)
	        
	        ->add_column('Actions', '

	        	<a class = \'btn btn-warning\' href="{{ URL::to(\'UnitAdminTertiaryOffice/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UnitAdminTertiaryOffice/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>
	        	<br><br>

                <a class = \'btn btn-info\'  href="{{ URL::to(\'UnitAdminTertiaryOffice/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'UnitAdminTertiaryOffice/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
	        ->make(true);
	    }
	        else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}

	    }

}

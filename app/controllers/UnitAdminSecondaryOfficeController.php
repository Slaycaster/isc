<?php

class UnitAdminSecondaryOfficeController extends BaseController {

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
		if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');

		$unit_office_secondaries = $this->unit_office_secondary->where('UnitOfficeID','=',$unitoffice_id)->get();

		$unit_offices=DB::table('unit_offices')
		->where('id','=',$unitoffice_id)
		->get();

		$unit_offices_id=DB::table('unit_offices')->where('UnitOfficeHasField','=','True')
		->lists('UnitOfficeName','id');

		return View::make('UnitAdminSecondaryOffice', compact('unit_office_secondaries'))
		->with('unit_offices', $unit_offices)
		->with('name',$name)
		->with('unit_offices_id',$unit_offices_id)
		->with('unitoffice_id',$unitoffice_id);
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
		return View::make('unit_office_secondaries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$unitid = Input::get('unitofficeid');
		$secondaryname = Input::get('UnitOfficeSecondaryName');
		$ifhasteriary = Input::get('UnitOfficeHasTertiary');

		DB::table('unit_office_secondaries')
		->insert(array('UnitOfficeSecondaryName' => $secondaryname,'UnitOfficeHasTertiary' => $ifhasteriary, 'UnitOfficeID' => $unitid));
	
		return Redirect::route('UnitAdminSecondaryOffice.index');
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
		return View::make('UnitAdminShowSecondaryOffice', compact('unit_office_secondary'))
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

		$unitoffice_id = Session::get('primaryunit','default');
		$unit_offices=DB::table('unit_offices')
		->where('id','=',$unitoffice_id)
		->get();
		$unit_offices_id=DB::table('unit_offices')->where('UnitOfficeHasField','=','True')
		->lists('UnitOfficeName','id');


		if (is_null($unit_office_secondary))
		{
			return Redirect::route('unit_office_secondaries.index');
		}

		return View::make('UnitAdminEditSecondaryOffice', compact('unit_office_secondary'))
		->with('unit_offices', $unit_offices)
		->with('unitoffice_id',$unitoffice_id)
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
		$unitid = Input::get('unitofficeid');
		$secondaryname = Input::get('UnitOfficeSecondaryName');
		$ifhasteriary = Input::get('UnitOfficeHasTertiary');

		DB::table('unit_office_secondaries')
		->where('id','=',$id)
		->update(array('UnitOfficeSecondaryName' => $secondaryname,'UnitOfficeHasTertiary' => $ifhasteriary, 'UnitOfficeID' => $unitid));
	
		return Redirect::to('UnitAdminSecondaryOffice/' . $id);

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

	public function anyUniSec()
	    {
	    	if (Session::has('unitadminid') && Session::has('unitadminname')) {

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');
	        
	        $unit_office_secondaries = DB::table('unit_office_secondaries')

				->join('unit_offices', 'unit_office_secondaries.UnitOfficeID', '=', 'unit_offices.id' )
				->select('unit_office_secondaries.id', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName', 'unit_offices.UnitOfficeName as UnitOfficeName', 'unit_office_secondaries.UnitOfficeHasTertiary as UnitOfficeHasTertiary')
				->where('unit_office_secondaries.UnitOfficeID','=',$unitoffice_id);
				

	        return Datatables::of($unit_office_secondaries)
	        
	        ->add_column('Actions', '

	        	<a class = \'btn btn-warning\' href="{{ URL::to(\'UnitAdminSecondaryOffice/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UnitAdminSecondaryOffice/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>
	        	<br><br>
                            <a class = \'btn btn-info\'  href="{{ URL::to(\'UnitAdminSecondaryOffice/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'UnitAdminSecondaryOffice/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
	        ->remove_column('$unit_office_secondaries.id')
	        ->make(true);

	        }
		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
	    }

}

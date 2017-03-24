<?php

use App\Http\Requests;
use App\User;
use Bllim\Datatables\Facade\Datatables;

class UnitAdminController extends BaseController {

	/**
	 * Unit_admin Repository
	 *
	 * @var Unit_admin
	 */
	protected $unit_admin;

	public function __construct(UnitAdmin $unit_admin)
	{
		$this->unit_admin = $unit_admin;
	}

	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$unit_admins = DB::table('unit_admins')
							->get();
		$unit_offices = DB::table('unit_offices')
							->get();
		$unit_offices_id = ['Select Unit/Office...'] + DB::table('unit_offices')
							->orderBy('UnitOfficeName','asc')
							->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')
										->get();
		$unit_offices_secondaries_id = ['none...'];
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')
										->get();
		$ranks = DB::table('ranks')
					->get();
		$ranks_id = DB::table('ranks')
					->orderBy('Hierarchy','asc')
					->lists('RankCode','id');
	
		$id_dropdown = "0";
		$id_dropdown2 = "0";
		
		return View::make('unit_admins.index', compact('unit_admins'))
					->with('unit_admins', $unit_admins)
					->with('id_dropdown', $id_dropdown)
					->with('id_dropdown2', $id_dropdown2)
					->with('ranks',$ranks)
					->with('ranks_id',$ranks_id)
					->with('unit_offices',$unit_offices)
					->with('unit_offices_id',$unit_offices_id)
					->with('unit_offices_secondaries',$unit_offices_secondaries)
					->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);	
	}
	public function indexDataTable()
	{
		$unit_admin_ajax = DB::table('unit_admins')
							->join('unit_offices', 'unit_admins.UnitOfficeID' , '=', 'unit_offices.id')
							->leftJoin('unit_office_secondaries', 'unit_admins.UnitOfficeSecondaryID', '=', 'unit_office_secondaries.id')
							->select('unit_admins.id as id' ,'unit_admins.LastName as LastName', 'unit_admins.FirstName as FirstName', 'unit_offices.UnitOfficeName as UnitOfficeName', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName')
							->groupBy('unit_admins.LastName')
							->orderBy('unit_admins.LastName');


		return Datatables::of($unit_admin_ajax)
        ->add_column('Actions', '<a class = \'btn btn-warning\' style="margin-bottom:3px" href="{{ URL::to(\'unit_admins/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_admins/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>
        						 <br>
                        		 <a class = \'btn btn-info\'  style="margin-bottom:3px" href="{{ URL::to(\'unit_admins/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'unit_admins/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                        		 <br>
                        		 <a class = \'btn btn-success\'  style="margin-bottom:3px" href="{{ URL::to(\'unit_admins/unit/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_admins/unit/\' . $id) }}\', \'newwindow\', \'width=500, height=500\'); return false;">Unit</a>
                        		 <br>
                    ')
        ->remove_column('id')
        ->make(true);
	}

	public function ajaxPostIndex()
	{
		
		//$unit_admins = DB::table('unit_admins')->get();
		$id_dropdown = $_REQUEST['UnitOfficeID'];
		//$ranks = DB::table('ranks')->get();
		//$ranks_idn = DB::table('ranks')->orderBy('RankCode','asc')
		//				->lists('RankCode','id');

		//$unit_offices = DB::table('unit_offices')->get();
		//$unit_offices_id = DB::table('unit_offices')
		//						->where('id', '=', $id_dropdown)
		//						->orderBy('UnitOfficeName','asc')
		//						->get();
		
		//$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')
										->where('UnitOfficeID', '=', $id_dropdown)
										->orderBy('UnitOfficeSecondaryName','asc')
										->get();
		return Response::json($unit_offices_secondaries_id);
			
	}

	public function postindex()
	{
		
		$unit_admins = DB::table('unit_admins')->get();
		$id_dropdown = Input::get('UnitOfficeID');
		$id_dropdown2='0';
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');
		
		return View::make('unit_admins.index', compact('unit_admins'))
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('unit_admins', $unit_admins)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);	
	}

	public function postindex2()
	{
		
		$unit_admins = DB::table('unit_admins')->get();
		$id_dropdown = Input::get('UnitOfficeID');
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		return View::make('unit_admins.index', compact('unit_admins'))
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('unit_admins', $unit_admins)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);	
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('unit_admins.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$input = Input::all();
		$validation = Validator::make($input, UnitAdmin::$rules);

		if ($validation->passes())
		{

			#$units = DB::table('unit_admins')->where('UnitOfficeID', '=', $id_dropdown)
			#->where('UnitOfficeSecondaryID', '=', $id_dropdown2)->get();
			
			#if($units == null)
			#{
				$unit_admin = new UnitAdmin;
				$unit_admin->LastName = Input::get('LastName');
				$unit_admin->FirstName = Input::get('FirstName');
				$unit_admin->UserName = Input::get('UserName');
				$unit_admin->Password = Input::get('Password');
				$unit_admin->AdminEmail = Input::get('AdminEmail');
				$unit_admin->UnitOfficeID = $id_dropdown;
				$unit_admin->UnitOfficeSecondaryID = $id_dropdown2;
				$unit_admin->state = 'Enable';
				$unit_admin->save();

				Session::flash('message', 'Unit Admin successfully created');
				return Redirect::route('unit_admins.index');
			#}
			#else
			#{
			#	Session::flash('message2', 'Unit/Office already has Unit Admin');
			#	return Redirect::route('unit_admins.index');
			#}

		}
		

		return Redirect::route('unit_admins.index')
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
		$unit_admin = $this->unit_admin->findOrFail($id);
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		return View::make('unit_admins.show', compact('unit_admin'))
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries);
			
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unit_admin = $this->unit_admin->find($id);

		if (is_null($unit_admin))
		{
			return Redirect::route('unit_admins.index');
		}

		return View::make('unit_admins.edit', compact('unit_admin'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$input = Input::all();
		$validation = Validator::make($input, UnitAdmin::$rules);


		if($validation->passes())
		{
			$unit_admin = $this->unit_admin->find($id);
			$unit_admin ->update($input);

			return Redirect::route('unit_admins.show', $id);
		}

				/*
				$unit_admin = new Unit_admin;
				$unit_admin->LastName = Input::get('LastName');
				$unit_admin->FirstName = Input::get('FirstName');
				$unit_admin->UserName = Input::get('UserName');
				$unit_admin->Password = Input::get('Password');
				*/
				
				#$unit_admin->update();

				
		return Redirect::route('unit_admins.show', $id)
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
		$this->unit_admin->find($id)->delete();

		return Redirect::route('unit_admins.index');
	}

}

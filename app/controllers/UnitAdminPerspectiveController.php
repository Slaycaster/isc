<?php

class UnitAdminPerspectiveController extends BaseController {

	public function __construct(Perspective $perspective)
	{
		$this->perspective = $perspective;
	}

		public function index()
		{
				
				if (Session::has('unitadminid') && Session::has('unitadminname')) 
				{

						$id = Session::get('unitadminid', 'default');

						$name = Session::get('unitadminname', 'default');

						$unitoffice_id = Session::get('primaryunit','default');

						$perspectives_name = DB::table('perspectives')
						->get();
						$perspectives = DB::table('perspective_unitoffices')
						->where('UnitOfficeID','=',$unitoffice_id)
						->get();

						return View::make('UnitAdminPerspective')
							->with('id', $id)
							->with('name',$name)
							->with('unitoffice_id',$unitoffice_id)
							->with('perspectives_name',$perspectives_name)
							->with('perspectives',$perspectives);

				}

				else

				{

						Session::flash('message', 'Please login first!');

							return Redirect::to('login/unitadmin');

				}
		}

		public function store()
		{
			$perspective = Input::get('PerspectiveName');
			$unitoffice = Input::get('unitoffice_id');

			DB::table('perspectives')->insert(
    			array('PerspectiveName' => $perspective)
			);

    		$latestperspective_id = DB::table('perspectives')
    		->max('id');

			DB::table('perspective_unitoffices')->insert(
    			array('PerspectiveID' => $latestperspective_id, 'UnitOfficeID' => $unitoffice)
			);

			Session::flash('message', 'Perspective added successfully!');
			return Redirect::to('admin/perspectives');
		}



		public function show($id)
		{
			$perspective = DB::table('perspectives')
						->where('id','=',$id)
						->get();

			return View::make('UnitAdminShowPerspective')
			->with('perspective',$perspective);
		}

		public function edit($id)
		{
			$perspective = $this->perspective->find($id);


		return View::make('UnitAdminEditPerspective')

			->with('perspective',$perspective);

		}

		public function update($id)
		{
			$perspectivename = Input::get('PerspectiveName');

			DB::table('perspectives')

						->where('id','=',$id)

						->update(array('PerspectiveName' => $perspectivename));

			return Redirect::to('unitadminperspectives/' . $id);

		}


}
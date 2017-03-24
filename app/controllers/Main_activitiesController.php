<?php

class Main_activitiesController extends BaseController {

	/**
	 * Main_activity Repository
	 *
	 * @var Main_activity
	 */
	protected $main_activity;

	public function __construct(Main_activity $main_activity)
	{
		$this->main_activity = $main_activity;
	} 

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$main_activities = DB::table('main_activities')->get();
		$objectives = DB::table('objectives')->get();
		$objectives_id=DB::table('objectives')
		->lists('ObjectiveName','id');

		return View::make('main_activities.index', compact('main_activities'))
		->with('main_activities', $main_activities)
		->with('objectives_id',$objectives_id)
		->with('objectives',$objectives);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('main_activities.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Main_activity::$rules);

		if ($validation->passes())
		{
			$this->main_activity->create($input);

			return Redirect::route('main_activities.index');
		}

		return Redirect::route('main_activities.create')
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
		$main_activity = $this->main_activity->findOrFail($id);
		$objectives = DB::table('objectives')->get();

		return View::make('main_activities.show', compact('main_activity'))
		->with('objectives',$objectives);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$main_activity = $this->main_activity->find($id);


		$objectives_id=DB::table('objectives')
		->lists('ObjectiveName','id');

		if (is_null($main_activity))
		{
			return Redirect::route('main_activities.index');
		}

		return View::make('main_activities.edit', compact('main_activity'))
		->with('objectives_id',$objectives_id);
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
		$validation = Validator::make($input, Main_activity::$rules);

		if ($validation->passes())
		{
			$main_activity = $this->main_activity->find($id);
			$main_activity->update($input);

			return Redirect::route('main_activities.show', $id);
		}

		return Redirect::route('main_activities.edit', $id)
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
		$this->main_activity->find($id)->delete();

		return Redirect::route('main_activities.index');
	}

}

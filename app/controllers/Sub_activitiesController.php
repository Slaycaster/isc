<?php

class Sub_activitiesController extends BaseController {

	/**
	 * Sub_activity Repository
	 *
	 * @var Sub_activity
	 */
	protected $sub_activity;

	public function __construct(Sub_activity $sub_activity)
	{
		$this->sub_activity = $sub_activity;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sub_activities = $this->sub_activity->all();
		$main_activities=DB::table('main_activities')->get();
		$main_activities_id=DB::table('main_activities')
		->lists('MainActivityName','id');

		return View::make('sub_activities.index', compact('sub_activities'))
		->with('main_activities',$main_activities)
		->with('main_activities_id',$main_activities_id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sub_activities.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Sub_activity::$rules);

		if ($validation->passes())
		{
			$this->sub_activity->create($input);

			return Redirect::route('sub_activities.index');
		}

		return Redirect::route('sub_activities.create')
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
		$sub_activity = $this->sub_activity->findOrFail($id);
		$main_activities=DB::table('main_activities')->get();
		$main_activities_id=DB::table('main_activities')
		->lists('MainActivityName','id');

		return View::make('sub_activities.show', compact('sub_activity'))
		->with('main_activities',$main_activities)
		->with('main_activities_id',$main_activities_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sub_activity = $this->sub_activity->find($id);
		$main_activities_id=DB::table('main_activities')
		->lists('MainActivityName','id');

		if (is_null($sub_activity))
		{
			return Redirect::route('sub_activities.index');
		}

		return View::make('sub_activities.edit', compact('sub_activity'))
		->with('main_activities_id',$main_activities_id);
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
		$validation = Validator::make($input, Sub_activity::$rules);

		if ($validation->passes())
		{
			$sub_activity = $this->sub_activity->find($id);
			$sub_activity->update($input);

			return Redirect::route('sub_activities.show', $id);
		}

		return Redirect::route('sub_activities.edit', $id)
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
		$this->sub_activity->find($id)->delete();

		return Redirect::route('sub_activities.index');
	}

}

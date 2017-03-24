<?php

class Measure_targetsController extends BaseController {

	/**
	 * Measure_target Repository
	 *
	 * @var Measure_target
	 */
	protected $measure_target;

	public function __construct(Measure_target $measure_target)
	{
		$this->measure_target = $measure_target;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$measure_targets = DB::table('measure_targets')->get();
		$measure_target_units=DB::table('measure_target_units')->get();
		$measure_target_units_id = Measure_target_unit::select(DB::raw('concat (MeasureTargetUnitName, "(", MeasureTargetUnitSymbol,")") as targetunit, id'))
			->lists('targetunit', 'id');
		 
		$measures = DB::table('measures')->get();
		return View::make('measure_targets.index', compact('measure_targets'))
		->with('measure_target_units',$measure_target_units)
		->with('measure_target_units_id',$measure_target_units_id)
		->with('measures',$measures);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('measure_targets.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Measure_target::$rules);

		if ($validation->passes())
		{
			//$this->measure_target->create($input);
			$id = DB::table('measure_targets')->max('id');
			$measure_target_unit_id = Input::get('measure_target_units_id');
			$measures = DB::table('measures')->get();
			$measure_target_value = Input::get('MeasureTargetValue');
			foreach($measures as $measure)
			{
				if (Input::has($measure->id))
				{
					$measures_id = Input::get($measure->id);

					$id= $id +1;
					DB::table('measure_targets')->insert(array(array('id'=>$id, 'MeasureTargetValue' => $measure_target_value,'MeasureTargetUnitID'=>$measure_target_unit_id, 'MeasureID'=>$measures_id)));
				}

			}
			return Redirect::route('measure_targets.index');
		}

		return Redirect::route('measure_targets.create')
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
		$measure_target = $this->measure_target->findOrFail($id);
		$measures = DB::table('measures')->get();
		$measure_target_units=DB::table('measure_target_units')->get();
		$measure_target_units_id = Measure_target_unit::select(DB::raw('concat (MeasureTargetUnitName, "(", MeasureTargetUnitSymbol,")") as targetunit, id'))
			->lists('targetunit', 'id');
		

		return View::make('measure_targets.show', compact('measure_target'))
		->with('measure_target_units',$measure_target_units)
		->with('measure_target_units_id',$measure_target_units_id)
		->with('measures',$measures);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$measure_target = $this->measure_target->find($id);
		$measure_target_units=DB::table('measure_target_units')->get();
		$measure_target_units_id = Measure_target_unit::select(DB::raw('concat (MeasureTargetUnitName, "(", MeasureTargetUnitSymbol,")") as targetunit, id'))
			->lists('targetunit', 'id');
		
		$measures = DB::table('measures')->get();

		if (is_null($measure_target))
		{
			return Redirect::route('measure_targets.index');
		}

		return View::make('measure_targets.edit', compact('measure_target'))
		->with('measure_target_units',$measure_target_units)
		->with('measure_target_units_id',$measure_target_units_id)
		->with('measures',$measures);
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
		$validation = Validator::make($input, Measure_target::$rules);

		if ($validation->passes())
		{
			$measure_target = $this->measure_target->find($id);
			$measure_target->update($input);

			return Redirect::route('measure_targets.show', $id);
		}

		return Redirect::route('measure_targets.edit', $id)
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
		$this->measure_target->find($id)->delete();

		return Redirect::route('measure_targets.index');
	}

}

<?php

class Measure_target_unitsController extends BaseController {

	/**
	 * Measure_target_unit Repository
	 *
	 * @var Measure_target_unit
	 */
	protected $measure_target_unit;

	public function __construct(Measure_target_unit $measure_target_unit)
	{
		$this->measure_target_unit = $measure_target_unit;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$measure_target_units = Measure_target_unit::paginate(9);

		return View::make('measure_target_units.index', compact('measure_target_units'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('measure_target_units.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Measure_target_unit::$rules);

		if ($validation->passes())
		{
			$this->measure_target_unit->create($input);

			return Redirect::route('measure_target_units.index');
		}

		return Redirect::route('measure_target_units.create')
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
		$measure_target_unit = $this->measure_target_unit->findOrFail($id);

		return View::make('measure_target_units.show', compact('measure_target_unit'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$measure_target_unit = $this->measure_target_unit->find($id);

		if (is_null($measure_target_unit))
		{
			return Redirect::route('measure_target_units.index');
		}

		return View::make('measure_target_units.edit', compact('measure_target_unit'));
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
		$validation = Validator::make($input, Measure_target_unit::$rules);

		if ($validation->passes())
		{
			$measure_target_unit = $this->measure_target_unit->find($id);
			$measure_target_unit->update($input);

			return Redirect::route('measure_target_units.show', $id);
		}

		return Redirect::route('measure_target_units.edit', $id)
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
		$this->measure_target_unit->find($id)->delete();

		return Redirect::route('measure_target_units.index');
	}

}

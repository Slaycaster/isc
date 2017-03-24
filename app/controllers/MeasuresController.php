<?php

class MeasuresController extends BaseController {

	/**
	 * Measure Repository
	 *
	 * @var Measure
	 */
	protected $Measure;

	public function __construct(Measure $Measure)
	{
		$this->Measure = $Measure;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Measures = DB::table('measures')->get();

		return View::make('Measures.index', compact('Measures'));
	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('Measures.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Measure::$rules);

		if ($validation->passes())
		{
			$this->Measure->create($input);

			return Redirect::route('measures.index');
		}

		return Redirect::route('Measures.create')
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
		$Measure = $this->Measure->findOrFail($id);

		return View::make('Measures.show', compact('Measure'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$Measure = $this->Measure->find($id);

		if (is_null($Measure))
		{
			return Redirect::route('Measures.index');
		}

		return View::make('Measures.edit', compact('Measure'));
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
		$validation = Validator::make($input, Measure::$rules);

		if ($validation->passes())
		{
			$Measure = $this->Measure->find($id);
			$Measure->update($input);

			return Redirect::route('Measures.show', $id);
		}

		return Redirect::route('Measures.edit', $id)
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
		$this->Measure->find($id)->delete();

		return Redirect::route('Measures.index');
	}

}

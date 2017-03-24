<?php

class PerspectivesController extends BaseController {

	/**
	 * Perspective Repository
	 *
	 * @var Perspective
	 */
	protected $perspective;

	public function __construct(Perspective $perspective)
	{
		$this->perspective = $perspective;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$perspectives = DB::table('perspectives')->get();

		return View::make('perspectives.index', compact('perspectives'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('perspectives.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Perspective::$rules);

		if ($validation->passes())
		{
			$this->perspective->create($input);

			return Redirect::route('perspectives.index');
		}

		return Redirect::route('perspectives.index')
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
		$perspective = $this->perspective->findOrFail($id);

		return View::make('perspectives.show', compact('perspective'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perspective = $this->perspective->find($id);

		if (is_null($perspective))
		{
			return Redirect::route('perspectives.index');
		}

		return View::make('perspectives.edit', compact('perspective'));
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
		$validation = Validator::make($input, Perspective::$rules);

		if ($validation->passes())
		{
			$perspective = $this->perspective->find($id);
			$perspective->update($input);

			return Redirect::route('perspectives.show', $id);
		}

		return Redirect::route('perspectives.edit', $id)
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
		$this->perspective->find($id)->delete();

		return Redirect::route('perspectives.index');
	}

}

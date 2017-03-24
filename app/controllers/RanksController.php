<?php

class RanksController extends BaseController {

	/**
	 * Rank Repository
	 *
	 * @var Rank
	 */
	protected $rank;

	public function __construct(Rank $rank)
	{
		$this->rank = $rank;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ranks = DB::table('ranks')->get();

		return View::make('ranks.index', compact('ranks'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Rank::$rules);

		if ($validation->passes())
		{
			$this->rank->create($input);

			return Redirect::route('ranks.index');
		}

		return Redirect::route('ranks.index')
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
		$rank = $this->rank->findOrFail($id);

		return View::make('ranks.show', compact('rank'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rank = $this->rank->find($id);

		if (is_null($rank))
		{
			return Redirect::route('ranks.index');
		}

		return View::make('ranks.edit', compact('rank'));
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
		$validation = Validator::make($input, Rank::$rules);

		if ($validation->passes())
		{
			$rank = $this->rank->find($id);
			$rank->update($input);

			return Redirect::route('ranks.show', $id);
		}

		return Redirect::route('ranks.edit', $id)
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
		$this->rank->find($id)->delete();

		return Redirect::route('ranks.index');
	}

}

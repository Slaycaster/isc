<?php

class ObjectivesController extends BaseController {

	/**
	 * Objective Repository
	 *
	 * @var Objective
	 */
	protected $objective;

	public function __construct(Objective $objective)
	{
		$this->objective = $objective;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$objectives = DB::table('objectives')->get();
		$perspectives=DB::table('perspectives')->get();
		$perspectives_id=DB::table('perspectives')
		->lists('PerspectiveName','id');

		return View::make('objectives.index', compact('objectives'))
		->with('perspectives', $perspectives)
		->with('perspectives_id',$perspectives_id);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('objectives.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Objective::$rules);

		if ($validation->passes())
		{
			$this->objective->create($input);

			return Redirect::route('objectives.index');
		}

		return Redirect::route('objectives.index')
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
		$objective = $this->objective->findOrFail($id);
		$perspectives=DB::table('perspectives')->get();
		$perspectives_id=DB::table('perspectives')
		->lists('PerspectiveName','id');

		return View::make('objectives.show', compact('objective'))
		->with('perspectives',$perspectives);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$objective = $this->objective->find($id);
		$perspectives_id=DB::table('perspectives')
		->lists('PerspectiveName','id');

		if (is_null($objective))
		{
			return Redirect::route('objectives.index');
		}

		return View::make('objectives.edit', compact('objective'))
		->with('perspectives_id',$perspectives_id);
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
		$validation = Validator::make($input, Objective::$rules);

		if ($validation->passes())
		{
			$objective = $this->objective->find($id);
			$objective->update($input);

			return Redirect::route('objectives.show', $id);
		}

		return Redirect::route('objectives.edit', $id)
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
		$this->objective->find($id)->delete();

		return Redirect::route('objectives.index');
	}

	public function anyObjective()
	    {
	        
	        $objectives = DB::table('objectives')
				->join('perspectives', 'objectives.PerspectiveID', '=', 'perspectives.id' )
				->select('objectives.id', 'objectives.ObjectiveName as ObjectiveName', 'perspectives.PerspectiveName as PerspectiveName');
			

	        return Datatables::of($objectives)
	        
	        ->add_column('Actions', '

	        	<a class = \'btn btn-warning\' href="{{ URL::to(\'objectives/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'objectives/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>

	        	<br><br>

                <a class = \'btn btn-info\'  href="{{ URL::to(\'objectives/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'objectives/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
	        ->remove_column('$objectives.id')
	        ->make(true);
	    }

}

<?php



use App\Http\Requests;
use App\User;
use Bllim\Datatables\Facade\Datatables;

class DataAdminController extends BaseController {

	

	public function anyObj()
    {
        
        $objectives = DB::table('objectives')
			->select('objectives.id', 'objectives.ObjectiveName as ObjectiveName');
			
        return Datatables::of($objectives)
        ->add_column('Actions', '{{ Form::checkbox(\'objectivecheckboxid[]\',$id) }}')
        ->remove_column('id')
        ->make(true);
    }

    public function anyObjajax($id)
    {
    	  $objectives = DB::table('objectives')
    	  	->where('PerspectiveID','=',$id)
			->select('id', 'ObjectiveName');

		return Datatables::of($objectives)
        ->add_column('Actions', '{{ Form::checkbox(\'objectivecheckboxid[]\',$id) }}')
        ->remove_column('id')
        ->make(true);
    }

    public function anyUnitPri()
        {
            
            $unit_offices = DB::table('unit_offices')
                ->select('unit_offices.id', 'unit_offices.UnitOfficeName as UnitOfficeName', 'unit_offices.UnitOfficeHasField as UnitOfficeHasField')
                ;
                

            return Datatables::of($unit_offices)
            
            ->add_column('Actions', '<a class = \'btn btn-warning\' href="{{ URL::to(\'unit_offices/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_offices/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>

                <br><br>
                                <a class = \'btn btn-info\'  href="{{ URL::to(\'unit_offices/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'unit_offices/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>

                            ')
            ->remove_column('$unit_offices.id')
            ->make(true);
        }


    
}



?>
<?php

class AjaxController extends BaseController {

	/*public function dropdown1()
		{
			$officeID = $_POST['officeID'];


			$secondaryoffices = DB::table('unit_office_secondaries')->where('UnitOfficeID', '=', $value);

			$outp = "[";
			while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
			    if ($outp != "[") {$outp .= ",";}
			    $outp .= '{"id":"'  . $rs["id"] . '",';
			    $outp .= '"UnitOfficeSecondaryName":"'   . $rs["UnitOfficeSecondaryName"]        . '",';
			}
			$outp .="]";

			foreach($secondaryoffices as $secondaryoffice)
			{
				if($outp!= "[")
				{
					$outp .= ",";
				}
				$outp .= '{"id":"'  . $secondaryoffice->id . '",';
				$outp .= '"UnitOfficeSecondaryName":"'   . $secondaryoffice->UnitO      . '",';

			}

			$conn->close();

			return View::make('employs')
				->with('outp', $outp);
		}*/

		public function dropdown1(Request $request) {
        if(Response::ajax()) return "OK";
    }
}
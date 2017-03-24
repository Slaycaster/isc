<?php

class PrintController extends BaseController 

{

    public function showAdminReports()
    {
        $start_date = Input::get('StartDate');

        $StartDate = date("Y/m/d", strtotime($start_date));
        $DateValidate = 'HaveValue';

        if($start_date == null)
        {
            $DateValidate = '';
        }

        $emp_id = Input::get('emp_id');
        if($emp_id == null)
        {
            return Redirect::to('dashboard');
        }
        else
        {
            if(Input::get('weekly')) 
            {
                Session::put('DateValidate', $DateValidate);
                Session::put('emp_id', $emp_id);
                Session::put('StartDate', $StartDate);
                $pdf = PDF::loadView('PDFWeeklyAdmin')->setPaper('Letter')->setOrientation('Portrait');
                return $pdf->stream();
            }
            elseif(Input::get('monthly'))
            {
                Session::put('DateValidate', $DateValidate);
                Session::put('emp_id', $emp_id);
                Session::put('StartDate', $StartDate);
                $pdf = PDF::loadView('PDFMonthly')->setPaper('Folio')->setOrientation('Landscape');
                //return $pdf->stream();
                return View::make('PDFMonthly');
            }
        }
    }

    public function showSupervisorReports()
    {
        $start_date = Input::get('StartDate');

        $StartDate = date("Y/m/d", strtotime($start_date));
        $DateValidate = 'HaveValue';

        if($start_date == null)
        {
            $DateValidate = '';
        }

        $emp_id = Input::get('emp_id');
        if($emp_id == null)
        {
            return Redirect::to('dashboard');
        }
        else
        {
            if(Input::get('weekly')) 
            {
                Session::put('DateValidate', $DateValidate);
                Session::put('emp_id', $emp_id);
                Session::put('StartDate', $StartDate);
                $pdf = PDF::loadView('PDFWeeklySupervisor')->setPaper('Letter')->setOrientation('Portrait');
                return $pdf->stream();
            }
            elseif(Input::get('monthly'))
            {
                Session::put('DateValidate', $DateValidate);
                Session::put('emp_id', $emp_id);
                Session::put('StartDate', $StartDate);
                $pdf = PDF::loadView('PDFMonthly')->setPaper('Folio')->setOrientation('Landscape');
                //return $pdf->stream();
                return View::make('PDFMonthly');
            }
        }
    }

    public function showCurrentWeekReport($id)
    {#SubmittedScorecardForThisWeek/{id}
        date_default_timezone_set("Asia/Hong_Kong");

        $CurrentDate = date('Y-m-d');
        $CurrentDateFormat = "";
        if(date("w",strtotime($CurrentDate)) == 0)
        {
            $CurrentDateFormat = 6;
        }
        else
        {
            $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
        }
        $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
        $DateValidate = 'HaveValue';
        if($CurrentDate == null)
        {
            $DateValidate = '';
        }
        {   
            Session::put('DateValidate', $DateValidate);
            Session::put('emp_id', $id);
            Session::put('StartDate', $CurrentWeekMonDate);
            $pdf = PDF::loadView('PDFWeeklyAdmin')->setPaper('Letter')->setOrientation('Portrait');
            return $pdf->stream();
        }
    }

    public function showLastWeekReport($id)
    {#SubmittedScorecardForLastWeek/{id}
        date_default_timezone_set("Asia/Hong_Kong");

        $CurrentDate = date('Y-m-d');
        $CurrentDateFormat = "";
        if(date("w",strtotime($CurrentDate)) == 0)
        {
            $CurrentDateFormat = 6;
        }
        else
        {
            $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
        }
        $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
        $LastWeekMonDate = date("Y/m/d", strtotime($CurrentWeekMonDate.'-'. '7'. 'days'));
        $DateValidate = 'HaveValue';
        if($CurrentDate == null)
        {
            $DateValidate = '';
        }
        {   
            Session::put('DateValidate', $DateValidate);
            Session::put('emp_id', $id);
            Session::put('StartDate', $LastWeekMonDate);
            $pdf = PDF::loadView('PDFWeeklyAdmin')->setPaper('Letter')->setOrientation('Portrait');
            return $pdf->stream();
        }
    }


    #Submmission Reports
    public function showAdminSubmittedScorecards()
    {#SubmittedScorecardAdmin
        date_default_timezone_set("Asia/Hong_Kong");

        $StartDate = Input::get('MondayDate');

        $reportTypeSelected = Input::get('ReportType');
        $unitOfficeSelected = Input::get('UnitOfficeID');
        $mondayDateSelected = date("Y/m/d", strtotime($StartDate));//dd($mondayDateSelected);
        if($reportTypeSelected == '1' || $reportTypeSelected == '3')
        {
            if($mondayDateSelected != "1970/01/01")
            {
                if(Input::get('weekly')) 
                {
                    if($reportTypeSelected == '1')
                    {
                        Session::put('unitOfficeSelected', $unitOfficeSelected);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFSubmittedScorecard');
                    }
                    elseif($reportTypeSelected == '3')
                    {
                        Session::put('unitOfficeSelected', $unitOfficeSelected);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFNotSubmittedScorecard');
                    }
                }
                elseif(Input::get('monthly')) 
                {
                    if($reportTypeSelected == '1')
                    {
                        Session::put('unitOfficeSelected', $unitOfficeSelected);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFMonthlySubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFMonthlySubmittedScorecard');
                    }
                    elseif($reportTypeSelected == '3')
                    {
                        Session::put('unitOfficeSelected', $unitOfficeSelected);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFMonthlyNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFMonthlyNotSubmittedScorecard');
                    }
                }
            }
            elseif($mondayDateSelected == "1970/01/01")
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('dashboard');
            }
        }
        elseif ($reportTypeSelected == '2') 
        {
            if($reportTypeSelected != "0") 
            {
                $CurrentDate = date('Y-m-d');
                $CurrentDateFormat = "";
                if(date("w",strtotime($CurrentDate)) == 0)
                {
                    $CurrentDateFormat = 6;
                }
                else
                {
                    $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
                }
                $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
                Session::put('unitOfficeSelected', $unitOfficeSelected);
                Session::put('mondayDateSelected', $CurrentWeekMonDate);
                $pdf = PDF::loadView('PDFPendingScorecard')->setPaper('Letter')->setOrientation('Portrait');
                //return $pdf->stream();
                 return View::make('PDFPendingScorecard');
            }
            else
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('dashboard');
            }
        }
        else
        {
            Session::flash('message', 'Incomplete Inputs!');
            return Redirect::to('dashboard');
        }
    }

    public function showUnitAdminSubmittedScorecards()
    {#SubmittedScorecardUnitAdmin
        date_default_timezone_set("Asia/Hong_Kong");

        $StartDate = Input::get('MondayDate');

        $reportTypeSelected = Input::get('ReportType');
        $unitOfficeSelected = Session::get('primaryunit','default');
        $unitOfficeSecondaryID = Session::get('secondaryunit','default');
        $mondayDateSelected = date("Y/m/d", strtotime($StartDate));
        
        if($unitOfficeSecondaryID == 0)//main
        {
            if($reportTypeSelected == '1' || $reportTypeSelected == '3')
            {
                if($mondayDateSelected != "")
                {
                    if(Input::get('weekly')) 
                    {
                        if($reportTypeSelected == '1')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFSubmittedScorecard');
                        }
                        elseif($reportTypeSelected == '3')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFNotSubmittedScorecard');
                        }
                    }
                    elseif(Input::get('monthly')) 
                    {
                        if($reportTypeSelected == '1')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFMonthlySubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFMonthlySubmittedScorecard');
                        }
                        elseif($reportTypeSelected == '3')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFMonthlyNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFMonthlyNotSubmittedScorecard');
                        }
                    }
                }
                elseif($mondayDateSelected == "")
                {
                    Session::flash('message', 'Incomplete Inputs!');
                    return Redirect::to('Unitadmindashboard');
                }
            }
            elseif ($reportTypeSelected == '2') 
            {
                if($reportTypeSelected != "0") 
                {
                    $CurrentDate = date('Y-m-d');
                    $CurrentDateFormat = "";
                    if(date("w",strtotime($CurrentDate)) == 0)
                    {
                        $CurrentDateFormat = 6;
                    }
                    else
                    {
                        $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
                    }
                    $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
                    Session::put('unitOfficeSelected', $unitOfficeSelected);
                    Session::put('mondayDateSelected', $CurrentWeekMonDate);
                    $pdf = PDF::loadView('PDFPendingScorecard')->setPaper('Letter')->setOrientation('Portrait');
                    //return $pdf->stream();
                    return View::make('PDFPendingScorecard');
                }
                else
                {
                    Session::flash('message', 'Incomplete Inputs!');
                    return Redirect::to('Unitadmindashboard');
                }
            }
            else
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('Unitadmindashboard');
            }
        }
        else//main
        {
            if($reportTypeSelected == '1' || $reportTypeSelected == '3')
            {
                if($mondayDateSelected != "")
                {
                    if(Input::get('weekly')) 
                    {
                        if($reportTypeSelected == '1')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('UnitOfficeSecondaryID', $unitOfficeSecondaryID);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFSecondaryUnitSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFSecondaryUnitSubmittedScorecard');
                        }
                        elseif($reportTypeSelected == '3')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('UnitOfficeSecondaryID', $unitOfficeSecondaryID);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFSecondaryUnitNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFSecondaryUnitNotSubmittedScorecard');
                        }
                    }
                    elseif(Input::get('monthly')) 
                    {
                        if($reportTypeSelected == '1')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('UnitOfficeSecondaryID', $unitOfficeSecondaryID);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFMonthlySecondaryUnitSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFMonthlySecondaryUnitSubmittedScorecard');
                        }
                        elseif($reportTypeSelected == '3')
                        {
                            Session::put('unitOfficeSelected', $unitOfficeSelected);
                            Session::put('UnitOfficeSecondaryID', $unitOfficeSecondaryID);
                            Session::put('mondayDateSelected', $mondayDateSelected);
                            $pdf = PDF::loadView('PDFMonthlySecondaryUnitNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                            //return $pdf->stream();
                            return View::make('PDFMonthlySecondaryUnitNotSubmittedScorecard');
                        }
                    }
                }
                elseif($mondayDateSelected == "")
                {
                    Session::flash('message', 'Incomplete Inputs!');
                    return Redirect::to('Unitadmindashboard');
                }
            }
            elseif ($reportTypeSelected == '2') 
            {
                if($reportTypeSelected != "0") 
                {
                    $CurrentDate = date('Y-m-d');
                    $CurrentDateFormat = "";
                    if(date("w",strtotime($CurrentDate)) == 0)
                    {
                        $CurrentDateFormat = 6;
                    }
                    else
                    {
                        $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
                    }
                    $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
                    Session::put('unitOfficeSelected', $unitOfficeSelected);
                    Session::put('UnitOfficeSecondaryID', $unitOfficeSecondaryID);
                    Session::put('mondayDateSelected', $CurrentWeekMonDate);
                    $pdf = PDF::loadView('PDFSecondaryUnitPendingScorecard')->setPaper('Letter')->setOrientation('Portrait');
                    //return $pdf->stream();
                    return View::make('PDFSecondaryUnitPendingScorecard');
                }
                elseif($unitOfficeSelected != "0")
                {
                    Session::flash('message', 'Incomplete Inputs!');
                    return Redirect::to('Unitadmindashboard');
                }
                else
                {
                    Session::flash('message', 'Incomplete Inputs!');
                    return Redirect::to('Unitadmindashboard');
                }
            }
            else
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('Unitadmindashboard');
            }
        }
    }

    public function showSupervisorSubmittedScorecards()
    {#employee/SubmittedScorecardSupervisor
        date_default_timezone_set("Asia/Hong_Kong");

        $supervisorID = Session::get('empid', 'default');
        $StartDate = Input::get('MondayDate');
        $reportTypeSelected = Input::get('ReportType');
        $mondayDateSelected = date("Y/m/d", strtotime($StartDate));

        if($reportTypeSelected == '1' || $reportTypeSelected == '3')
        {
            if($mondayDateSelected != "")
            {
                if(Input::get('weekly')) 
                {
                    if($reportTypeSelected == '1')
                    {
                        Session::put('supervisorID', $supervisorID);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFSupervisorSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFSupervisorSubmittedScorecard');
                    }
                    elseif($reportTypeSelected == '3')
                    {
                        Session::put('supervisorID', $supervisorID);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFSupervisorNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFSupervisorNotSubmittedScorecard');
                    }
                }
                elseif(Input::get('monthly')) 
                {
                    if($reportTypeSelected == '1')
                    {
                        Session::put('supervisorID', $supervisorID);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFMonthlySupervisorSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFMonthlySupervisorSubmittedScorecard');
                    }
                    elseif($reportTypeSelected == '3')
                    {
                        Session::put('supervisorID', $supervisorID);
                        Session::put('mondayDateSelected', $mondayDateSelected);
                        $pdf = PDF::loadView('PDFMonthlySupervisorNotSubmittedScorecard')->setPaper('Letter')->setOrientation('Portrait');
                        //return $pdf->stream();
                        return View::make('PDFMonthlySupervisorNotSubmittedScorecard');
                    }
                }
            }
            elseif($mondayDateSelected == "")
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('employeedashboard');
            }
        }
        elseif ($reportTypeSelected == '2') 
        {
            if($reportTypeSelected != "0") 
            {
                $CurrentDate = date('Y-m-d');
                $CurrentDateFormat = "";
                if(date("w",strtotime($CurrentDate)) == 0)
                {
                    $CurrentDateFormat = 6;
                }
                else
                {
                    $CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
                }
                $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
                Session::put('supervisorID', $supervisorID);
                Session::put('mondayDateSelected', $CurrentWeekMonDate);
                $pdf = PDF::loadView('PDFSupervisorPendingScorecard')->setPaper('Letter')->setOrientation('Portrait');
                //return $pdf->stream();
                return View::make('PDFSupervisorPendingScorecard');
            }
            else
            {
                Session::flash('message', 'Incomplete Inputs!');
                return Redirect::to('employeedashboard');
            }
        }
        else
        {
            Session::flash('message', 'Incomplete Inputs!');
            return Redirect::to('employeedashboard');
        }
    }

#KPI REPORTS
    public function showKPIReport()
    {#KPIReport
        $start_date = Input::get('StartDate');
        $StartDate = date("Y/m/d", strtotime($start_date));

        $emp_id = Input::get('empid');
        Session::put('emp_id', $emp_id);
        Session::put('StartDate', $StartDate);
        $pdf = PDF::loadView('PDFKPIAccumulationSummation')->setPaper('Letter')->setOrientation('Portrait');
        return $pdf->stream();
    }

#PERSONNEL REPORTS
    public function showPersonnelReport()
    {#AdminPersonnelReport

        $Filter = Input::get('Filter');
        $FilteredBy = Input::get('FilteredBy');
        $employees = array();

        if($Filter == 1)
        {#Position
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.PositionID', '=', $FilteredBy)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }
        if($Filter == 2)
        {#Secondary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->where('ranks.id', '=', $FilteredBy)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->get();
        }

        return View::make('PDFPersonnelReport')
                    ->with('Filter', $Filter)
                    ->with('FilteredBy', $FilteredBy)
                    ->with('employees', $employees);

    }

    public function showPersonnelReportbyOffice()
    {#AdminPersonnelReportbyOffice

        $primaryunit = Input::get('UnitOfficeID');
        $secondaryunit = Input::get('UnitOfficeSecondaryID');
        $tertiaryunit = Input::get('UnitOfficeTertiaryID');
        $quaternaryunit = Input::get('UnitOfficeQuaternaryID');
        //dd($primaryunit);
        $employees = array();

        if(($primaryunit > 0) 
            &&  (($secondaryunit == 0 || $secondaryunit == null) 
                    &&  ($tertiaryunit == 0 || $tertiaryunit == null) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#UnitOffice
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }

        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit == 0 || $tertiaryunit == null) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#Secondary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }
        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit > 0) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#Tertiary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->where('employs.UnitOfficeTertiaryID', '=', $tertiaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }
        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit > 0) 
                    &&  ($quaternaryunit > 0))
          )
        {#Quaternary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->where('employs.UnitOfficeTertiaryID', '=', $tertiaryunit)
                    ->where('employs.UnitOfficeQuaternaryID', '=', $quaternaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }


        $UnitOfficesName = '';

        $unit_offices = DB::table('unit_offices')->where('id', '=', $primaryunit)->first();
        $unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryunit)->first();
        $unit_office_tertiaries = DB::table('unit_office_tertiaries')->where('id', '=', $tertiaryunit)->first();
        $unit_office_quaternaries = DB::table('unit_office_quaternaries')->where('id', '=', $quaternaryunit)->first();
                    
        if($unit_offices != null && $unit_office_secondaries != null && $unit_office_tertiaries != null && $unit_office_quaternaries != null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName.', '.$unit_office_quaternaries->UnitOfficeQuaternaryName;
        }
        elseif($unit_offices != null && ($unit_office_secondaries != null && $unit_office_tertiaries != null) && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName;
        }
        elseif($unit_offices != null && $unit_office_secondaries != null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName;
        }
        elseif($unit_offices != null && $unit_office_secondaries == null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName;
        }
        else
        {
            $UnitOfficesName = "Please Select on the Drop down List";
        }


        return View::make('PDFPersonnelReport')
                    ->with('Filter', 3)
                    ->with('FilteredBy', $UnitOfficesName)
                    ->with('employees', $employees);

    }

    public function showUnitAdminPersonnelReport()
    {#UnitAdminPersonnelReport

        $Filter = Input::get('Filter');
        $FilteredBy = Input::get('FilteredBy');

        $unitOfficeSelected = Session::get('primaryunit','default');
        $unitOfficeSecondaryID = Session::get('secondaryunit','default');

        $employees = array();

        if($Filter == 1)
        {#Position
            if($unitOfficeSecondaryID == 0)
            {
                $employees = DB::table('employs')
                        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                        ->where('employs.PositionID', '=', $FilteredBy)
                        ->where('employs.UnitOfficeID', '=', $unitOfficeSelected)
                        ->orderBy('ranks.Hierarchy', 'asc')
                        ->get();
            }
            else
            {
                $employees = DB::table('employs')
                        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                        ->where('employs.PositionID', '=', $FilteredBy)
                        ->where('employs.UnitOfficeID', '=', $unitOfficeSelected)
                        ->where('employs.UnitOfficeSecondaryID', '=', $unitOfficeSecondaryID)
                        ->orderBy('ranks.Hierarchy', 'asc')
                        ->get();
            }
        }
        if($Filter == 2)
        {#Secondary Unit Office
            if($unitOfficeSecondaryID == 0)
            {
                $employees = DB::table('employs')
                                ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                                ->where('ranks.id', '=', $FilteredBy)
                                ->where('employs.UnitOfficeID', '=', $unitOfficeSelected)
                                ->orderBy('ranks.Hierarchy', 'asc')
                                ->get();
            }
            else
            {
                $employees = DB::table('employs')
                                ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                                ->where('ranks.id', '=', $FilteredBy)
                                ->where('employs.UnitOfficeID', '=', $unitOfficeSelected)
                                ->where('employs.UnitOfficeSecondaryID', '=', $unitOfficeSecondaryID)
                                ->orderBy('ranks.Hierarchy', 'asc')
                                ->get();

            }
        }

        return View::make('PDFPersonnelReport')
                    ->with('Filter', $Filter)
                    ->with('FilteredBy', $FilteredBy)
                    ->with('employees', $employees);

    }

    public function showUnitAdminPersonnelReportbyOffice()
    {#
        $unitOfficeSelected = Session::get('primaryunit','default');
        $unitOfficeSecondaryID = Session::get('secondaryunit','default');

        $primaryunit = Session::get('primaryunit','default');
        if($unitOfficeSecondaryID == 0)
        {
            $secondaryunit = Input::get('UnitOfficeSecondaryID');
        }
        else
        {
            $secondaryunit = Session::get('secondaryunit','default');
        }
        $tertiaryunit = Input::get('UnitOfficeTertiaryID');
        $quaternaryunit = Input::get('UnitOfficeQuaternaryID');
        //dd($primaryunit);
        $employees = array();

        if(($primaryunit > 0) 
            &&  (($secondaryunit == 0 || $secondaryunit == null) 
                    &&  ($tertiaryunit == 0 || $tertiaryunit == null) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#UnitOffice
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }

        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit == 0 || $tertiaryunit == null) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#Secondary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }
        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit > 0) 
                    &&  ($quaternaryunit == 0 || $quaternaryunit == null))
          )
        {#Tertiary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->where('employs.UnitOfficeTertiaryID', '=', $tertiaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }
        if(($primaryunit > 0) 
            &&  (($secondaryunit > 0) 
                    &&  ($tertiaryunit > 0) 
                    &&  ($quaternaryunit > 0))
          )
        {#Quaternary Unit Office
            $employees = DB::table('employs')
                    ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                    ->join('positions', 'positions.id', '=', 'employs.PositionID')
                    ->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
                    ->where('employs.UnitOfficeID', '=', $primaryunit)
                    ->where('employs.UnitOfficeSecondaryID', '=', $secondaryunit)
                    ->where('employs.UnitOfficeTertiaryID', '=', $tertiaryunit)
                    ->where('employs.UnitOfficeQuaternaryID', '=', $quaternaryunit)
                    ->orderBy('ranks.Hierarchy', 'asc')
                    ->orderBy('unit_offices.UnitOfficeName', 'asc')
                    ->get();
        }


        $UnitOfficesName = '';

        $unit_offices = DB::table('unit_offices')->where('id', '=', $primaryunit)->first();
        $unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryunit)->first();
        $unit_office_tertiaries = DB::table('unit_office_tertiaries')->where('id', '=', $tertiaryunit)->first();
        $unit_office_quaternaries = DB::table('unit_office_quaternaries')->where('id', '=', $quaternaryunit)->first();
                    
        if($unit_offices != null && $unit_office_secondaries != null && $unit_office_tertiaries != null && $unit_office_quaternaries != null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName.', '.$unit_office_quaternaries->UnitOfficeQuaternaryName;
        }
        elseif($unit_offices != null && ($unit_office_secondaries != null && $unit_office_tertiaries != null) && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName;
        }
        elseif($unit_offices != null && $unit_office_secondaries != null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName;
        }
        elseif($unit_offices != null && $unit_office_secondaries == null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
        {
            $UnitOfficesName = $unit_offices->UnitOfficeName;
        }
        else
        {
            $UnitOfficesName = "Please Select on the Drop down List";
        }


        return View::make('PDFPersonnelReport')
                    ->with('Filter', 3)
                    ->with('FilteredBy', $UnitOfficesName)
                    ->with('employees', $employees);

    }

    
}


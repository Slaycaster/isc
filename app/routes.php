<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::post('postEmpremovescorecard', array('uses' => 'EmployeeLoginController@postRemoveScorecard'));

Route::post('postUAremovescorecard', array('uses' => 'UnitAdminLoginController@postRemoveScorecard'));

Route::get('/', array('uses' => 'HomeController@showHomepage'));
Route::get('/reportsadmin', 'PrintController@showAdminReports');
Route::get('/SubmittedScorecardAdmin', 'PrintController@showAdminSubmittedScorecards');
Route::get('SubmittedScorecardForThisWeek/{id}', 'PrintController@showCurrentWeekReport');
Route::get('SubmittedScorecardForLastWeek/{id}', 'PrintController@showLastWeekReport');
Route::get('KPIReport', 'PrintController@showKPIReport');
Route::get('AdminPersonnelReport', 'PrintController@showPersonnelReport');
Route::get('AdminPersonnelReportbyOffice', 'PrintController@showPersonnelReportbyOffice');
Route::get('UnitAdminPersonnelReport', 'PrintController@showUnitAdminPersonnelReport');
Route::get('UnitAdminPersonnelReportbyOffice', 'PrintController@showUnitAdminPersonnelReportbyOffice');


//ajaxroutes for registration

Route::post('registration/primary', function()
	{
		if(Request::ajax())
		{
			$officeID = $_POST['officeID'];
			$queries = DB::table('unit_office_secondaries')
			->where('UnitOfficeID', '=', $officeID)
			->get();

			return Response::json($queries);
		}
	});

Route::post('registration/secondary', function()
	{
		if(Request::ajax())
		{
			$officeID2 = $_POST['officeID2'];
			$queries = DB::table('unit_office_tertiaries')
			->where('UnitOfficeSecondaryID', '=', $officeID2)
			->get();

			return Response::json($queries);
		}
	});




Route::post('registration/tertiary', function()
	{
		if(Request::ajax())
		{
			$officeID3 = $_POST['officeID3'];
			$queries = DB::table('unit_office_quaternaries')
			->where('UnitOfficeTertiaryID', '=', $officeID3)
			->get();

			return Response::json($queries);
		}
	});

// REGISTRATION PAGE (uncomment to enable functionality)
Route::get('registration/index', array('uses' => 'EmployeeRegistrationController@index'));
Route::post('registration/index', array('uses' => 'EmployeeRegistrationController@postindex'));
Route::post('registration/index2', array('uses' => 'EmployeeRegistrationController@postindex2'));
Route::post('registration/index3', array('uses' => 'EmployeeRegistrationController@postindex3'));
Route::post('registration/index4', array('uses' => 'EmployeeRegistrationController@postindex4'));
Route::post('registration/store', array('uses' => 'EmployeeRegistrationController@store'));
//*/
Route::post('forgot_password', array('uses' => 'EmployeeRegistrationController@postforgot_password'));
Route::get('forgot_password', array('uses' => 'EmployeeRegistrationController@forgot_password'));

Route::get('admin/index', array('uses' => 'UnitAdminEmployeeController@showindex'));
Route::post('admin/index', array('uses' => 'UnitAdminEmployeeController@postindex'));
Route::post('admin/index2', array('uses' => 'UnitAdminEmployeeController@postindex2'));
Route::post('admin/index3', array('uses' => 'UnitAdminEmployeeController@postindex3'));
Route::resource('admin/units', 'UnitAdminEmployeeController@unit');
Route::resource('admin/view', 'UnitAdminEmployeeController@view');
Route::resource('admin/edit', 'UnitAdminEmployeeController@edit');
Route::resource('admin/update', 'UnitAdminEmployeeController@update');
Route::post('admin/units', array('uses' => 'UnitAdminEmployeeController@postunit'));
Route::post('admin/unit2', array('uses' => 'UnitAdminEmployeeController@postunit2'));
Route::post('admin/unit3', array('uses' => 'UnitAdminEmployeeController@postunit3'));
Route::post('admin/saveunits', array('uses' => 'UnitAdminEmployeeController@saveunit'));
Route::post('admin/store', array('uses' => 'UnitAdminEmployeeController@store'));
Route::resource('employee/view', 'EmployeeLoginController@view');

Route::get('admins/objectives/indexdatatable', array('uses' => 'UnitAdminObjectiveController@showindexdatatable'));
Route::get('admins/objectives', array('uses' => 'UnitAdminObjectiveController@showindex'));
Route::post('admins/objectives/store', array('uses' => 'UnitAdminObjectiveController@showstore'));
Route::resource('admins/show', 'UnitAdminObjectiveController@show');
Route::resource('admins/edit', 'UnitAdminObjectiveController@edit');
Route::resource('admins/update', 'UnitAdminObjectiveController@update');

Route::post('admin/secondary', function()
	{
		if(Request::ajax())
		{
			$officeID2 = $_POST['officeID2'];
			$queries = DB::table('unit_office_tertiaries')
			->where('UnitOfficeSecondaryID', '=', $officeID2)
			->get();

			return Response::json($queries);
		}
	});

Route::post('admin/tertiary', function()
	{
		if(Request::ajax())
		{
			$officeID3 = $_POST['officeID3'];
			$queries = DB::table('unit_office_quaternaries')
			->where('UnitOfficeTertiaryID', '=', $officeID3)
			->get();

			return Response::json($queries);
		}
	});


//ajax routes for data tables
Route::get('admin/datatable' , 'UnitAdminEmployeeController@showEmployeeDatatable');

Route::get('admin/perspectives', array('uses' => 'UnitAdminPerspectiveController@index'));
Route::post('admin/perspectivesstore',array('uses' => 'UnitAdminPerspectiveController@store'));
Route::resource('unitadminperspectives','UnitAdminPerspectiveController@show');
Route::resource('unitadmineditperspective','UnitAdminPerspectiveController@edit');
Route::post('unitadminstoreperspective', array('uses' => 'UnitAdminPerspectiveController@store'));
Route::get('employee/SubmittedScorecardSupervisor', 'PrintController@showSupervisorSubmittedScorecards');
Route::get('employee/reportssupervisor', 'PrintController@showSupervisorReports');
Route::get('login/@den2', array('uses' => 'HomeController@showLogin'));
Route::get('login/employee', array('uses' => 'EmployeeLoginController@showLogin'));
Route::post('login/employee', array('uses' => 'EmployeeLoginController@doLogin'));

Route::get('employee/dashboard', array('uses' => 'EmployeeLoginController@showDashboard'));
Route::get('employee/dashboard/personnelnotif-submitted', 'EmployeeLoginController@notifSubmitted');
Route::get('employee/dashboard/personnelnotif-submitted-this-week', 'EmployeeLoginController@notifSubmittedThisWeek');
Route::get('employee/dashboard/personnelnotifDidNotSubmitted', 'EmployeeLoginController@notifDidNotSubmitted');
Route::get('employee/dashboard/personnelsubordinatereport', 'EmployeeLoginController@subordinateReport');



Route::get('employee/logout', array('uses' => 'EmployeeLoginController@doLogout'));
Route::get('login/unitadmin', array('uses' => 'UnitAdminLoginController@showLogin'));
Route::post('login/unitadmin', array('uses' => 'UnitAdminLoginController@doLogin'));
Route::get('logout/unitadmin',array('uses' => 'UnitAdminLoginController@doLogout'));
Route::get('Unitadmindashboard',array('uses' => 'UnitAdminLoginController@showDashboard'));
Route::post('Unitadmindashboard/personnelreport', array('uses' => 'UnitAdminLoginController@personnelReport'));
Route::post('Unitadmindashboard/personnelreport/secondary', array('uses' => 'HomeController@secondary'));
Route::post('Unitadmindashboard/personnelreport/tertiary', array('uses' => 'HomeController@tertiary'));
Route::post('Unitadmindashboard',array('uses' => 'UnitAdminLoginController@postDashboard'));
Route::get('/SubmittedScorecardUnitAdmin', 'PrintController@showUnitAdminSubmittedScorecards');

Route::get('unitadmin/changepassword', array('uses' => 'UnitAdminLoginController@ChangePassword'));
Route::post('unitadmin/changePassword', array('uses' => 'UnitAdminLoginController@postChangePassword'));

Route::get('Unitadmindashboard/selectemp/anykpiunit', 'DatatablesController@anyKpiUnitAdmin');
Route::get('Unitadmindashboard/selectemp', array('uses' => 'UnitAdminLoginController@showGraph'));
Route::post('Unitadmindashboard/selectemp/graph', array('uses' => 'UnitAdminLoginController@postGraph'));

Route::get('employee/dashboard/selectemp', array('uses' => 'EmployeeLoginController@showGraph'));
Route::post('employee/dashboard/graph', array('uses' => 'EmployeeLoginController@postGraph'));

Route::get('employee/dashboard/subselectemp', array('uses' => 'EmployeeLoginController@showGraphPersonnel'));
Route::post('employee/dashboard/subgraph', array('uses' => 'EmployeeLoginController@postGraphPersonnel'));

Route::get('UAEofficeobjectives', array('uses' => 'UnitAdminLoginController@assignObjectiveOfficeGet'));
Route::post('UAEofficeobjectives', array('uses' => 'UnitAdminLoginController@assignObjectiveOfficePost'));
Route::post('UAEupdateemployeeobjective', array('uses' =>'UnitAdminLoginController@updateEmployeeObjectiveUnitadmin'));
Route::get('UAEofficeobjectives/secondaryoffices', 'UnitAdminLoginController@secondaryoffices');
Route::get('UAEofficeobjectives/objectives','UnitAdminLoginController@objectives');
Route::get('UAEofficeobjectives/objectives/ajax/{id}','UnitAdminLoginController@ajaxobjectives');

// route for Unit Admin Activities
Route::get('UAEactivities','UnitAdminLoginController@showEmployeeActivities');
Route::get('UAEactivities/tempdatatable','UnitAdminLoginController@ajaxShowEmployeeActivities');

Route::resource('UAEaddemployeemain','UnitAdminLoginController@addEmployeeMainActivity');
Route::post('UAEpostaddemployeemainactivity',array('uses' => 'UnitAdminLoginController@postaddEmployeeMainActivity'));
Route::post('UAEpostaddEmployeeMeasure',array('uses' => 'UnitAdminLoginController@postaddEmployeeMeasure'));

Route::resource('UAEaddemployeesub','UnitAdminLoginController@addEmployeeSubActivity');
Route::post('UAEpostaddemployeesubactivity', array('uses' => 'UnitAdminLoginController@postaddEmployeeSubactivity'));
Route::post('UAEpostAddEmployeeSubMeasure', array('uses' => 'UnitAdminLoginController@postAddEmployeeSubMeasure'));

Route::resource('UAEsetemployeesub','UnitAdminLoginController@setEmployeeSubActivity');
Route::post('UAEpostsetemployeesubactivity','UnitAdminLoginController@postsetEmployeeSubActivity');
Route::post('UAEposteditemployeesubactivity', function()
	{ if(Input::get('Edit')) {$action = 'postEdit'; }
		return App::make('UnitAdminLoginController')->$action();});

Route::resource('UAEsetemployeemeasure','UnitAdminLoginController@setEmployeeMeasure');
Route::post('UAEpostsetemployeemeasure', array('uses' => 'UnitAdminLoginController@postsetEmployeeMeasure'));
Route::post('UAEpostsetemployeemeasure2',array('uses' => 'UnitAdminLoginController@postsetEmployeeMeasure2'));
Route::post('UAEposteditmeasure', array('uses' => 'UnitAdminLoginController@postEditMeasure'));

Route::resource('UAEaddemployeemeasure','UnitAdminLoginController@addEmployeeMeasure');
Route::post('UAEaddEmployeeSubMeasure', array('uses' => 'UnitAdminLoginController@UAEaddemployeesubmeasure'));

Route::get('UAEsetemployeeobjective/{id}','UnitAdminLoginController@setEmployeeObjective');
Route::post('UAEpostsetEmployeeObjective',array('uses' => 'UnitAdminLoginController@postsetEmployeeObjective'));
Route::post('UAEpostsetEmployeeObjective2',array('uses' => 'UnitAdminLoginController@postsetEmployeeObjective2'));
Route::post('UAEpostemployeesaveobjective',array('uses' => 'UnitAdminLoginController@savePostSetEmployeeObjective'));
Route::post('UAEsetemployeeobjective/UAEobjectivetemp', array('uses' => 'UnitAdminLoginController@ajaxUAsetObjective'));

Route::resource('UnitAdminSecondaryOffice','UnitAdminSecondaryOfficeController');
Route::post('UnitAdminSecondaryOfficeControllerStore',array('uses' => 'UnitAdminSecondaryOfficeController@store'));

Route::resource('UnitAdminTertiaryOffice','UnitAdminTertiaryOfficeController');
Route::post('UnitAdminTertiaryOfficeControllerStore',array('uses' => 'UnitAdminTertiaryOfficeController@store'));

Route::resource('UnitAdminQuaternaryOffice','UnitAdminQuaternaryOfficeController');
Route::post('UnitAdminQuaternaryOfficeControllerStore',array('uses' => 'UnitAdminQuaternaryOfficeController@store'));

// route to process the form
Route::post('login/@den2', array('uses' => 'HomeController@doLogin'));
Route::get('logout/@den2', array('uses' => 'HomeController@doLogout'));
Route::get('dashboard', array('uses' => 'HomeController@showDashboard'));
Route::post('dashboard/personnelreport', array('uses' => 'HomeController@personnelReport'));
Route::post('dashboard/personnelreport/primary', array('uses' => 'HomeController@primary'));
Route::post('dashboard/personnelreport/secondary', array('uses' => 'HomeController@secondary'));
Route::post('dashboard/personnelreport/tertiary', array('uses' => 'HomeController@tertiary'));
Route::get('dashboard/selectemp', array('uses' => 'HomeController@showGraph'));
Route::get('dashboard/selectemp/kpitable', 'DatatablesController@anyKpi');
Route::post('dashboard/selectemp/graph', array('uses' => 'HomeController@postGraph'));
//new





Route::post('admin/units/secondaryunit', 'UnitAdminEmployeeController@secondaryunit');
Route::post('admin/units/tertiaryunit', 'UnitAdminEmployeeController@tertiaryunit');




// routes for ajax
Route::post('primary', function()
	{
		if(Request::ajax())
		{
			$officeID = $_POST['officeID'];
			$queries = DB::table('unit_office_secondaries')
			->where('UnitOfficeID', '=', $officeID)
			->get();

			return Response::json($queries);
		}
	});

Route::post('secondary', function()
	{
		if(Request::ajax())
		{
			$officeID2 = $_POST['officeID2'];
			$queries = DB::table('unit_office_tertiaries')
			->where('UnitOfficeSecondaryID', '=', $officeID2)
			->get();

			return Response::json($queries);
		}
	});




Route::post('tertiary', function()
	{
		if(Request::ajax())
		{
			$officeID3 = $_POST['officeID3'];
			$queries = DB::table('unit_office_quaternaries')
			->where('UnitOfficeTertiaryID', '=', $officeID3)
			->get();

			return Response::json($queries);
		}
	});





/*Route::post('search', function()
{
	if(Request::ajax())
	{
		$keywords = $_POST['keyword'];
		$employs = Employ::all();
		$searchUsers= new \Illuminate\Database\Eloquent\Collection();
		$searchUsersJoin = new \Illuminate\Database\Eloquent\Collection();

		foreach($employs as $employ)
		{
			if(Str::contains(Str::lower($employ->EmpLastName), Str::lower($keywords)))
				$searchUsers->add($employ);
		}

		foreach($searchUsers as $searchUser)
		{
			$employjoin = DB::table('employs')
			->join('ranks', 'employs.RankID', '=', 'ranks.id')
			->join('positions', 'employs.PositionID', '=', 'positions.id')
			->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
			->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
			->where('employs.id', '=', $searchUser->id)
			->select('employs.id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName', 'employs.EmpFirstName', 'employ_supervisor.EmpLastName AS SupervisorLastName', 'employ_supervisor.EmpFirstName AS SupervisorFirstName', 'ranks.RankCode as rank', 'positions.PositionName as position', 'unit_offices.UnitOfficeName')
			->get();

			$searchUsersJoin->add($employjoin);

		}

		require( 'ssp.class.php' );
		return Response::json($searchUsersJoin);
	}


}); */

Route::controller('datatables', 'DatatablesController', [
    'anyData'  => 'datatables.data',
    'getIndex' => 'datatables',
]);

Route::get('dtables/employs', 'DatatablesController@anyData');
Route::get('datatable', 'DatatablesController@anyDash');
Route::get('unit_office/unipri', 'DataAdminController@anyUnitPri');
Route::get('unisec', 'DatatablesController@anyUnitSec');
Route::get('uniter', 'DatatablesController@anyUnitTer');
Route::get('anyunitdash', 'DatatablesController@anyDashUnit');
Route::get('obj/office_objectives', 'DataAdminController@anyObj');
Route::get('objectives/ajax/{id}','DataAdminController@anyObjajax');
Route::get('pri/office_objectives', 'DatatablesController@anyPriObj');
Route::get('sec/office_objectives', 'DatatablesController@anySecObj');

Route::get('uniqua', 'Unit_office_quaternariesController@anyUnitQua');
Route::get('unitqua', 'UnitAdminQuaternaryOfficeController@anyUniQua');
Route::get('unitter', 'UnitAdminTertiaryOfficeController@anyUniTer');
Route::get('unitsec', 'UnitAdminSecondaryOfficeController@anyUniSec');
Route::get('notif-submitted', 'DatatablesController@notifSubmitted');
Route::get('notif-submitted-this-week', 'DatatablesController@notifSubmittedThisWeek');
Route::get('notifDidNotSubmitted', 'DatatablesController@notifDidNotSubmitted');
Route::get('notifNoScorecard', 'DatatablesController@notifNoScorecard');


Route::get('UAnotifsubmitted', 'DatatablesController@UANotifSubmitted');
Route::get('UAnotiflastweeksubmitted', 'DatatablesController@UANotifLastWeekSubmitted');
Route::get('UAnotifdidntsubmit', 'DatatablesController@UANotifDidntSubmit');
Route::get('UAnotifnoscorecard', 'DatatablesController@UANotifNoScorecard');



Route::get('objective', 'ObjectivesController@anyObjective');

Route::get('NotifSubmittedUnit', 'DatatablesController@NotifSubmittedUnit');



Route::get('removeempact/{id}','RemoveEmployeeActController@showRemoveEmpAct');

Route::post('employee/deletemain', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMain'; }
			return App::make('RemoveEmployeeActController')->$action();
		});

Route::post('employee/deletesub', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteSub'; }
			return App::make('RemoveEmployeeActController')->$action();
		});

Route::get('removeEmpSub/{id}','RemoveEmployeeActController@showRemoveEmpSub');

Route::get('removeEmpMeasure/{id}','RemoveEmployeeActController@showRemoveEmpMeasure');
Route::post('employee/deletemeasure', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMeasure'; }
			return App::make('RemoveEmployeeActController')->$action();
		});


Route::get('employee/EMPremoveEmpAct','EMPRemoveEmployeeActController@showRemoveEmpAct');
Route::get('employee/EMPremoveAllEmpSub','EMPRemoveEmployeeActController@showRemoveAllEmpSub');
Route::get('employee/EMPremoveEmpMeasure','EMPRemoveEmployeeActController@showRemoveAllEmpMeasure');


Route::post('employee/EMPdeletemain', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMain'; }
			return App::make('EMPRemoveEmployeeActController')->$action();
		});

Route::post('employee/EMPdeletesub', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteSub'; }
			return App::make('EMPRemoveEmployeeActController')->$action();
		});

Route::get('EMPremoveEmpSub/{id}','EMPRemoveEmployeeActController@showRemoveEmpSub');

Route::get('EMPremoveEmpMeasure/{id}','EMPRemoveEmployeeActController@showRemoveEmpMeasure');
Route::post('employee/EMPdeletemeasure', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMeasure'; }
			return App::make('EMPRemoveEmployeeActController')->$action();
		});


Route::get('uaremoveempact/{id}','UARemoveEmployeeActController@showRemoveEmpAct');

Route::post('employee/uadeletemain', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMain'; }
			return App::make('UARemoveEmployeeActController')->$action();
		});

Route::post('employee/uadeletesub', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteSub'; }
			return App::make('UARemoveEmployeeActController')->$action();
		});

Route::get('UAremoveEmpSub/{id}','UARemoveEmployeeActController@showRemoveEmpSub');

Route::get('UAremoveEmpMeasure/{id}','UARemoveEmployeeActController@showRemoveEmpMeasure');
Route::post('employee/uadeletemeasure', function()
		 { if(Input::get('Delete')) { $action = 'postDeleteMeasure'; }
			return App::make('UARemoveEmployeeActController')->$action();
		});




Route::get('employeeactivities','HomeController@showEmployeeActivities');
Route::get('employeeactivities/tempdatatable','HomeController@ajaxShowEmployeeActivities');
Route::resource('addemployeemain','HomeController@addEmployeeMainActivity');
Route::post('postaddemployeemainactivity',array('uses' => 'HomeController@postaddEmployeeMainActivity'));
Route::post('postaddEmployeeMeasure',array('uses' => 'HomeController@postaddEmployeeMeasure'));

Route::resource('addemployeesub','HomeController@addEmployeeSubActivity');
Route::post('postaddemployeesubactivity', array('uses' => 'HomeController@postaddEmployeeSubactivity'));
Route::post('postAddEmployeeSubMeasure', array('uses' => 'HomeController@postAddEmployeeSubMeasure'));

Route::resource('addemployeemeasure','HomeController@addEmployeeMeasure');

Route::post('employs/processupload', 'EmploysController@processCroppedPhoto');
Route::get('employs/finishedupload','EmploysController@finishedCroppedPhoto');


Route::post('employs/edit/processupload', 'EmploysController@processCroppedPhotoEdit');
Route::get('employs/finisheduploadedit','EmploysController@finishedCroppedPhotoEdit');

Route::post('admin/store/changephoto/processupload','UnitAdminEmployeeController@processCroppedPhoto');
Route::get('admin/store/changephoto/finishedupload','UnitAdminEmployeeController@finishedCroppedPhoto');

Route::post('admin/update/edit/changephoto/processuploadedit','UnitAdminEmployeeController@processCroppedPhotoEdit');
Route::get('admin/update/edit/changephoto/finisheduploadedit','UnitAdminEmployeeController@finishedCroppedPhotoEdit');


Route::resource('setemployeemain','HomeController@setEmployeeMainActivity');
Route::post('posteditemployeemainactivity',function()
	{ if(Input::get('Edit')) {$action = 'postEditMain'; }
		return App::make('HomeController')->$action();});

Route::resource('employee/employeeeditmain','EmployeeLoginController@editEmployeeMainActivity');
Route::post('employee/editemployeemainactivity',function()
	{ if(Input::get('Edit')) {$action = 'postEditMainEmp'; }
		return App::make('EmployeeLoginController')->$action();});

Route::resource('UAEsetemployeemain','UnitAdminEmployeeController@UAEsetEmployeeMainActivity');
Route::post('postUAEeditemployeemainactivity',function()
	{ if(Input::get('Edit')) {$action = 'postUAEeditMain'; }
		return App::make('UnitAdminEmployeeController')->$action();});

Route::resource('setemployeesub','HomeController@setEmployeeSubActivity');
Route::post('postsetemployeesubactivity','HomeController@postsetEmployeeSubActivity');
Route::post('posteditemployeesubactivity', function()
	{ if(Input::get('Edit')) {$action = 'postEdit'; }
		return App::make('HomeController')->$action();});
Route::resource('setemployeemeasure','HomeController@setEmployeeMeasure');
Route::post('postsetemployeemeasure', array('uses' => 'HomeController@postsetEmployeeMeasure'));
Route::post('postsetemployeemeasure2',array('uses' => 'HomeController@postsetEmployeeMeasure2'));
Route::post('posteditmeasure', array('uses' => 'HomeController@postEditMeasure'));
Route::get('setemployeeobjective/{id}','HomeController@setEmployeeObjective');
Route::post('setemployeeobjective/perspectiveid', 'HomeController@ajaxperspectiveid');
Route::post('postsetEmployeeObjective',array('uses' => 'HomeController@postsetEmployeeObjective'));
Route::post('postsetEmployeeObjective2',array('uses' => 'HomeController@postsetEmployeeObjective2'));

Route::post('saveupdatepostemployeeobjective',array('uses' => 'HomeController@saveupdatePostSetEmployeeObjective'));
Route::post('UAEsaveupdatepostemployeeobjective',array('uses' => 'UnitAdminLoginController@saveupdatePostSetEmployeeObjective'));

Route::get('employee/set_activities', array('uses' => 'SetActivitiesController@showSetActivity'));
Route::post('employee/postset_activities', array('uses' => 'SetActivitiesController@postSetActivity'));
Route::post('employee/postedit_activities', function()
		 { if(Input::get('Edit')) { $action = 'postEdit'; } 
			return App::make('SetActivitiesController')->$action(); });

Route::get('employee/set_measures', array('uses' => 'SetMeasuresController@showSetMeasure'));
Route::post('employee/postset_measures', array('uses' => 'SetMeasuresController@postSetMeasure'));
Route::post('employee/postset_measures2', array('uses' => 'SetMeasuresController@postSetMeasure2'));
Route::post('employee/postedit_measures', array('uses' => 'SetMeasuresController@postEditMeasure'));
Route::post('employee/set_measures/edit_measures', array('uses' => 'SetMeasuresController@ajaxEditMeasure'));
Route::post('change_password', array('uses' => 'EmployeeLoginController@changePassword'));
Route::get('employee/change_password', array('uses' => 'EmployeeLoginController@showChangePassword'));

Route::get('employee/change_photo', array('uses' => 'EmployeeLoginController@showChangePhoto'));
Route::post('change_photo', array('uses' => 'EmployeeLoginController@changePhoto'));

Route::post('employee/changephoto/processupload','EmployeeLoginController@processCroppedPhoto');
Route::get('employee/changephoto/finishedupload','EmployeeLoginController@finishedCroppedPhoto');



Route::get('employee/scorecard', array('uses' => 'EmployeeLoginController@createScorecard'));
Route::get('employee/addsubactivities', array('uses' => 'EmployeeLoginController@addSubactivities'));
Route::post('employee/postaddsubactivities', array('uses' => 'EmployeeLoginController@postaddsubactivities'));
Route::post('employee/postaddsubactivities_measures', array('uses' => 'EmployeeLoginController@postaddsubactivities_measures'));
Route::post('employee/postscorecard',array('uses'=>'EmployeeLoginController@postCreateScoreCard'));
Route::post('employee/postscorecard_accomplishments',array('uses'=>'EmployeeLoginController@postCreateScoreCardMeasure'));


Route::get('employee/reports', array('uses' => 'EmployeeLoginController@showEmployeeAccomplishment'));
Route::get('employee/reports-pdf', array('uses' => 'EmployeeLoginController@showEmployeeAccomplishmentPost'));
Route::get('employee/accomplishment', array('uses' => 'ScorecardController@showAccomplishment'));
Route::get('employee/accomplishment-pending', array('uses' => 'ScorecardController@showPendingAccomplishment'));
Route::get('employee/accomplishment-assign', array('uses' => 'ScorecardController@showAssignAccomplishment'));
Route::get('employee/accomplishment-final', array('uses' => 'ScorecardController@showFinalAccomplishment'));

Route::post('employee/accomplishment', array('uses' => 'ScorecardController@postAccomplishment'));
Route::post('employee/accomplishment-pending', array('uses' => 'ScorecardController@showPendingAccomplishmentPost'));
Route::post('employee/accomplishment-assign', array('uses' => 'ScorecardController@showAssignAccomplishmentPost'));


Route::post('employee/accomplishment-final', function()
		 { if(Input::get('Submit')) { $action = 'postFinalAccomplishment'; }
		  elseif(Input::get('Reset')) { $action = 'postReset'; } 
			return App::make('ScorecardController')->$action();
		});



Route::resource('employee/subordinatepending','EmployeeLoginController@showSubordinatePendingTargets');


Route::post('employee/ApprovePending', function()
		 { if(Input::get('Approve')) { $action = 'ApprovePending'; }
		  elseif(Input::get('Reject')) { $action = 'RejectPending'; } 
			return App::make('EmployeeLoginController')->$action();
		});

Route::get('employee/otheractivities', array('uses' => 'OtherActivitiesController@showOtherActivities'));
Route::post('employee/postOtherActivities', array('uses' =>'OtherActivitiesController@postAddOther'));
Route::post('employee/postAddOtherMeasure', array('uses' =>'OtherActivitiesController@postAddMeasures'));
Route::resource('editOtherMeasures','OtherActivitiesController@editOtherMeasures');

Route::post('employee/postOtherScorecard', function()
		 { if(Input::get('Edit')) { $action = 'postEditOther'; }
		  elseif(Input::get('Save')) { $action = 'postSaveOther'; } 
			return App::make('OtherActivitiesController')->$action();
		});

Route::post('employee/postEditOtherMeasure', function()
		 { if(Input::get('Edit')) { $action = 'postEditMeasure'; }
		  elseif(Input::get('Save')) { $action = 'postSaveMeasure'; } 
			return App::make('OtherActivitiesController')->$action();
		});



Route::get('UAEotheractivity/otheractivities/{id}', array('uses' => 'OtherActivitiesController@showUAEOtherActivities'));
Route::post('UAEotheractivity/postOtherActivities', array('uses' =>'OtherActivitiesController@postAddUAEOther'));
Route::post('UAEothermeasure/postAddOtherMeasure', array('uses' =>'OtherActivitiesController@postAddUAEMeasures'));
Route::resource('UAEeditOtherMeasures','OtherActivitiesController@editUAEOtherMeasures');

Route::post('UAEotheractivity/postOtherScorecard', function()
		 { if(Input::get('Edit')) { $action = 'postEditUAEOther'; }
		  elseif(Input::get('Save')) { $action = 'postSaveUAEOther'; } 
			return App::make('OtherActivitiesController')->$action();
		});

Route::post('UAEothermeasure/postEditOtherMeasure', function()
		 { if(Input::get('Edit')) { $action = 'postEditUAEMeasure'; }
		  elseif(Input::get('Save')) { $action = 'postSaveUAEMeasure'; } 
			return App::make('OtherActivitiesController')->$action();
		});


Route::get('SUotheractivity/otheractivities/{id}', array('uses' => 'HomeController@showSUOtherActivities'));
Route::post('SUotheractivity/postOtherActivities', array('uses' =>'HomeController@postAddSUOther'));
Route::post('SUothermeasure/postAddOtherMeasure', array('uses' =>'HomeController@postAddSUMeasures'));
Route::resource('SUeditOtherMeasures','HomeController@editSUOtherMeasures');

Route::post('SUotheractivity/postOtherScorecard', function()
		 { if(Input::get('Edit')) { $action = 'postEditSUOther'; }
		  elseif(Input::get('Save')) { $action = 'postSaveSUOther'; } 
			return App::make('HomeController')->$action();
		});

Route::post('SUothermeasure/postEditOtherMeasure', function()
		 { if(Input::get('Edit')) { $action = 'postEditSUMeasure'; }
		  elseif(Input::get('Save')) { $action = 'postSaveSUMeasure'; } 
			return App::make('HomeController')->$action();
		});

Route::get('employee/assignobjective', array('uses' => 'EmployeeLoginController@showAssignObjective'));
Route::post('employee/assignobjective/empperspectiveid', array('uses' => 'EmployeeLoginController@ajaxperspectiveid'));
Route::post('employee/postassignobjective', array('uses' =>'EmployeeLoginController@postAssignObjective'));
Route::post('employee/postassignobjective2', array('uses' => 'EmployeeLoginController@postAssignObjective2'));

Route::post('employee/saveupdateobjective', array('uses' => 'EmployeeLoginController@saveupdateObjective'));

Route::resource('employee/addmeasures','EmployeeLoginController@EmployeeMeasureAdd');
Route::post('employee/successfuladdmeasures', array('uses' => 'EmployeeLoginController@Employeesubmeasure'));

Route::get('employeestatusunitadmin', array('uses' => 'UnitAdminEmployeeStatusController@doLogin'));
Route::get('employeestatusunitadminindex','UnitAdminEmployeeStatusController@index');
Route::get('employeestatusunitadminindex/tempdatatable','UnitAdminEmployeeStatusController@indexdatatable');
Route::post('unitadminempstatus', function()
			 { if(Input::get('unsuspend')) { $action = 'unsuspend'; }
			  elseif(Input::get('suspend')) { $action = 'suspend'; } 
				return App::make('UnitAdminEmployeeStatusController')->$action();
			});
Route::post('unitadminempremove',array('uses'=>'UnitAdminEmployeeStatusController@delete'));
Route::post('unitadminloginagain', array('uses' => 'UnitAdminEmployeeStatusController@doLoginAgain'));
//AUTH
Route::group(["before" => "auth"], function() {
	Route::get('dashboard', array('uses' => 'HomeController@showDashboard'));
	Route::post('dashboard', array('uses' => 'HomeController@postDashboard'));

	Route::post('postremovescorecard', array('uses' => 'HomeController@postRemoveScorecard'));

	Route::get('maintenance', array('uses' => 'HomeController@showMaintenance'));
	Route::resource('ranks', 'RanksController');
	Route::resource('positions', 'PositionsController');
	Route::post("employs/search", array(
				'as' => 'employs.search',
				'uses' => 'EmploysController@postSearch'
			));
	Route::resource('employs', 'EmploysController');
	Route::resource('main_activities', 'Main_activitiesController');
	Route::resource('unit_offices', 'Unit_officesController');
	Route::resource('unit_office_secondaries', 'Unit_office_secondariesController');
	Route::resource('unit_office_tertiaries', 'Unit_office_tertiariesController');
	Route::resource('unit_office_quaternaries', 'Unit_office_quaternariesController');
	Route::resource('measures', 'MeasuresController');
	Route::resource('sub_activities', 'Sub_activitiesController');
	Route::resource('perspectives', 'PerspectivesController');
	Route::resource('measure_target_units', 'Measure_target_unitsController');
	Route::resource('objectives', 'ObjectivesController');
	Route::resource('measure_targets', 'Measure_targetsController');
	Route::post('employs/index', array('uses' => 'EmploysController@postindex'));
	Route::post('employs/index2', array('uses' => 'EmploysController@postindex2'));
	Route::post('employs/index3', array('uses' => 'EmploysController@postindex3'));
	Route::post('employs/index4', array('uses' => 'EmploysController@postindex4'));

	Route::resource('employee/unit','EmploysController@unit');
	Route::post('employee/unit', array('uses' => 'EmploysController@postunit'));
	Route::post('employee/unit2', array('uses' => 'EmploysController@postunit2'));
	Route::post('employee/unit3', array('uses' => 'EmploysController@postunit3'));
	Route::post('employee/unit4', array('uses' => 'EmploysController@postunit4'));
	Route::post('employee/saveunit', array('uses' => 'EmploysController@saveunit'));


	Route::post('employee/unit/primary', array('uses' => 'HomeController@primary'));
	Route::post('employee/unit/secondary', array('uses' => 'HomeController@secondary'));
	Route::post('employee/unit/tertiary', array('uses' => 'HomeController@tertiary'));


	Route::get('unit_admins/indexdatatable', array('uses' => 'UnitAdminController@indexDataTable'));
	Route::resource('unit_admins', 'UnitAdminController');
	Route::post('unit_admins/tempIndex', array('uses' => 'UnitAdminController@ajaxPostIndex'));
	Route::post('unit_admin/index', array('uses' => 'UnitAdminController@postindex'));
	Route::post('unit_admin/index2', array('uses' => 'UnitAdminController@postindex2'));

	Route::resource('unit_admins/unit','HomeController@unit');
	Route::post('unit_admins/unit/temp', array('uses' => 'HomeController@ajaxpostunit'));
	Route::post('unit_admins/unit', array('uses' => 'HomeController@postunit'));
	Route::post('unit_admins/unit2', array('uses' => 'HomeController@postunit2'));
	Route::post('unit_admins/saveunit', array('uses' => 'HomeController@saveunit'));

	Route::get('office_objectives', array('uses' => 'HomeController@assignObjectiveOfficeGet'));
	Route::post('office_objectives', array('uses' => 'HomeController@assignObjectiveOfficePost'));

	Route::get('employeestatus', array('uses' => 'EmployeeStatusController@doLogin'));
	Route::get('employeestatusindex','EmployeeStatusController@index');
	Route::get('employeestatusindex/tempdatatable','EmployeeStatusController@indexdatatable');

	Route::post('empstatus', function()
			 { if(Input::get('unsuspend')) { $action = 'unsuspend'; }
			  elseif(Input::get('suspend')) { $action = 'suspend'; } 
				return App::make('EmployeeStatusController')->$action();
			});

	Route::post('empremove', array('uses' => 'EmployeeStatusController@delete'));
	Route::post('adminloginagain', array('uses' => 'EmployeeStatusController@doLoginAgain'));
	

	});
?>
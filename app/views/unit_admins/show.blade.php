@extends("layout-noheader")
@section("content")

<style type="text/css">
body{padding-top:30px;}

.glyphicon {  margin-bottom: 10px;margin-right: 10px;}

small {
display: block;
line-height: 1.428571429;
color: #999;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well well-sm">
                <div class="row">
                   
                    <div class="col-sm-6 col-md-8">
                        <h4>
                            Name: {{$unit_admin->LastName}}, {{$unit_admin->FirstName}}</h4>
                        <p>
                           
                            <i class="glyphicon glyphicon-user"></i><strong>Username:</strong>{{$unit_admin->UserName}}
                            <br />
                            <i class="glyphicon glyphicon-lock"></i><strong>Password:</strong>{{$unit_admin->Password}}
                            <br />
                             <i class="glyphicon glyphicon-lock"></i><strong>Email:</strong>{{$unit_admin->AdminEmail}}
                            <br />
                            <i class="glyphicon glyphicon-briefcase"></i><strong>Unit Office:</strong> @foreach ($unit_offices as $unit_office)
                            @if ($unit_office->id == $unit_admin->UnitOfficeID)
                              {{  $unit_office->UnitOfficeName }}
                            @endif
                          @endforeach
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-triangle-right"></i><strong>Secondary Unit Office:</strong> @foreach ($unit_office_secondaries as $unit_office_secondary)
                            @if ($unit_office_secondary->id == $unit_admin->UnitOfficeSecondaryID)
                              {{  $unit_office_secondary->UnitOfficeSecondaryName }}
                            @endif
                          @endforeach
                            </p>
                        <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

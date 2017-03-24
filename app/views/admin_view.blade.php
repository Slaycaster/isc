@extends("layout-noheader2")
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
                    <div class="col-sm-6 col-md-4">
                      <img src="{{URL::asset($employee->EmpPicturePath)}}" style="width:280px; height: 300px" alt="" class="img-rounded img-responsive">     
                    </div>
                    <div class="col-sm-6 col-md-8">
                    <h6>
                            Badge Number: {{$employee->BadgeNo}}</h6>
                        <h4>
                            Name: {{$employee->EmpLastName}}, {{$employee->EmpFirstName}} {{$employee->EmpQualifier}} {{$employee->EmpMidInit}}</h4>
                        <p>
                            <i class="glyphicon glyphicon-bookmark"></i><strong>Rank:</strong>  @foreach ($ranks as $rank)
                            @if ($rank->id == $employee->RankID)
                              {{  $rank->RankName }}
                            @endif
                          @endforeach
                            <br />
                            <i class="glyphicon glyphicon-star-empty"></i><strong>Position:</strong>  @foreach ($positions as $position)
                            @if ($position->id == $employee->PositionID)
                              {{  $position->PositionName }}
                            @endif
                          @endforeach
                            <br />
                            <i class="glyphicon glyphicon-user"></i><strong>Username:</strong>{{$employee->EmpID}}
                            <br />
                            <i class="glyphicon glyphicon-lock"></i><strong>Password:</strong>{{$employee->EmpPassword}}
                            <br />
                            <i class="glyphicon glyphicon-user"></i><strong>Email:</strong>{{$employee->email}}
                            <br />
                             <i class="glyphicon glyphicon-user"></i><strong>Supervisor:</strong>  
                            @foreach ($supervisors as $supervisor)
                            @if ($supervisor->id == $employee->SupervisorID)
                              {{  $supervisor->EmpLastName }},  {{  $supervisor->EmpFirstName }}
                            @endif
                          @endforeach
                            <br />
                            <i class="glyphicon glyphicon-briefcase"></i><strong>Unit Office:</strong> @foreach ($unit_offices as $unit_office)
                            @if ($unit_office->id == $employee->UnitOfficeID)
                              {{  $unit_office->UnitOfficeName }}
                            @endif
                          @endforeach
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-triangle-right"></i><strong>Secondary Unit Office:</strong> @foreach ($unit_office_secondaries as $unit_office_secondary)
                            @if ($unit_office_secondary->id == $employee->UnitOfficeSecondaryID)
                              {{  $unit_office_secondary->UnitOfficeSecondaryName }}
                            @endif
                          @endforeach
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-triangle-right"></i><strong>Tertiary Unit Office:</strong> @foreach ($unit_office_tertiaries as $unit_office_tertiary)
                            @if ($unit_office_tertiary->id == $employee->UnitOfficeTertiaryID)
                              {{  $unit_office_tertiary->UnitOfficeTertiaryName }}
                            @endif
                          @endforeach
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-triangle-right"></i><strong>Quaternary Unit Office:</strong> @foreach ($unit_office_quaternaries as $unit_office_quaternary)
                            @if ($unit_office_quaternary->id == $employee->UnitOfficeQuaternaryID)
                              {{  $unit_office_quaternary->UnitOfficeQuaternaryName }}
                            @endif
                          @endforeach</p>
                        <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
   window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#';
        window.location.reload();
    }
}

</script>
@stop

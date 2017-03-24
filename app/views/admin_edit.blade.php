@extends("layout-noheader2")
@section("content")
 
<div class="label_white">
  <h1>Employee Maintenance</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Update an Employee</strong>
  </div>
  <div class="panel-body">
    {{ Form::model($employee, array('method' => 'PATCH', 'url' => array('admin/update', $employee->id), 'files' => true)) }}
            <fieldset>
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">


                    <div class="form-group">
                      <div class="input-group">
                        @if ($errors->any())
                            <ul>
                                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                            </ul>
                        @endif
                           @if (Session::has('email-error'))

                              <div class="alert alert-danger">{{ Session::get('email-error') }}</div>

                          @endif
                      </div>
                    </div>
                        <div class="form-group">
                            
                        </div>
                       <div class="form-group"> 
                          <div>{{ Form::label('BadgeNo', 'Badge Number:') }}</div>
                          <div style='color:black'>{{ Form::text('BadgeNo', Input::get('BadgeNo'), array('placeholder' => 'Badge Number','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                       </div>
                        <div class="form-group"> 
                          <div>{{ Form::label('EmpLastName', 'Last Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpLastName', Input::get('EmpLastName'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpFirstName', 'First Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpFirstName', Input::get('EmpFirstName'), array('placeholder' => 'First Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                          <div class="form-group"> 
                          <div>{{ Form::label('EmpMidInit', ' Middle Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpMidInit', Input::get('EmpMidInit'), array('placeholder' => ' Middle Initial','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpQualifier', 'Qualifier:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpQualifier', Input::get('EmpQualifier'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                         <div class="form-group"> 
                          <div>{{ Form::label('EmpID', 'Username:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpID', Input::get('EmpID'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpPassword', 'Password:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpPassword', Input::get('EmpPassword'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('email', 'Email:') }}</div>
                          <div style='color:black'>{{ Form::text('email', Input::get('email'), array('placeholder' => 'pnp@gmail.com','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group">
                          <div>{{ Form::label('EmpPicturePath', 'Select Profile Picture:') }}</div>
                          <div>{{ Form::file('EmpPicturePath') }}</div>
                          <div>{{ Form::hidden('picture_path',$employee->EmpPicturePath) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('RankID', 'Rank:') }}</div>
                        <div style='color:black'>{{ Form::select('RankID', $ranks_id, Input::old('RankID'), array('class' => 'btn btn-default', 'id' => 'searchable1')) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('PositionID', 'Position:') }}</div>
                        <div style='color:black'>{{ Form::select('PositionID', $positions_id, Input::old('PositionID'), array('class' => 'btn btn-default', 'id' => 'searchable2')) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('SupervisorID', 'Supervisor:') }}</div>
                        <div style='color:black'>{{ Form::select('SupervisorID', $supervisors, Input::old('SupervisorID'), array('class' => 'btn btn-default', 'id' => 'searchable3')) }}</div>
                        </div>

                         <div class="form-group">
                           <div class="col-md-2">
                            <div>{{ Form::checkbox('OwnSupervisorID', 'true') }}</div></div>
                             <div class="col-md-10">
                            <div>{{ Form::label('SupervisorID', "I'm the supervisor myself") }}</div></div><br><br>
                        </div>
     
                        <div class="form-group">
                          {{ Form::submit('Submit', array('class' => 'btn btn-lg btn-success btn-block')) }}
                        </div>
                  </div>
                </div>
              </fieldset>
{{ Form::close() }}

@if ($errors->any())
  <ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
  </ul>
@endif
  </div>
</div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchable1").searchable({
      ignoreCase: true
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchable2").searchable({
      ignoreCase: true
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchable3").searchable({
      ignoreCase: true
      });
  });
</script>
@stop

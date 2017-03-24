@extends("layout-noheader")
@section("content")

<div class="label_white">
  <h1>Unit Admin Maintenance</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Update an Unit Admin</strong>
  </div>
  <div class="panel-body">
{{ Form::model($unit_admin, array('method' => 'PATCH', 'route' => array('unit_admins.update', $unit_admin->id), 'files' => true)) }}
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
                      </div>
                    </div> 
                        <div class="form-group">
                            
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('LastName', 'Last Name:') }}</div>
                          <div style='color:black'>{{ Form::text('LastName', Input::get('LastName'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('FirstName', 'First Name:') }}</div>
                          <div style='color:black'>{{ Form::text('FirstName', Input::get('FirstName'), array('placeholder' => 'First Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                          <div class="form-group"> 
                          <div>{{ Form::label('UserName', 'User Name:') }}</div>
                          <div style='color:black'>{{ Form::text('UserName', Input::get('UserName'), array('placeholder' => ' Middle Initial','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('Password', 'Password:') }}</div>
                          <div style='color:black'>{{ Form::text('Password', Input::get('Password'), array('placeholder' => 'Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>
                        
                        <div class="form-group"> 
                          <div>{{ Form::label('AdminEmail', 'Email:') }}</div>
                          <div style='color:black'>{{ Form::text('AdminEmail', Input::get('AdminEmail'), array('placeholder' => 'Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
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
@stop
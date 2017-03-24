@extends("layout-noheader2")
@section("content")

<div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Update Objective</strong>
          </div>
          <div class="panel-body">
            {{ Form::model($objective, array('method' => 'PATCH', 'url' => array('admins/update', $objective->id), 'files' => true)) }}
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
                        <div>{{ Form::label('ObjectiveName', 'Objective Name:') }}</div>
                        <div style='color:black'>{{ Form::text('ObjectiveName', Input::get('ObjectiveName'), array('placeholder' => 'Objective Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('PerspectiveID', 'Perspective:') }}</div>
                        <div style='color:black'>{{ Form::select('PerspectiveID', $perspectives_id, Input::old('PerspectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Objective', array('class' => 'btn btn-lg btn-success btn-block')) }}
                    </div>
                  </div>
                </div>
              </fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>
@stop
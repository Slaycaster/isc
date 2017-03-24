@extends('layout-noheader2')
@section('content')

<div class="label_white">
<h1>Unit Office Tertiary Maintenance</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Update a Unit Office Tertiary</strong>
    </div>
        <div class="panel-body">
        {{ Form::model($unit_office_tertiary, array('method' => 'PATCH', 'route' => array('UnitAdminTertiaryOffice.update', $unit_office_tertiary->id))) }}
         
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
                                        <div>{{ Form::label('UnitOfficeTertiaryName', 'Tertiary Unit Office Name:') }}</div>
                                        <div style='color:black'>{{ Form::text('UnitOfficeTertiaryName', Input::get('UnitOfficeTertiaryName'), array('placeholder' => 'Unit Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                                    </div>


                                    <div class="form-group">
                                        <div>{{ Form::label('UnitOfficeSecondaryID', 'Secondary Unit Office:') }}</div>
                                     <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $secondary_unit_offices_id, Input::old('UnitOfficeSecondaryID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                                    </div>

                                    <div class="form-group">
                                        <div>{{ Form::label('UnitOfficeHasQuaternary', 'Unit Office has Field:') }}</div>
                                      
                                            <div class='col-md-6'>
                                                <div style='color:black'>{{Form::radio('UnitOfficeHasQuaternary', 'True', true)}} True</div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div style='color:black'>{{Form::radio('UnitOfficeHasQuaternary', 'False', true)}} False</div>
                                                </div>
                                        </div>
                                    <div class="form-group">
                                        {{ Form::submit('Update Tertiary Unit Office', array('class' => 'btn btn-lg btn-success')) }}
                                    </div>
                                    </div>
                                    <br><br>
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
<a href="#" onclick="window.opener.location.reload(true); window.close();" style = "margin-bottom:10%" class="btn btn-warning">Close</a>
</div>
@stop

@extends('layout-noheader2')
@section('content')

<div class="label_white">
<h1>Unit Office Secondary Maintenance</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Update a Unit Office Secondary</strong>
    </div>
        <div class="panel-body">
        {{ Form::model($unit_office_secondary, array('method' => 'PATCH', 'route' => array('UnitAdminSecondaryOffice.update', $unit_office_secondary->id))) }}
            <fieldset>

                  {{Form::hidden('unitofficeid',$unitoffice_id)}}
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
                                        <div>{{ Form::label('UnitOfficeSecondaryName', 'Secondary Unit Office Name:') }}</div>
                                        <div style='color:black'>{{ Form::text('UnitOfficeSecondaryName', Input::get('UnitOfficeSecondaryName'), array('placeholder' => 'Unit Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                                    </div>


                                    <div class="form-group">
                                        <div>{{ Form::label('UnitOfficeID', 'Unit Office:') }}</div>
                                      @foreach($unit_offices as $unitofficename)
                                        <div>{{ $unitofficename->UnitOfficeName}}</div>
                                
                                @endforeach
                                    </div>

                                    <div class="form-group">
                                        <div>{{ Form::label('UnitOfficeHasTertiary', 'Unit Office has Field:') }}</div>
                                      
                                            <div class='col-md-6'>
                                                <div style='color:black'>{{Form::radio('UnitOfficeHasTertiary', 'True', true)}} True</div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div style='color:black'>{{Form::radio('UnitOfficeHasTertiary', 'False', true)}} False</div>
                                            </div>
                                        </div>
                                    <br><br>
                                    <div class="form-group">
                                        {{ Form::submit('Update Secondary Unit Office', array('class' => 'btn btn-lg btn-success')) }}
                                    </div>
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
<a href="#" style="margin-bottom:10%" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
</div>
@stop

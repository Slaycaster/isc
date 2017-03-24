 @extends("layout")
@section("content")

<head>
    <title>Sub-activities | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Sub-activities Maintenance</h1>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE RANK-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Sub-activity</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'sub_activities.store')) }}
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
                        <div>{{ Form::label('SubActivityName', 'Sub-activity Name:') }}</div>
                        <div style='color:black'>{{ Form::text('SubActivityName', Input::get('SubActivityName'), array('placeholder' => 'Sub-activity','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('MainActivityID', 'Main Activity:') }}</div>
                        <div style='color:black'> {{ Form::select('MainActivityID', $main_activities_id, Input::old('MainActivityID'), array('class' => 'form-control')) }}</div>
                       
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Create Sub-activity', array('class' => 'btn btn-lg btn-success btn-block')) }}
                    </div>
                  </div>
                </div>
              </fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>

    <!--ALL RANKS-->
    <div class = "col-md-8"> 
      <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>All Sub-activities</strong>
            </div>
            <div class="panel-body table-responsive">
            <table class="table" id='example'>
                <thead>
                    <tr class="filters">       
                        <th>Sub-activity Name</th>
                        <th>Main Activity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <tbody>
                @foreach ($sub_activities as $sub_activity)
                <tr>
                    <td style='color:black'>
                        {{$sub_activity->SubActivityName}} 
                    </td>
                    <td style='color:black'>
                         @foreach ($main_activities as $main_activity)
                            @if ($main_activity->id == $sub_activity->MainActivityID)
                              {{  $main_activity->MainActivityName }}
                            @endif
                          @endforeach
                    </td>

                    <td>
                       <a class = 'btn btn-warning' href="{{ URL::to('sub_activities/' . $sub_activity->id) }}" onclick="window.open('{{ URL::to('sub_activities/' . $sub_activity->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                        <a class = 'btn btn-info'  href="{{ URL::to('sub_activities/' . $sub_activity->id . '/edit') }}" onclick="window.open('{{ URL::to('sub_activities/' . $sub_activity->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                    </td>

                </tr>
                @endforeach
                </tbody>  
            </table>
            </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable();
  } );
    
</script>
@stop
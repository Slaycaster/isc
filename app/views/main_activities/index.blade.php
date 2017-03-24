@extends("layout")
@section("content")
 
<head>
    <title>Main Activities | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Main Activities Maintenance</h1>

</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE MAIN ACTIVITIES-->
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create Main Activities</strong>
          </div>
            <div class="panel-body">
            {{ Form::open(array('route' => 'main_activities.store')) }}
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
                          <div>{{ Form::label('MainActivityName', 'Main Activity Name:') }}</div>
                          <div style='color:black'>{{ Form::text('MainActivityName', Input::get('MainActivityName'), array('placeholder' => 'Activity Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>
     
                        <div class="form-group">
                          {{ Form::submit('Create Main Activities', array('class' => 'btn btn-lg btn-success btn-block')) }}
                        </div>
                  </div>
                </div>
              </fieldset>
          {{ Form::close() }}
            </div>
          </div>
        </div>
  
      <!--ALL ACTIVITIES-->
      <div class="col-md-8">
        <div class="panel panel-primary">
           <div class="panel-heading">
                <strong>All Main Activities</strong>
            </div>
                <div class="panel-body">
            <table class="table" id='example'>
                <thead>
                    <tr class="filters">       
                        <th>Main Activity Names</th>
                      
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($main_activities as $main_activity)
                  <tr>

                    <td style='color:black'>
                        {{$main_activity->MainActivityName}} 
                    </td>

                    <td>
                       <a class = 'btn btn-warning' href="{{ URL::to('main_activities/' . $main_activity->id) }}" onclick="window.open('{{ URL::to('main_activities/' . $main_activity->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                        <a class = 'btn btn-info'  href="{{ URL::to('main_activities/' . $main_activity->id . '/edit') }}" onclick="window.open('{{ URL::to('main_activities/' . $main_activity->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
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

@extends("layout")
@section("content")

<head>
    <title>Assign-objective | PNP Scorecard System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<div class="label_white">
    <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
        <h1>Assign Objectives - {{ $PersonnelName }}</h1>
    </div>
</div>

<div class="container">
  {{ Form::open(array('url' => 'saveupdatepostemployeeobjective', 'method' => 'post')) }}
        <div class='col-md-12'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Choose Perspective/Objective</strong>
                </div>

                {{Form::Hidden('empid',$id)}}

                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-danger">{{ Session::get('message') }}</div>
                    @endif

                    <div class="form-group">             
                        <div class="col-md-12">
                            <div class="col-md-6">
                                  <div>
                                      {{ Form::label('Perspective', 'Perspectives:') }}
                                  </div>
                                  <div style='color:black'>
                                      {{ Form::select('PerspectiveID', $perspectives_id, Input::get('PerspectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'perspectives_id', 'tabindex' => '2')) }}
                                  </div>
                            </div>
                            <div class="col-md-6">
                                  <div>
                                      {{ Form::label('ObjectiveID', 'Objectives:') }}
                                  </div>
                                  <div style='color:black'>
                                      {{ Form::select('ObjectiveID', $objectives_id, Input::get('ObjectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'objectives_id', 'tabindex' => '3')) }}
                                  </div> 
                            </div>
                        </div>

                        <div class="col-md-12">
    {{--
                            <center style="margin-top:3%"> 
                                <a class = 'btn btn-info' href="{{ URL::to('setemployeeobjective/' . $id) }}">Refresh</a> 
                            </center>
    --}}                <br>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

     
        <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong>Assign to Activities:</strong>
                    </div>      
                    <div class="panel-body table-responsive">
                        <table class="table" width="100%">
                            <thead>
                                <tr>*Check the box to assign the sub-activities to selected objective</tr><br>
                                <tr><p style="color:orange;">Note: If you didn't see sub-activities, it means it has already been assigned to an objective.</p></tr>
                                <tr>
                                    <div>{{ Form::label('Main Activity', 'Main Activities:') }}</div>
                                    <div style='color:black'>{{ Form::select('MainActivitiesID', $mainactivities_id, Input::get('MainActivitiesID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'mainactivities_id', 'tabindex' => '2')) }}</div>
                                </tr>
                                <br>
                                <tr>       
                                  <th style="display:none;">Main Activities </th>
                                  <th width="70%">Sub Activities</th>
                                  <th width="30%" style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sub_activities as $sub_activity)
                                    <tr class="a">
                                        <td style="color:black; display:none;" class="AR AR_{{$sub_activity->MainActivityID}}">{{$sub_activity->MainActivityID}}</td>
                                        <td style='color:black' class="AR AR_{{$sub_activity->MainActivityID}}">{{$sub_activity->SubActivityName}}</td>
                                        <td align="center" style='color:black' class="AR AR_{{$sub_activity->MainActivityID}}">{{ Form::checkbox('checkboxid1[]',$sub_activity->id) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                          <br>
                          {{ Form::submit('Save', array('class' => 'btn btn-lg btn-success', 'name' => 'save')) }}
                    </div>
                </div>
        </div>


        <div class="col-md-12">
              <div class="panel panel-info">
                    <div class="panel-heading">
                        <strong>Update to Activities:</strong>
                    </div>      
                    <div class="panel-body table-responsive">
                        <table class="table" width="100%">
                            <thead>
                                <tr>*Check the box to update the sub-activities to selected objective</tr><br>
                                <tr>
                                    <div>{{ Form::label('Main Activity', 'Main Activities:') }}</div>
                                    <div style='color:black'>{{ Form::select('MainActivitiesID', $mainactivities_id, Input::get('MainActivitiesID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'mainactivities_id2', 'tabindex' => '2')) }}</div>
                                </tr>
                                <br>
                                <tr>
                                    <th style="display:none;">Main Activities </th>
                                    <th width="70%">Sub Activities</th>
                                    <th width="30%" style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sub_activities2 as $sub_activity)
                                    <tr class="b">
                                        <td style="color:black; display:none;" class="RA RA_{{$sub_activity->MainActivityID}}">{{$sub_activity->MainActivityID}}</td>
                                        <td style='color:black' class="RA RA_{{$sub_activity->MainActivityID}}">{{$sub_activity->SubActivityName}}</td>
                                        <td align="center" style='color:black' class="RA RA_{{$sub_activity->MainActivityID}}">{{ Form::checkbox('checkboxid2[]',$sub_activity->id) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                          <br>
                          {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary', 'name' => 'update')) }}
                    </div>
                </div>
        </div>
  {{Form::close()}}
</div>



<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  $(document).ready(function()
  {
      $('#perspectives_id').change(function()
      {
           $('#objectives_id').html('');
          var id = $('option:selected').val();
          var emp_id = "<?= $id ?>";
          //alert(id);
          $.ajax({
              type: "POST",
              url: "perspectiveid",
              data: {'perspectiveID' : id,'empid' : emp_id},
              success: function(data){
                console.log(data);
                var arr = data ;
                var i;
                var select = document.getElementById("objectives_id");
                for(i = 0; i < arr.length; i++) 
                {
                    var option = document.createElement('option');
                    option.value = arr[i].id;
                    option.text = arr[i].ObjectiveName;
                    select.add(option, i);
                }
              }
          })
      });
  });

</script>



<script type="text/javascript">

$("#mainactivities_id").on('change', function () {
        var year = $("#mainactivities_id").val();
        $('tr.a').hide();
        $("td.AR").each(function (index, tdAR) {
            if ($(tdAR).hasClass("AR_" + year)) 
            {
                $(tdAR).parent('tr').show();
            }
        });
    });


$("#mainactivities_id2").on('change', function () {
        var year = $("#mainactivities_id2").val();
        $('tr.b').hide();
        $("td.RA").each(function (index, tdRA) {
            if ($(tdRA).hasClass("RA_" + year)) 
            {
                $(tdRA).parent('tr').show();
            }
        });
    });

</script>


@stop


@extends("layout")
@section("content")

<head>
    <title>Unit Admin | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Unit Admin Maintenance</h1>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE Objective-->

    <div class = "col-md-4">

    <div class='col-md-12'>
<div class="panel panel-default">
            {{ Form::open(array('route' => 'unit_admins.store')) }}
          <div class="panel-heading">
            <strong>Choose Unit/Office</strong>
          </div>
       <div class="form-group" style='margin-left:10%'> 
            <div class='col-md-8' style='margin-left:-5%'>
                        <div>{{ Form::label('UnitOfficeID', 'Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id, Input::get('UnitOfficeID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>
            </div>
                        <div>{{ Form::label('UnitOfficeSecondaryID', 'Secondary Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $unit_offices_secondaries_id, Input::get('UnitOfficeSecondaryID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '3')) }}</div>

             </div>
</div>
</div>
<br>
<div class="col-md-12" style="margin-bottom:5%">

      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create Unit Admin</strong>
          </div>
          <div class="panel-body">
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
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                      @endif
                      @if (Session::has('message2'))
                        <div class="alert alert-danger">{{ Session::get('message2') }}</div>
                      @endif

                    <div class="form-group"> 
                        <div>{{ Form::label('RankID', 'Rank:') }}</div>
                        <div style='color:black'>{{ Form::select('RankID', $ranks_id, Input::old('RankID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
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
                        <div style='color:black'>{{ Form::text('UserName', Input::get('UserName'), array('placeholder' => 'User Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('Password', 'Password:') }}</div>
                        <div style='color:black'>{{ Form::text('Password', Input::get('Password'), array('placeholder' => 'Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                     <div class="form-group">
                        <div>{{ Form::label('AdminEmail', 'Email:') }}</div>
                        <div style='color:black'>{{ Form::text('AdminEmail', Input::get('AdminEmail'), array('placeholder' => 'email','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    {{Form::hidden('state', 'Enable')}}

                    <div class="form-group">
                      {{ Form::submit('Create Unit Admin', array('class' => 'btn btn-lg btn-success btn-block')) }}
                    </div>
                  </div>
                </div>
              </fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>
</div>

    <div class = "col-md-8">
      <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>All Unit Admin</strong>
            </div>

            <div class="panel-body table-responsive">
              <table class="table" id="unitAdmin-table">
                <thead>
                    <tr class="filters">       
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Unit/Office</th>
                        <th>Secondary Unit/Office</th>
                        <th>Actions</th>
                    </tr>
                </thead>  
            </table>
            </div>
           
        </div>
    </div>
  </div>
</div>
</div>
<!--
<script type="text/javascript">

$('#unitid').on('change', function(e){
    $(this).closest('form').submit();
});


$('#unitid2').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
-->

<script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  $(document).ready(function()
  {
      //Unit Office dropdown
      $('#unitid').change(function()
      {
          $('#unitid2').html('');
          var id = $("option:selected").val();
          console.log(id);
          if (id != '0') {
        
          $.ajax({
              type: "POST",
              url: "unit_admins/tempIndex",
              data: {'UnitOfficeID' : id},
              success: function(data)
              {
                  var arr = data ;
                  var i;
                  var select = document.getElementById("unitid2");
                  for(i = 0; i < arr.length; i++)
                  {
                      var option = document.createElement('option');
                      option.value = arr[i].id;
                      option.text = arr[i].UnitOfficeSecondaryName;
                      select.add(option, i);
                  }
                  $('#unitid2').prepend('<option value="' + 0 + '">' + 'Select Secondary Unit Office' + '</option>');
                }

            })
        }
        });
        
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#unitAdmin-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: 'unit_admins/indexdatatable',
          columns: 
          [
              { data: 'LastName', name: 'LastName' },
              { data: 'FirstName', name: 'FirstName' },
              { data: 'UnitOfficeName', name: 'UnitOfficeName' },
              { data: 'UnitOfficeSecondaryName', name: 'UnitOfficeSecondaryName' },
              { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
          ]
      });
  });
</script>
@stop
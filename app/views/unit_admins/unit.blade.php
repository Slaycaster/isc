@extends("layout-noheader")

@section("content")



<head>

    <title>Unit Admin | PNP Scorecard System</title>

</head>



<div class="container" style="margin-top:3%">

<div class="row">

<div class="col-md-2"></div>

<div class='col-md-8'>

<div class="panel panel-primary">

          <div class="panel-heading" style="margin-bottom:3%">

              {{ Form::open(array('url' => 'unit_admins/saveunit', 'method' => 'post')) }}
            <strong>Choose Unit Office</strong>

          </div>

       <div class="form-group" style='margin-left:10%'> 
            <div class='col-md-8' style='margin-left:-5%'>
                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                    {{Form::hidden('UnitAdminID', $unit_admin_id)}}
                        <div>{{ Form::label('UnitOfficeID', 'Unit Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id, Input::get('UnitOfficeID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>
            </div>
                        <div>{{ Form::label('UnitOfficeSecondaryID', 'Secondary Unit Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $unit_offices_secondaries_id, Input::get('UnitOfficeSecondaryID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '3')) }}</div>             



                    </div> 
              <div class='form-group' style='margin-left:10%'>

                  {{Form::hidden('UnitAdminID', $unit_admin_id)}}  
                  
  
                  {{ Form::submit('Save Unit Office', array('class' => 'btn btn-success')) }}
              {{ Form::close() }}

              

              </div>

             </div>

<div class="col-md-2"></div>

 <div class="col-md-12">

     <div class='col-md-4' style="margin-bottom:5px">

                 

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
          var id = $('option:selected').val();
          var unit_admin_id = "<?= $unit_admin_id ?>";

           if (id != '0') {

          $.ajax({
              type: "POST",
              url: "temp",
              data: {'unitOfficeID' : id, 'unitAdminID' : unit_admin_id},
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

@stop
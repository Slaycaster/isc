@extends("layout-noheader")

@section("content")



<head>

    <title>Employees | PNP Scorecard System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>



<div class="container" style="margin-top:3%">

<div class="row">

<div class="col-md-2"></div>

<div class='col-md-8'>

<div class="panel panel-primary">

          <div class="panel-heading" style="margin-bottom:3%">

            <strong>Choose Unit Office</strong>

          </div>

       <div class="form-group" style='margin-left:10%'> 

            <div class='col-md-8' style='margin-left:-5%'>


              {{ Form::open(array('url' => 'employee/saveunit', 'method' => 'post')) }}

            

                      
                        <div>{{ Form::label('UnitOfficeID', 'Unit Office:') }}</div>

                        <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id, Input::get('UnitOfficeID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>



              

              </div>

             

           

                   

                         <div>{{ Form::label('UnitOfficeSecondaryID', 'Secondary Unit Office:') }}</div>

                        <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $unit_offices_secondaries_id, Input::get('UnitOfficeSecondaryID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '3')) }}</div>

            

                   

                         <div>{{ Form::label('UnitOfficeTertiaryID', 'Tertiary Unit Office:') }}</div>

                        <div style='color:black'>{{ Form::select('UnitOfficeTertiaryID', $unit_offices_tertiaries_id, Input::get('UnitOfficeTertiaryID'), array('class' => 'btn btn-default dropdown-toggle form-control', 'id' => 'unitid3', 'tabindex' => '4')) }}</div>

        

                       

                         <div>{{ Form::label('UnitOfficeQuaternaryID', 'Quatenary Unit Office:') }}</div>

                        <div style='color:black'>{{ Form::select('UnitOfficeQuaternaryID', $unit_offices_quaternaries_id, Input::get('UnitOfficeQuaternaryID'), array('class' => 'btn btn-default dropdown-toggle form-control', 'id' => 'unitid4', 'tabindex' => '5')) }}</div>

            
                    </div>

                     




            <div class='form-group' style='margin-left:10%'>


               {{Form::hidden('EmpID', $emp_id)}}  



  

              {{ Form::submit('Save Unit Office', array('class' => 'btn btn-success')) }}

              {{ Form::close() }}

              

            </div>

             </div>

<div class="col-md-2"></div>

 
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



$('#unitid3').on('change', function(e){

    $(this).closest('form').submit();

});



$('#unitid4').on('change', function(e){

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
          $('#unitid3').html('');
          $('#unitid4').html('');


          var id = $('option:selected').val();

        if (id != '0') {  
          $.ajax({
              type: "POST",
              url: "primary",
              data: {'officeID' : id},
              success: function(data){
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

      //Secondary Unit office dropdown

      $('#unitid2').change(function()
      {
          $('#unitid3').html('');
          $('#unitid4').html('');

          var id2 = $('#unitid2 option:selected').val();
        if (id2 != '0') {   
          $.ajax({
              type: "POST",
              url: "secondary",
              data: {'officeID2' : id2},
              success: function(data){
                var arr = data ;
                var i;
                var select = document.getElementById("unitid3");
                for(i = 0; i < arr.length; i++) 
                {
                    var option = document.createElement('option');
                    option.value = arr[i].id;
                    option.text = arr[i].UnitOfficeTertiaryName;
                    select.add(option, i);
                }
                $('#unitid3').prepend('<option value="' + 0 + '">' + 'Select Tertiary Unit Office' + '</option>');
              }

          })
        }
      });

      //Tertiary Unit office dropdown

      $('#unitid3').change(function()
      {
        
          $('#unitid4').html('');

          var id3 = $('#unitid3 option:selected').val();
        if (id3 != '0') {  
          $.ajax({
              type: "POST",
              url: "tertiary",
              data: {'officeID3' : id3},
              success: function(data){
                var arr = data ;
                var i;
                var select = document.getElementById("unitid4");
                for(i = 0; i < arr.length; i++) 
                {
                    var option = document.createElement('option');
                    option.value = arr[i].id;
                    option.text = arr[i].UnitOfficeQuaternaryName;
                    select.add(option, i);
                }
                $('#unitid4').prepend('<option value="' + 0 + '">' + 'Select Quaternary Unit Office' + '</option>');
              }

          })
        }
      });


  });

</script>



@stop
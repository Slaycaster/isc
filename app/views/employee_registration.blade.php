@extends("layout-noheader3")
@section("content")

<head>
    <title>Personnel | PNP Scorecard System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 50;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 75px;
  }

  
  </style>
</head>




<div class="container">
  
<div class="row">
<div class="col-md-1"></div>
    <!--CREATE MAIN ACTIVITIES-->
<div class="col-md-11">
<div class='col-md-4' style="margin-top:2%">
<div class="panel panel-default">
          <div class="panel-heading">
            <strong>e-PGS REGISTRATION</strong>
          </div>
       <div class="form-group" style='margin-left:10%'> 
            <div class='col-md-12' style='margin-left:-3%'>
       
         
            {{ Form::open(array('url' => 'registration/store','method' => 'post', 'files' => true)) }}
                      
                        <div>{{ Form::label('UnitOfficeID', '*Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id, Input::get('UnitOfficeID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>

              </div>
            
            
                  
                         <div>{{ Form::label('UnitOfficeSecondaryID', '*Secondary Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $unit_offices_secondaries_id, Input::get('UnitOfficeSecondaryID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '3')) }}</div>
             
            
             
                         <div>{{ Form::label('UnitOfficeTertiaryID', '*Tertiary Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeTertiaryID', $unit_offices_tertiaries_id, Input::get('UnitOfficeTertiaryID'), array('class' => 'btn btn-default dropdown-toggle form-control', 'id' => 'unitid3', 'tabindex' => '4')) }}</div>
         
             
                   
                         <div>{{ Form::label('UnitOfficeQuaternaryID', '*Quatenary Unit/Office:') }}</div>
                        <div style='color:black'>{{ Form::select('UnitOfficeQuaternaryID', $unit_offices_quaternaries_id, Input::get('UnitOfficeQuaternaryID'), array('class' => 'btn btn-default dropdown-toggle form-control', 'id' => 'unitid4', 'tabindex' => '5')) }}</div>
                    </div>
             

               
            
             </div>
</div>
<br>
<div class="col-md-6" style='margin-bottom:60px'>
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Add Your Information</strong>
          </div>

            <div class="table-responsive">

            <div class="panel-body">
             @if (Session::has('email-error'))

                   <div class="alert alert-danger">{{ Session::get('email-error') }}</div>

             @endif
                  <p>*Select Unit Office before inputing personnel information</p>
                  <p style="color:orange"><b>All fields with * are required to fill-up</b></p>
           
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
                          <div>{{ Form::label('BadgeNo', '*Badge Number/Plantilla:') }}</div>
                          <div style='color:black'>{{ Form::text('BadgeNo', Input::get('BadgeNo'), array('placeholder' => 'Badge Number/Plantilla','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

  
                        <div class="form-group"> 
                          <div>{{ Form::label('EmpLastName', '*Last Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpLastName', Input::get('EmpLastName'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpFirstName', '*First Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpFirstName', Input::get('EmpFirstName'), array('placeholder' => 'First Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpMidInit', 'Middle Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpMidInit', Input::get('EmpMidInit'), array('placeholder' => 'Middle Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpQualifier', 'Qualifier:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpQualifier', Input::get('EmpQualifier'), array('placeholder' => 'Ex: Sr., Jr., III','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group">
                          <div>{{ Form::label('EmpPicturePath', 'Select Profile Picture:') }}</div>
                          <div>{{ Form::file('EmpPicturePath') }}</div>
                          
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpID', '*Username:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpID', Input::get('EmpID'), array('placeholder' => 'Username','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>


                        <div class="form-group"> 
                          <div>{{ Form::label('email', '*Email:') }}</div>
                          <div style='color:black'>{{ Form::text('email', Input::get('email'), array('placeholder' => 'pnp@gmail.com','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group">
                             
                            <div>{{ Form::label('RankID', '*Rank:') }}</div>
                            <div style='color:black'>{{ Form::select('RankID', $ranks_id, Input::old('RankID'), array('id' => 'combobox')) }}</div>
                            
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('PositionID', '*Position:') }}</div>
                        <div style='color:black'>{{ Form::select('PositionID', $positions_id, Input::old('PositionID'), array('id' => 'combobox2')) }}</div>
                        </div>




                        <div class="form-group"> 
                              <div>{{ Form::label('SupervisorID', '*Supervisor:') }}</div>
                              <div style='color:black'> {{ Form::select('SupervisorID', $supervisors, Input::old('SupervisorID'), array('class' => 'btn btn-default dropdown-toggle', 'style' => 'width: 300px', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'SupervisorID')) }}</div>
                        </div>
                        <div class="form-group">
                           <div class="col-md-2">
                            <div>{{ Form::checkbox('OwnSupervisorID', 'true') }}</div></div>
                             <div class="col-md-10">
                            <div>{{ Form::label('SupervisorID', "I'm the supervisor myself") }}</div></div><br><br>
                        </div>

                          </div>
                          <br><br>
                        <div class='col-md-3'></div>
                        <div class='col-md-5'>
                        <div class="form-group">
                          {{ Form::submit('Register', array('class' => 'btn btn-lg btn-success btn-block')) }}
                        </div>
                        
                        </div>
                  </div>
                </div>
              </fieldset>
          {{ Form::close() }}

            

          
          </div>
        </div>
      </div>
</div>
      <!--ALL ACTIVITIES-->
   
    </div>
  </div>
</div>



<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchable1").searchable({
      ignoreCase: true
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchable2").searchable({
      ignoreCase: true
      });
  });
</script>

<script type="text/javascript">
 

  $(function() {
    $( "#combobox" ).combobox();
    $("#combobox2").combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
</script>

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



<script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $(  "<button> <span class='glyphicon glyphicon-arrow-down' </button>"  )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-2-n-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete("widget").is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  
  </script>

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

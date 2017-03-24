@extends("layout-noheader")
@section("content")
 
<head>
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
    padding: 5px 20px;
  }

  
  </style>
</head>

<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Update Personnel</strong>
  </div>
  <div class="panel-body">
{{ Form::model($employee, array('method' => 'PATCH', 'route' => array('employs.update', $employee->id), 'files' => true)) }}
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
                        @if (Session::has('message'))

                              <div class="alert alert-danger">{{ Session::get('message') }}</div>

                          @endif
                      </div>
                    </div>
                        <div class="form-group">
                            
                        </div>
                         <div class="form-group"> 
                          <div>{{ Form::label('BadgeNo', 'Badge Number:') }}</div>
                          <div style='color:black'>{{ Form::text('BadgeNo', Input::get('BadgeNo'), array('placeholder' => 'Badge Number','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpLastName', 'Last Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpLastName', Input::get('EmpLastName'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpFirstName', 'First Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpFirstName', Input::get('EmpFirstName'), array('placeholder' => 'First Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                          <div class="form-group"> 
                          <div>{{ Form::label('EmpMidInit', ' Middle Name:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpMidInit', Input::get('EmpMidInit'), array('placeholder' => ' Middle Initial','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpQualifier', 'Qualifier:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpQualifier', Input::get('EmpQualifier'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                         <div class="form-group"> 
                          <div>{{ Form::label('EmpID', 'Username:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpID', Input::get('EmpID'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group"> 
                          <div>{{ Form::label('EmpPassword', 'Password:') }}</div>
                          <div style='color:black'>{{ Form::text('EmpPassword', Input::get('EmpPassword'), array('placeholder' => 'Qualifier','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>



                        <div class="form-group"> 
                          <div>{{ Form::label('email', 'Email:') }}</div>
                          <div style='color:black'>{{ Form::text('email', Input::get('email'), array('placeholder' => 'pnp@gmail.com','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group">
                          <div>{{ Form::label('EmpPicturePath', 'Select Profile Picture:') }}</div>
                          <div>{{ Form::file('EmpPicturePath') }}</div>
                          <div>{{ Form::hidden('picture_path',$employee->EmpPicturePath) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('RankID', 'Rank:') }}</div>
                        <div style='color:black'>{{ Form::select('RankID', $ranks_id, Input::old('RankID'), array('class' => 'btn btn-default', 'id' => 'combobox')) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('PositionID', 'Position:') }}</div>
                        <div style='color:black'>{{ Form::select('PositionID', $positions_id, Input::old('PositionID'), array('class' => 'btn btn-default', 'id' => 'combobox2')) }}</div>
                        </div>

                        <div class="form-group"> 
                        <div>{{ Form::label('SupervisorID', 'Supervisor:') }}</div>
                        <div style='color:black'>{{ Form::select('SupervisorID', $supervisors, Input::old('SupervisorID'), array('class' => 'btn btn-default', 'id' => 'searchable3')) }}</div>
                        </div>
     
                        <div class="form-group">
                          {{ Form::submit('Submit', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
</div>
<a href="#" onclick="window.close();" class="btn btn-warning">Close</a>
<!--
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
  $(document).ready(function() {
    $("#searchable3").searchable({
      ignoreCase: true
      });
  });
</script>
-->

<script type="text/javascript">
 

  $(function() {
    $( "#combobox" ).combobox();
    $("#combobox2").combobox();
    $("#combobox3").combobox();
  });
</script>





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
 
        $( "<button> <span class='glyphicon glyphicon-arrow-down' </button>" )
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

@stop

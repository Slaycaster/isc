@extends("layout")
@section("content")

<head>
    <title>Perspective | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Perspective Maintenance</h1>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE Perspective-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Perspective</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'perspectives.store')) }}
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
                        <div>{{ Form::label('PerspectiveName', 'Perspective Name:') }}</div>
                        <div style='color:black'>{{ Form::text('PerspectiveName', Input::get('PerspectiveName'), array('placeholder' => 'Perspective Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Create Perspective Name', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
                <strong>All Perspective</strong>
            </div>

            <div class="panel-body">
              <table class="table" id="example">
                <thead>
                    <tr class="filters">       
                        <th><input type="text" class="form-control" placeholder="Perspective Name"></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($perspectives as $perspective)
                <tr>
                    <td style='color:black'>
                        {{$perspective->PerspectiveName}}
                    </td>

                    <td>
                       <a class = 'btn btn-warning' href="{{ URL::to('perspectives/' . $perspective->id) }}" onclick="window.open('{{ URL::to('perspectives/' . $perspective->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                        <a class = 'btn btn-info'  href="{{ URL::to('perspectives/' . $perspective->id . '/edit') }}" onclick="window.open('{{ URL::to('perspectives/' . $perspective->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
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
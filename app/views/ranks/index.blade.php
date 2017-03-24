@extends("layout")
@section("content")

<head>
    <title>Ranks | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Rank Maintenance</h1>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE RANK-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Rank</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'ranks.store')) }}
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
                        <div>{{ Form::label('RankCode', 'Rank Code:') }}</div>
                        <div style='color:black'>{{ Form::text('RankCode', Input::get('RankCode'), array('placeholder' => 'Rank Code','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('RankName', 'Rank Name:') }}</div>
                        <div style='color:black'>{{ Form::text('RankName', Input::get('RankName'), array('placeholder' => 'Rank Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('Hierarchy', 'Hierarchy (1 being the highest)') }}</div>
                        <div style='color:black'>{{ Form::number('Hierarchy', Input::get('Hierarchy'), array('placeholder' => 'ex: 1, 2, etc.', 'autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Create Rank', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
                  <strong>All Ranks</strong>
              </div>
             <div class="panel-body">
              <table class="table" id="example">
                  <thead>
                      <tr class="filters">       
                          <th>Rank Code</th>
                          <th>Rank Name</th>
                          <th>Hierarchy</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach ($ranks as $rank)
                        <tr>

                            <td style='color:black'>
                                {{$rank->RankCode}} 
                            </td>
                            <td style='color:black'>
                                {{$rank->RankName}}
                            </td>
                            <td style='color:black'>
                                {{$rank->Hierarchy}}
                            </td>

                            <td>
                               <a class = 'btn btn-warning' href="{{ URL::to('ranks/' . $rank->id) }}" onclick="window.open('{{ URL::to('ranks/' . $rank->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                                <a class = 'btn btn-info'  href="{{ URL::to('ranks/' . $rank->id . '/edit') }}" onclick="window.open('{{ URL::to('ranks/' . $rank->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
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
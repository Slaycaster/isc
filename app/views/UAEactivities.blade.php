@extends("layout-unitadmin")

@section("content")

<head>

    <title>Personnel Activities (Unit Office) | PNP Scorecard System</title>

</head>



<div class="container">

  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">
    <br>
      <center>
        <div class="text_paragraph">
          <p style="font-size: 30px"><strong>Set Personnel Activities - {{ $OfficeName }}</strong> </p>
        </div>
      </center>
    <hr>
  </div>


  <div class = "col-md-12">

      <div class="panel panel-default">

          <div class="panel-heading">

            <strong>Select Personnel (Unit Office)</strong>

            </div>

            <div class="panel-body">
            @if (Session::has('message'))
              <div class="alert alert-success">{{ Session::get('message') }}</div><br>
          @endif

          {{ Form::open(array('target' => '_blank', 'url' => 'reportsadmin', 'method' => 'get')) }}

              <h4>Personnels (under this Unit Office)</h4><hr>

              

                <fieldset>

                    <div class="form-group">

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong>Select Employee</strong>

                      </div>

                       <div class="panel-body table-responsive">

                        <table class="table" id="personnels-table" width="100%">

                          <thead>

                              <tr>       
                                  <th width="10%">Rank</th>

                                  <th width="13%">Last Name</th>

                                  <th width="12%">First Name</th>

                                  <th width="15%">Add Activities</th>

                                  <th width="15%">Edit Activities</th>

                                  <th width="20%">Delete Activities</th>

                                  <th width="15%">Assign Objectives</th>

                              </tr>

                          </thead>

                      </table>

                       </div>

                      

                  </div>

                      </div>



                      



                  

                </fieldset>

              {{ Form::close() }}

                {{ Form::open(array('url' => 'postUAremovescorecard', 'method' => 'post')) }}

                               <div class="modal" id="my_modal">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <h4 class="modal-title">Remove Current Scorecard</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p>Are you sure you want to delete this personnel's scorecard for this week?</p>
                                            <input type="hidden" name="empid" value=""/>
                                          </div>
                                          <div class="modal-footer">
                                            <input type="submit" value = "Confirm" class="btn btn-success"></input>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
              {{Form::close()}}


          </div>

        </div>

    </div>

</div>



<script type="text/javascript">

   $('#my_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('input[name="empid"]').val(bookId);
});

</script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#personnels-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: 'UAEactivities/tempdatatable',
          columns: 
          [
              { data: 'RankCode', name: 'Rank' },
              { data: 'LastName', name: 'LastName' },
              { data: 'FirstName', name: 'FirstName' },
              { data: 'Add Activities', name: 'Add Activities', orderable: false, searchable: false},
              { data: 'Edit Activities', name: 'Edit Activities', orderable: false, searchable: false},
              { data: 'Delete Activities', name: 'Delete Activities', orderable: false, searchable: false},
              { data: 'Assign Objectives', name: 'Assign Objectives', orderable: false, searchable: false}
          ]
      });
  });
</script>

@stop
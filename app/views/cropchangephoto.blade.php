@extends("layout-employee")
@section("content")

<head>
    <title>Employee Crop Photo | PNP Scorecard System</title>
</head>


<div class="container" style="width:500px; margin-top:100px;">
    <div class="row">
      <div class="col-md-9">
        <!-- <h3 class="page-header">Demo:</h3> -->
        <div class="img-container">
          <img src="{{ URL::asset($fn->EmpPicturePath) }}" alt="Picture">

          
        </div>
      </div>
      <div class="col-md-3">
        <!-- <h3 class="page-header">Preview:</h3> -->
      

        <!-- <h3 class="page-header">Data:</h3> -->
        
      </div>
    </div>
    <div class="row" id="actions">
      <div class="col-md-9 docs-buttons">
        <!-- <h3 class="page-header">Toolbar:</h3> -->
       

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
              <span class="fa fa-rotate-left"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
              <span class="fa fa-rotate-right"></span>
            </span>
          </button>
        </div>

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-flip="horizontal" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
              <span class="fa fa-arrows-h"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-flip="vertical" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
          </button>
        </div>

        

    


        <div class="btn-group btn-group-crop">
          <button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas()">
              Save Photo
            </span>
          </button>
         
        </div>

        <!-- Show the cropped image in modal -->
        <div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" id="download" href="javascript:void(0);" >Download</a>
                <a class="btn btn-primary" id="download" href="javascript:void(0);">Save</a>
              </div>
            </div>
          </div>
        </div><!-- /.modal -->

        
     
        
       
        
        
     
       

      </div><!-- /.docs-buttons -->

      <div class="col-md-3 docs-toggles">
        <!-- <h3 class="page-header">Toggles:</h3> -->
        

        

      
      </div><!-- /.docs-toggles -->
    </div>
  </div>
<script type="text/javascript">var emp_id = "<?= $id ?>";</script>
<script type="text/javascript" src="main2.js"></script>
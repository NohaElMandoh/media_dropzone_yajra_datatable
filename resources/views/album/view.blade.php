@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<style>
  .dropzoneDragArea {
    background-color: #fbfdff;
    border: 1px dashed #c0ccda;
    border-radius: 6px;
    padding: 60px;
    text-align: center;
    margin-bottom: 15px;
    cursor: pointer;
  }

  .dropzone {
    box-shadow: 0px 2px 20px 0px #f2f2f2;
    border-radius: 10px;
  }
</style>
@endsection
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Albums
          <a class="btn btn-primary" href="{{route('album.index')}}" role="button">all</a>

        </div>
        <div class="card-body">

          <div class="form-group">

            <form method="post" action="{{route('media.upload')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
              @csrf
              <input type="hidden" value="{{$album_id}}" id='album_id' name='album_id'>
            </form>

          </div>
          <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Uploaded Image</h3>
        </div>
        <div class="panel-body" id="uploaded_image">
          
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{route("media.delete")}}',
                    data: {filename: name,"_token": "{{ csrf_token() }}",},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                        load_images();
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
                console.log(response);
                load_images();
            },
            error: function(file, response)
            {
               return false;
            }
};

$(document).ready(function(){
  load_images();
});
function load_images()
{
  var album_id=$('#album_id').val();
  $.ajax({
 
    url:"{{ route('media.fetch') }}" + '?id=' + album_id,
    success:function(data)
    {
      $('#uploaded_image').html(data);
    }
  })
}

$(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"{{ route('media.delete') }}",
      type: 'POST',
      data: {filename: name,"_token": "{{ csrf_token() }}",},
     
      success:function(data){
        load_images();
      }
    })
  });
</script>

@endsection

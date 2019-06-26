<div id="my_upload">

    @if($upload_type != 'profile')
        <div class="heading-layout1">
            <div class="item-title">
                <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                <h3>@if($upload_type === 'routine')
                        Class {{ucfirst($upload_type)}}
                    @else
                        {{ucfirst($upload_type)}}
                    @endif</h3>
            </div>
        </div>
        <label>File Title: </label>
        <div class="form-group">
            <input type="text" name="upload-title" id="upload-title" placeholder="File title here..." required class="form-control">
        </div>
    @endif

    <div class="form-group mg-t-30 mb-5">
        <input id="fileupload" type="file"  accept=".xlsx,.xls,.doc,.docx,.ppt,.pptx,.txt,.pdf,image/png,image/jpeg" name="file" data-url="{{url('upload/file')}}" class="form-control-file">
    </div>
  <div class="progress">
    <div class="progress-bar progress-bar-striped active" id="up-prog-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
      <div class="text-xs-center" id="up-prog-info">0% uploaded</div>
    </div>
  </div>
  <div id="errorAlert"></div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.4/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.4/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.21.0/js/vendor/jquery.ui.widget.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.21.0/js/jquery.iframe-transport.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.2/jquery.fileupload.min.js"></script>
<script>
$(function () {
    var jqXHR = null;
    var uploadButton = $('<button/>')
            .addClass('btn btn-primary ml-5 mt-2 btn-lg')
            .text('Upload')
            .on('click', function () {
                @if($upload_type != 'profile')
                    if(!$('#upload-title').val()){
                        swal({
                            title:'File needs a Title',
                            type:'info',
                            showCloseButton: true,
                        });
                        return false;
                    }
                @endif
                var $this = $(this),
                    data = $this.data();
                $('#fileupload').hide();
                    var acceptFileTypes = /application\/(pdf|xlsx|xls|doc|docx|ppt|pptx|txt)|image\/(png|jpeg)$/i;
                    var filesSize = 50 * 1024 * 1024;
                    var file = data.originalFiles[0];
                    console.log(file['type']);

                    if(file['type'].length && !acceptFileTypes.test(file['type'])) {
                        $('#fileupload').show();
                        swal('Not an accepted file type');
                        $this.remove();
                        return false;
                    } else if(file.size > filesSize) {
                        swal('Filesize is too big \n Should not exceed ' + filesSize + 'MB');
                        $this.remove();
                        return false;
                    }else {
                        $('#up-prog-info').text("Uploading");
                        $this.off('click').text('Abort').on('click', function () {
                            $this.remove();
                            data.abort();
                            data.context.text('File Upload has been canceled');
                        });
                        @if($upload_type != 'profile')
                            data.formData = {upload_type: '{{$upload_type}}',section_id : '{{ $section_id }}',title: $('#upload-title').val()};
                        @else
                            data.formData = {upload_type: '{{$upload_type}}',user_id: $('#userIdPic').val()};
                        @endif
                        data.submit().always(function () {
                            $this.remove();
                        });
                    }
            });
    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e, data) {
            console.log(data);
            var file = data.originalFiles[0];
            console.log(file);
            if (file) {
                $('#fileInfo').remove();
                        data.context = $('<div/>').attr('id', 'fileInfo').appendTo('#my_upload');
                        var node = $('<p/>')
                            .append($('<span/>').text(file.name)).append(uploadButton.clone(true).data(data));
                        node.appendTo(data.context);
            }
        },
        progress: function (e, data) {
            var progress = 0;
            progress = parseInt(data.loaded / data.total * 100, 10);
            console.log('progress'+progress);
                $('.progress-bar').attr(
                    'aria-valuenow',
                    progress
                ).css('width', progress + '%', 'height', 20);
                $('#up-prog-info').text(progress + "% uploaded");
        }
    })
    .on('fileuploaddone', function (e, data) {
        var error = data['jqXHR']['responseJSON']['error'];
        var imgUrlpath = data['jqXHR']['responseJSON']['imgUrlpath'];
        var path = data['jqXHR']['responseJSON']['path'];
        if(error) {
            $('#errorAlert').text(error);
        } else {
            data.context.html('<div>Upload finished.</div>');
            window.location.reload();
            $('button.cancelBtn').hide();
            $('#errorAlert').empty();
            @if($upload_type == 'profile')
            $('#picPath').val(path);
            $('#my-profile').attr('src', imgUrlpath);
            @endif
        }
    })
    .on('fileuploadfail', function (e, data) {
            data.context.text('File Upload has been cancelled');
            var error = data['jqXHR']['responseJSON']['error'];
            $('#errorAlert').text(error);
            console.log(data['jqXHR']['responseJSON']);
    });
});
{{--

function upload(file) {
  var BYTES_PER_CHUNK = parseInt(2097152, 10),
  size = file.size,
  NUM_CHUNKS = Math.max(Math.ceil(SIZE / BYTES_PER_CHUNK), 1),
  start = 0, end = BYTES_PER_CHUNK, num = 1;

  var chunkUpload = function(blob) {
    var fd = new FormData();
    var xhr = new XMLHttpRequest();

    fd.append('upload', blob, file.name);
    fd.append('num', num);
    fd.append('num_chunks', NUM_CHUNKS);
    xhr.open('POST', '/somedir/upload.php', true);
    xhr.send(fd);
  }

  while (start < size) {
    chunkUpload(file.slice(start, end));
    start = end;
    end = start + BYTES_PER_CHUNK;
    num++;
  }
}
--}}
</script>

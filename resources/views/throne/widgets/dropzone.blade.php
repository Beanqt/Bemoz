<div class="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</div>
<br>
<script>
    $('.dropzone').dropzone({
        url: '{{$url}}',
        method: 'post',
        paramName: "file",
        maxFilesize: 100,
        addRemoveLinks: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 100,
        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i> @lang('admin.dropzone.upload')',
        dictResponseError: 'Server not Configured',

        init : function() {
            var myDropzone = this;

            this.on("success", function(files, response) {
                response = JSON.parse(response);
                myDropzone.removeFile(files);
                $('.fileContent').append(response.content);
            });
        }
    });
</script>
@extends('admin.layouts.app')

@section('content')

    @php
        if(isset($tag)){
            $url = route('admin.tags.update',['id'=>$tag->id]);
        }else{
            $url = route('admin.tags.store');
        }
    @endphp
    <div class="card ">
        <div class="card-header">
            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.tags')}}">Tags</a></h4>
            <h4 class="font-weight-bolder d-inline-block"> / {{isset($tag) ? "Edit" : "Create" }} Tag</h4>
        </div>
        <div class="card-body">

            <form role="form" action="{{$url}}" method="POST" id="tagForm">
                @csrf
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{isset($tag) ? $tag->name : ""}}">
                </div>

                <div class="input-group input-group-static mb-4 ">
                    <label for="exampleFormControlSelect1" class="ms-0">Parent</label>
                    <select class="form-control" name="parent">
                        <option value="" selected>Select A Parent</option>
                        @foreach($tags as $_tag)
                            @if(isset($tag))
                                @if( $_tag->id!=$tag->id)
                                    <option value="{{$_tag->id}}" {{isset($tag) && $tag->parent_id == $_tag->id ? "selected" : ""}}>{{$_tag->name}}</option>
                                @endif

                            @else
                                <option value="{{$_tag->id}}" {{isset($tag) && $tag->parent_id == $_tag->id ? "selected" : ""}}>{{$_tag->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="document">Photo</label>
                    <div class="needsclick dropzone" id="document-dropzone">

                    </div>
                </div>

                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Save
                    </button>
                    <a href="{{ route('admin.tags') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var uploadedDocumentMap = {};
        var myDropzone;

        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.tags.storePhoto') }}',
            method: 'post',
            maxFilesize: 2,
            acceptedFiles: 'image/svg+xml',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            maxFiles: 1,
            autoProcessQueue: false,
            init: function () {
                myDropzone = this;

                @php
                    if(isset($tag)){
                        $filePath = public_path($tag->file);
                        $fileSizeInBytes = file_exists($filePath) ? filesize($filePath) : 0;
                        $fileSizeInMB = round($fileSizeInBytes / (1024 * 1024), 1);
                    }
                @endphp

                @if(isset($tag) && $tag->file != null)
                var mockFile = { name: "{{ $tag->file }}", size: {{ $fileSizeInMB }} };
                myDropzone.emit('addedfile', mockFile);
                myDropzone.emit('thumbnail', mockFile, "{{ asset($tag->file) }}");

                var fileSizeText = $("[data-dz-size]").text();
                var fileSizeInMB = fileSizeText.replace("b", "MB");
                $("[data-dz-size]").text(fileSizeInMB);
                uploadedDocumentMap[mockFile.name] = "{{ $tag->file }}";

                var tag_file = "{{$tag->file}}";

                $('#tagForm').append('<input type="hidden" name="document[]" value="' + tag_file + '">');
                @endif

                    this.on("addedfile", function (file) {

                    file.previewElement.classList.remove("dz-complete"); // Hide the progress bar

                });

                this.on("success", function (file, response) {

                    $('#tagForm').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                    uploadedDocumentMap[file.name] = response.name;
                    submitForm();
                });

                this.on("removedfile", function (file) {
                    var name = '';
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name;
                    } else {
                        name = uploadedDocumentMap[file.name];
                    }
                    $('#tagForm').find('input[name="document[]"][value="' + name + '"]').remove();
                });


                myDropzone.off('sending');
                myDropzone.off('complete');

                // Add a submit button event listener
                $("#tagForm button[type='submit']").on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();

                    }else{
                        submitForm();
                    }
                });



            }
        };

        function submitForm() {
            $('#tagForm').off('submit');
            $('#tagForm').submit();
        }

    </script>
@endpush


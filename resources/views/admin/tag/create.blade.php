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
{{--        <div class="card-header">--}}
{{--            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.tags')}}">Tags</a></h4>--}}
{{--            <h4 class="font-weight-bolder d-inline-block"> / {{isset($tag) ? "Edit" : "Create" }} Tag</h4>--}}
{{--        </div>--}}
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-black-50">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" action="{{$url}}" method="POST" id="tagForm">
                @csrf
                <div class="input-group input-group-outline">
                    <input type="text" class="form-control" placeholder="Name (English)" name="name_en"
                           value="{{isset($tag) && isset($tag->name_en) ? $tag->name_en : ""}}">
                </div>

                <div class="input-group input-group-outline mt-3">
                    <input type="text" class="form-control" placeholder="Name (Arabic)" name="name_ar"
                           value="{{isset($tag)  && isset($tag->name_en) ? $tag->name_ar : ""}}">
                </div>

                <div class="input-group input-group-static mt-3 ">
                    <label for="exampleFormControlSelect1" class="ms-0">Property Type</label>
                    <select class="form-control" name="property_type">
                        <option value="" selected>Select A Property Type</option>
                        @foreach($property_types as $key=>$type)
                            <option value="{{$key}}" {{isset($tag) && $tag->property_type == $key ? "selected" : ""}}>{{$type}}</option>
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

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#tagForm') !!}

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


                $("#tagForm button[type='submit']").on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();

                    }else{
                        if (validateForm()) {
                            submitForm();
                        }
                    }
                });



            }
        };

        function validateForm() {

            var isFormValid = $('#tagForm').valid();


            if (isFormValid) {
                return true;
            } else {
                return false;
            }
        }

        function submitForm() {
            $('#tagForm').off('submit');
            $('#tagForm').submit();
        }

    </script>
@endpush


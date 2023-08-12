@extends('admin.layouts.app')

@section('content')

    @php
        if(isset($amenity)){
            $url = route('admin.amenities.update',['id'=>$amenity->id]);
        }else{
            $url = route('admin.amenities.store');
        }
    @endphp
    <div class="card ">
        <div class="card-header">
            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.amenities')}}">Amenities</a></h4>
            <h4 class="font-weight-bolder d-inline-block"> / {{isset($amenity) ? "Edit" : "Create" }} Amenity</h4>
        </div>
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

            <form role="form" action="{{$url}}" method="POST" id="amenityForm">
                @csrf
                <div class="input-group input-group-outline ">
                    <input type="text" class="form-control" placeholder="Name (English)" name="name_en"
                           value="{{isset($amenity) && isset($amenity->name_en)  ? $amenity->name_en : ""}}">
                </div>

                <div class="input-group input-group-outline mt-3">
                    <input type="text" class="form-control" placeholder="Name (Arabic)" name="name_ar"
                           value="{{isset($amenity) && isset($amenity->name_ar) ? $amenity->name_ar : ""}}">
                </div>

                <div class="input-group input-group-static mt-3 ">
                    <label for="exampleFormControlSelect1" class="ms-0">Amenity Type</label>
                    <select class="form-control" name="amenity_type">
                        <option value="" selected>Select Amenity Type</option>
                        @foreach($amenity_types as $key=>$type)

                            <option value="{{$type["id"]}}" {{isset($amenity) && isset($amenity->type) && $amenity->type->id == $type["id"] ? "selected" : ""}}>{{$type["name"]}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group input-group-outline mt-3">
                    <textarea placeholder="Description" class="form-control" name="description" rows="3">{{isset($amenity) && isset($amenity->description) ? $amenity->description : ""}}</textarea>
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
                    <a href="{{ route('admin.amenities') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#amenityForm') !!}

    <script>
        var uploadedDocumentMap = {};
        var myDropzone;

        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.amenities.storePhoto') }}',
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
                    if(isset($amenity)){
                        $filePath = public_path($amenity->file);
                        $fileSizeInBytes = file_exists($filePath) ? filesize($filePath) : 0;
                        $fileSizeInMB = round($fileSizeInBytes / (1024 * 1024), 1);
                    }
                @endphp

                @if(isset($amenity) && $amenity->file != null)
                var mockFile = { name: "{{ $amenity->file }}", size: {{ $fileSizeInMB }} };
                myDropzone.emit('addedfile', mockFile);
                myDropzone.emit('thumbnail', mockFile, "{{ asset($amenity->file) }}");

                var fileSizeText = $("[data-dz-size]").text();
                var fileSizeInMB = fileSizeText.replace("b", "MB");
                $("[data-dz-size]").text(fileSizeInMB);
                uploadedDocumentMap[mockFile.name] = "{{ $amenity->file }}";

                var amenity_file = "{{$amenity->file}}";

                $('#amenityForm').append('<input type="hidden" name="document[]" value="' + amenity_file + '">');
                @endif

                    this.on("addedfile", function (file) {

                    file.previewElement.classList.remove("dz-complete"); // Hide the progress bar

                });

                this.on("success", function (file, response) {

                    $('#amenityForm').append('<input type="hidden" name="document[]" value="' + response.name + '">');
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
                    $('#amenityForm').find('input[name="document[]"][value="' + name + '"]').remove();
                });


                myDropzone.off('sending');
                myDropzone.off('complete');

                // Add a submit button event listener
                $("#amenityForm button[type='submit']").on('click', function (e) {
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

            var isFormValid = $('#amenityForm').valid();


            if (isFormValid) {
                return true;
            } else {
                return false;
            }
        }

        function submitForm() {
            $('#amenityForm').off('submit');
            $('#amenityForm').submit();
        }

    </script>
@endpush


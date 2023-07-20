@extends('admin.layouts.app')

@section('content')

    <div class="card ">
        <div class="card-header">
            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.tags')}}">Tags</a></h4>
            <h4 class="font-weight-bolder d-inline-block"> / Create Tag</h4>
        </div>
        <div class="card-body">

            <form role="form" action="{{route('admin.tags.store')}}" method="POST">
                @csrf
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name">
                </div>

                <div class="form-group">
                    <label for="document">Documents</label>
                    <div class="needsclick dropzone" id="document-dropzone"></div>
                </div>

                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Save
                    </button>
                    <a href="{{ URL::previous() }}" type="button"
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
            maxFilesize: 2,
            acceptedFiles: 'image/svg+xml',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            autoProcessQueue: false,
            init: function () {
                myDropzone = this;

                $("form").submit(function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();

                    } else {
                        this.submit();
                    }
                });

                this.on("success", function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                    uploadedDocumentMap[file.name] = response.name;
                });

                this.on("removedfile", function (file) {
                    var name = '';
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name;
                    } else {
                        name = uploadedDocumentMap[file.name];
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove();
                });

                @if(isset($project) && $project->document)
                var files = {!! json_encode($project->document) !!};
                for (var i in files) {
                    var file = files[i];
                    this.options.addedfile.call(this, file);
                    file.previewElement.classList.add('dz-complete');
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                }
                @endif
            }
        };
    </script>
@endpush

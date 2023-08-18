@extends('admin.layouts.app')

@section('content')

    <div class="card">

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

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form role="form" action="{{route('admin.notification.send')}}" method="POST" id="notificationForm">
                @csrf

                <div class="input-group input-group-outline mb-3">
                    <input class="form-control" id="notificationTitle" name="title" placeholder="Title"></input>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <textarea class="form-control" id="notificationMessage" rows="10" name="body"
                              placeholder="Body"></textarea>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <input class="form-control" id="notificationImage" name="image" placeholder="Image URL"></input>
                </div>

                <div class="mt-3">
                    <label class="form-label">Send To:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sendTo" id="sendToAll" value="all" checked>
                        <label class="form-check-label" for="sendToAll">
                            All Users
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sendTo" id="sendToSpecific" value="specific">
                        <label class="form-check-label" for="sendToSpecific">
                            Specific Users
                        </label>
                    </div>
                    <div class="mt-2" id="specificUsersDropdown" style="display: none;">
                        <label class="form-label">Select Users:</label>
                        <select class="form-select" name="selectedUsers[]" multiple>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg">Send</button>
                </div>
            </form>

        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#notificationForm') !!}

    <script>
        $(document).ready(function () {
            $('input[name="sendTo"]').on('change', function () {
                if ($(this).val() === 'specific') {
                    $('#specificUsersDropdown').show();
                } else {
                    $('#specificUsersDropdown').hide();
                }
            });
        });

    </script>

@endpush


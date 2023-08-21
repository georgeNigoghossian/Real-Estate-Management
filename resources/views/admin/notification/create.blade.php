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

                <input type="hidden" id="tabSelection" name="tabSelection" value="">
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

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#topic">Topic</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#fcm">FCM</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="topic">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="topic" id="public" value="public">
                            <label class="form-check-label" for="public">
                                Public
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="topic" id="custom" value="custom">
                            <label class="form-check-label" for="custom">
                                Custom
                            </label>
                        </div>
                        <div class="mt-2" id="customTopicDropdown" style="display: none;">
                            <label class="form-label">Select Custom Topic:</label>
                            <select class="form-select" name="customTopic">
                                <option value=""></option>
                                @foreach($properties as $property)
                                    <option
                                        value="{{"topics/Property".$property->id}}">{{"topics/Property".$property->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fcm">
                        <div class="mt-3">
                            <label class="form-label">Send To:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sendTo" id="sendToAll" value="all"
                                       checked>
                                <label class="form-check-label" for="sendToAll">
                                    All Users
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sendTo" id="sendToSpecific"
                                       value="specific">
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

            $('input[name="topic"]').on('change', function () {
                if ($(this).val() === 'custom') {
                    $('#customTopicDropdown').show();
                } else {
                    $('#customTopicDropdown').hide();
                }
            });

            $('#notificationForm').submit(function (event) {
                if ($('input[name="to"]:checked').val() === 'public') {
                    $('input[name="to"]').val('topic/public');
                }

                // Set the value of the hidden input based on the active tab
                if ($('.nav-link.active').attr('href') === '#topic') {
                    $('#tabSelection').val('1'); // Topic tab
                } else {
                    $('#tabSelection').val('0'); // FCM tab
                }
            });
        });

    </script>

@endpush

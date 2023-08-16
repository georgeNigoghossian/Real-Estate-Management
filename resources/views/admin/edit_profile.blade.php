@extends('admin.layouts.app')

@section('content')


    <div class="card ">

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

            <form role="form" action="{{route('admin.update_profile',$admin->id)}}" method="POST" id="adminsForm">
                @csrf
                <div class="input-group input-group-outline ">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{isset($admin) ? $admin->name : ""}}">
                </div>


                <div class="input-group input-group-outline mt-3">
                    <input type="text" class="form-control" placeholder="Email" name="email"
                           value="{{isset($admin) ? $admin->email : ""}}">
                </div>

                <div class="input-group input-group-outline mt-3">
                    <input type="text" class="form-control" placeholder="Mobile" name="mobile"
                           value="{{isset($admin) ? $admin->mobile : ""}}">
                </div>

                <div class="input-group input-group-outline mt-3">

                    <input type="password" class="form-control" placeholder="Password" name="password"
                    >
                </div>
                @if(isset($admin) && $admin != "")
                    <small>Please leave password field empty if you don't want to change it </small>
                @endif

                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Save
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#editProfileForm') !!}
@endpush


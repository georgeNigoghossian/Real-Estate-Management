@extends('admin.layouts.app')

@section('content')

    @php
        if(isset($admin)){
            $url = route('admin.admins.update',['id'=>$admin->id]);
        }else{
            $url = route('admin.admins.store');
        }
    @endphp
    <div class="card ">
        <div class="card-header">
            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.admins.list')}}">Admins</a></h4>
            <h4 class="font-weight-bolder d-inline-block"> / {{isset($admin) ? "Edit" : "Create" }} Admin</h4>
        </div>
        <div class="card-body">

            <form role="form" action="{{$url}}" method="POST" id="adminsForm">
                @csrf
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{isset($admin) ? $admin->name : ""}}">
                </div>


                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Email" name="email"
                           value="{{isset($admin) ? $admin->email : ""}}">
                </div>

                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Mobile" name="mobile"
                           value="{{isset($admin) ? $admin->mobile : ""}}">
                </div>

                <div class="input-group input-group-outline mb-3">

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
                    <a href="{{ route('admin.admins.list') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>

@endsection



@extends('admin.layouts.app')

@section('content')

    <div class="card card-body mx-3 mx-md-4 mt-2">
    <div class="row gx-4 mb-2">

        <div class="col-auto ">
            <div class="h-100">
                <h5 class="mb-1">
                    {{$user->name}}
                </h5>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="row">

            <div class="col-12 col-xl-6">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Profile Information</h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body p-3">

                        <hr class="horizontal gray-light my-2">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name: </strong> &nbsp;
                                {{$user->name}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp;
                                {{$user->mobile}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp;{{$user->email}}</li>

                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Date Of Birth:</strong> &nbsp;{{$user->date_of_birth}}</li>

                            <li class="list-group-item border-0 ps-0 pb-0">
                                <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="{{$user->facebook}}">
                                    <i class="fab fa-facebook fa-lg"></i>
                                </a>
                                <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-twitter fa-lg"></i>
                                </a>
                                <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-instagram fa-lg"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="mb-5 ps-3">
                    <h6 class="mb-1">Properties</h6>

                </div>
                <div class="row">
                    @foreach($properties as $property)
                        <div class="col-xl-3 col-md-6  mb-4">
                        <div class="card card-blog card-plain">
                            <div class="card-header p-0 mt-n4 mx-3">
                                <a class="d-block shadow-xl border-radius-xl">

                                    <img src="{{$property["first_image_url"]}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                </a>
                            </div>
                            <div class="card-body p-3">
                                <p class="mb-0 text-sm">{{isset($status[$property->status]) ? $status[$property->status] : ""}}</p>
                                <a href="javascript:;">
                                    <h5>
                                        {{$property->name}}
                                    </h5>
                                </a>
                                <p class="mb-4 text-sm">
                                    {{$property->description}}
                                </p>
                                <div class="d-flex align-items-center justify-content-between ">
                                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">View Property</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

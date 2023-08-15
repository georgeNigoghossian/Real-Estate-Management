@extends('admin.layouts.app')

@section('content')

    <div class="card card-body mx-3 mx-md-4 mt-2">
        <div class="row gx-4 mb-2">

            <div class="col-auto ">
                <div class="h-100 d-flex mx-3">
                    <h5 class="mb-1">
                        {{$property->name}}
                    </h5>
                    @switch($property->status)
                        @case('in_market')
                            <span class="badge bg-success align-self-center mx-2">In Market</span>
                            @break
                        @case('purchased')
                            <span class="badge bg-purchased align-self-center mx-2">Purchased</span>
                            @break
                        @case('rented')
                            <span class="badge bg-info align-self-center mx-2">Rented</span>
                            @break
                    @endswitch
                </div>
            </div>

        </div>
        <div class="row">
            <div class="row">

                <div class="col-12 col-xl-3">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Details</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body p-3">

                            <hr class="horizontal gray-light my-2">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Property
                                        Type: </strong> &nbsp;
                                    {{$type}}</li>
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                        class="text-dark">Area: </strong> &nbsp;
                                    {{$property->area}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Price:</strong> &nbsp;
                                    {{$property->price}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Service:</strong> &nbsp;{{$property->service}}</li>

                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Owner:</strong>
                                    &nbsp;{{isset($property->user) ? $property->user->name : ""}}</li>

                                @foreach($additional_data as $key=> $data)
                                    @if($additional_data[$key] != "")
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong
                                                class="text-dark">{{$key}}:</strong>
                                            {{$data}}</li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Description</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body p-3">
                            {{$property->description}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Gallery</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body p-3 h-100">

                            <div id="galleryCarosel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @if(is_array($media) && count($media)>0)
                                        @foreach($media as $key=>$photo)
                                            <div class="carousel-item {{$key==0 ? "active" : ""}}">
                                                <img src="{{$photo["original_url"]}}" height="350" class="d-block w-100"
                                                     alt="{{$property->name}}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item  active ">
                                            <img src="{{$media}}" height="350" class="d-block w-100"
                                                 alt="{{$property->name}}">
                                        </div>
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarosel"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#galleryCarosel"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">

                            <div id="map" class="rounded" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var latitude = {{ $property->latitude }};
        var longitude = {{ $property->longitude }};
        var propertyName = "{{ $property->name }}";

        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([latitude, longitude]).addTo(map)
            .bindPopup(propertyName)
            .openPopup();
    </script>

@endpush

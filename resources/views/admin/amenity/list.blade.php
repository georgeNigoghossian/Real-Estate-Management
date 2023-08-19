@extends('admin.layouts.app')

@section('content')


    @include('admin.amenity.filters')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (English)</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (Arabic)</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amenity Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Active</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($amenities as $amenity)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$amenity->name_en}}</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$amenity->name_ar}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{isset($amenity->type) ? $amenity->type->name_en : ""}}</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input amenityActive" type="checkbox" role="switch" data-id="{{$amenity->id}}"  {{$amenity->active==1 ? "checked" : ""}} />

                            </div>
                        </td>

                        <td class="text-end">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3" href="{{route('admin.amenities.edit',['id'=>$amenity->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                            </a>
                        </td>

                        <td class="text-start">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3 delete-btn" href="{{route('admin.amenities.delete',['id'=>$amenity->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center paginate-nav">
            {{ $amenities->links() }}
        </div>
    </div>
@endsection

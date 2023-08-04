@extends('admin.layouts.app')

@section('content')

    @php
        if(isset($amenity_type)){
            $url = route('admin.amenity_types.update',['id'=>$amenity_type->id]);
        }else{
            $url = route('admin.amenity_types.store');
        }
    @endphp
    <div class="card ">
        <div class="card-header">
            <h4 class="font-weight-bolder d-inline-block"><a href="{{route('admin.amenity_types')}}">Amenity Types</a></h4>
            <h4 class="font-weight-bolder d-inline-block"> / {{isset($amenity_type) ? "Edit" : "Create" }} Amenity Type</h4>
        </div>
        <div class="card-body">

            <form role="form" action="{{$url}}" method="POST" id="amenityForm">
                @csrf
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{isset($amenity_type) ? $amenity_type->name : ""}}">
                </div>


                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Save
                    </button>
                    <a href="{{ route('admin.amenity_types') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>

@endsection



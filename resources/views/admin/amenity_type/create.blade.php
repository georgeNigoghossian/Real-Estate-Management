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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-black-50">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" action="{{$url}}" method="POST" id="amenityTypeForm">
                @csrf
                <div class="input-group input-group-outline ">
                    <input type="text" class="form-control" placeholder="Name (English)" name="name_en"
                           value="{{isset($amenity_type) && isset($amenity_type->name_en)? $amenity_type->name_en : ""}}">
                </div>

                <div class="input-group input-group-outline mt-3">
                    <input type="text" class="form-control" placeholder="Name (Arabic)" name="name_ar"
                           value="{{isset($amenity_type) && isset($amenity_type->name_ar)? $amenity_type->name_ar : ""}}">
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

@push('scripts')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#amenityTypeForm') !!}

@endpush



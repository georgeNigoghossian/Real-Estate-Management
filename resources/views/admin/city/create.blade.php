@extends('admin.layouts.app')

@section('content')

{{--    @php--}}
{{--        if(isset($amenity)){--}}
{{--            $url = route('admin.amenities.update',['id'=>$amenity->id]);--}}
{{--        }else{--}}
{{--            $url = route('admin.amenities.store');--}}
{{--        }--}}
{{--    @endphp--}}
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

            <form role="form" action="{{route('admin.city.create')}}" method="POST" id="cityForm">
                @csrf
                <div class="input-group input-group-outline ">
                    <input type="text" class="form-control" placeholder="Name (English)" name="name">
                </div>
                <div class="input-group input-group-outline mt-3">
                    <select class="form-control" name="country_id">
                        <option value="">--please select a country--</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Save
                    </button>
                    <a href="{{ route('admin.city.index') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $jsValidator->selector('#cityForm') !!}

    <script>
        var uploadedDocumentMap = {};

        function validateForm() {

            var isFormValid = $('#cityForm').valid();


            if (isFormValid) {
                return true;
            } else {
                return false;
            }
        }

        function submitForm() {
            $('#cityForm').off('submit');
            $('#cityForm').submit();
        }

    </script>
@endpush


@extends('admin.layouts.app')

@section('content')


    @include('admin.amenity_type.filters')

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
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($amenity_types as $amenity_type)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$amenity_type->name_en}}</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$amenity_type->name_ar}}</h6>
                                </div>
                            </div>
                        </td>


                        <td class="text-end">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3" href="{{route('admin.amenity_types.edit',['id'=>$amenity_type->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                            </a>
                        </td>

                        <td class="text-start">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3 delete-btn" href="{{route('admin.amenity_types.delete',['id'=>$amenity_type->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center paginate-nav">
            {{ $amenity_types->links() }}
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('content')

    @include('admin.property.filters')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">area</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Owner</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($properties as $property)
                    <tr data-property-id="{{ $property->id }}">
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$property->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-normal mb-0">{{$property->area}}</p>
                        </td>
                        <td class="priority-field w-25">
                            {{$property->price}}
                        </td>
                        <td class="w-25">
                            {{$property->user->name}}
                        </td>


                        <td class="align-middle">
                            <a class="btn btn-icon btn-2 btn-primary px-3" href="{{route('admin.property.details',$property->id)}}" >
                                <span class="btn-inner--icon"><i class="material-icons">list</i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center paginate-nav">
{{--            {{ $users->links() }}--}}
        </div>
    </div>
@endsection

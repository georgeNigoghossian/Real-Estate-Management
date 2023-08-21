@extends('admin.layouts.app')

@section('content')
    @include('admin.city.filters')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Country</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cities as $city)
                    <tr data-agency-id="{{ $city->id }}">
                        <td>
                            <div class="d-flex px-2">
                                <div class="my-auto">
                                    <h6 class="mb-0">{{$city->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex px-2">
                                <div class="my-auto">
                                    <h6 class="mb-0">{{$city->country->name}}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

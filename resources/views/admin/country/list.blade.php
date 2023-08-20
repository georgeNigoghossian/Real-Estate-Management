@extends('admin.layouts.app')

@section('content')
    @include('admin.country.filters')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($countries as $country)
                    <tr data-agency-id="{{ $country->id }}">
                        <td>
                            <div class="d-flex px-2">
                                <div class="my-auto">
                                    <h6 class="mb-0">{{$country->name}}</h6>
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

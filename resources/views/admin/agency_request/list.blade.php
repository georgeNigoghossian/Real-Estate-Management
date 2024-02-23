@extends('admin.layouts.app')

@section('content')

    @include('admin.agency.filters')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created At
                    </th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $creator)
                    @php($agency = $creator->agency)
                    @php($agency_request = $creator->agency_requests()->first())
                    <tr data-agency-id="{{ $agency_request->id }}">
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0">{{$creator->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="font-weight-normal mb-0">{{$creator->email}}</p>
                        </td>
                        <td class="created-at-field w-25">
                            {{$creator->created_at->format('d/m/Y')}}
                        </td>


                        <td class="align-middle">
                            <a class="btn btn-icon btn-2 btn-primary" href="{{route('admin.agency_requests.details',$agency_request->id)}}">
                                <span class="btn-inner--icon"><i class="material-icons">list</i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center paginate-nav">
            {{ $users->links() }}
        </div>
    </div>
@endsection

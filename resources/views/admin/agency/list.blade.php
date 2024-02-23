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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rate</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Priority
                    </th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $creator)
                    @php($agency = $creator->agency)
                    <tr data-agency-id="{{ $agency->id }}" data-user-id="{{$creator->id}}">
                        <td>
                            <div class="d-flex px-2">
                                <div class="my-auto">
                                    <h6 class="mb-0">{{$creator->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="font-weight-normal mb-0">{{$creator->email}}</h6>
                        </td>
                        <td>
                            <h6 class="font-weight-normal mb-0">{{$agency->rate}}</h6>
                        </td>
                        <td class="priority-field w-25">

                            <h6 class="font-weight-normal mb-0">{{$creator->priority}}</h6>
                        </td>


                        <td class="align-middle">
                            <a class="btn btn-icon btn-2 btn-primary" href="{{route('admin.agency.details',$agency->id)}}" >
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

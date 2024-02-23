@extends('admin.layouts.app')

@section('content')

{{--    @include('admin.repoted_client.filters')--}}
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reported Client Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Number Of Reports</th>


                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $reportedClientRow)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$reportedClientRow->reportedUser->name}} </h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$reportedClientRow->total}} </h6>
                                </div>
                            </div>
                        </td>



                        <td class="align-middle">
                            <a class="btn btn-icon btn-2 btn-primary px-3" href="{{route('admin.reported_users.details',$reportedClientRow->reportedUser->id)}}">
                                <span class="btn-inner--icon"><i class="material-icons">block</i></span>
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

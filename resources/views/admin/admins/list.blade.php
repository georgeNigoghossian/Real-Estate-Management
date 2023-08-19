@extends('admin.layouts.app')

@section('content')

    @include('admin.admins.filters')
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mobile
                    </th>

                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr data-user-id="{{ $admin->id }}">
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$admin->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-normal mb-0">{{$admin->email}}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-normal mb-0">{{$admin->mobile}}</p>
                        </td>


                        <td class="text-end">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3"
                               href="{{route('admin.admins.edit',['id'=>$admin->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                            </a>
                        </td>


                        <td class="text-start">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3 delete-btn"
                               href="{{route('admin.admins.delete',['id'=>$admin->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                            </a>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center paginate-nav">
            {{ $admins->links() }}
        </div>
    </div>

@endsection

@extends('admin.layouts.app')

@section('content')

    @include('admin.user.filters')
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reported Client Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Reporter Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category
                    </th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $reportedClientRow)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$reportedClientRow->reportedUser->name}}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-normal mb-0">{{$reportedClientRow->reportingUser->name}}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-normal mb-0">{{$reportedClientRow->reportCategory->name}}</p>
                        </td>


                        <td class="align-middle">
                            <button class="btn btn-icon btn-2 btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModal-{{$reportedClientRow->id}}">
                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                            </button>

                            <div class="modal fade" id="editModal-{{$reportedClientRow->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('admin.user.switch_block')}}">
                                            @csrf
                                            <input type="hidden" name="is_blocked" value="1" >
                                            <input type="hidden" name="id" value="{{$reportedClientRow->reportedUser->id}}" >
                                            <input type="hidden" name="needs_redirect" value="1" >
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-normal" id="editModalLabel">Edit</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Description</h3>
                                            <p>{!! $reportedClientRow->description !!}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn bg-gradient-primary">Block</button>
                                        </div>
                                        </form>
                                    </div>
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

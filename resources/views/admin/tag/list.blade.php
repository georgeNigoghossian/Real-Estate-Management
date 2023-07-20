@extends('admin.layouts.app')

@section('content')


    @include('admin.tag.filters')


    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>


                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$tag->name}}</h6>
                                </div>
                            </div>
                        </td>


                        <td class="align-middle">
                            <button class="btn btn-icon btn-2 btn-primary" type="button">
                                <span class="btn-inner--icon"><i class="material-icons">list</i></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

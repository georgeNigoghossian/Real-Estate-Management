@extends('admin.layouts.app')

@section('content')


    @include('admin.tag.filters')


    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (English)</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (Arabic)</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Active</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$tag->name_en}}</h6>
                                </div>
                            </div>


                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{$tag->name_ar}}</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex px-2">

                                <div class="my-auto">
                                    <h6 class="mb-0 text-xs">{{isset($tag->property_type) ? $property_types[$tag->property_type] : ""}}</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input tagActive" type="checkbox" role="switch" data-id="{{$tag->id}}"  {{$tag->active==1 ? "checked" : ""}} />

                            </div>
                        </td>

                        <td class="text-end">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3" href="{{route('admin.tags.edit',['id'=>$tag->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                            </a>
                        </td>

                        <td class="text-start">
                            <a class="btn btn-icon btn-2 btn-primary text-end px-3" href="{{route('admin.tags.delete',['id'=>$tag->id])}}">
                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <div class="d-flex justify-content-center paginate-nav">
                {{ $tags->links() }}
            </div>
        </div>
    </div>
@endsection

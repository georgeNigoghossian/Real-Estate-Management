@extends('admin.layouts.app')
@section('content')
    <div class="card">

        <div class="card-body">
            <form method="POST" action="{{route('admin.user.switch_block')}}">
                @csrf
                <input type="hidden" name="is_blocked" value="1">
                <input type="hidden" name="id" value="{{$user_id}}">
                <input type="hidden" name="redirect_to_reported_clients" value="1">



                    @foreach($reports as $report)
                        <p><b>Reporter:</b>{{ $report->reportingUser->name }}</p>
                        <p><b>Reporting Date :</b>{{ date('Y-m-d H:i:s', strtotime($report->created_at)) }}</p>
                    <p><b>Category:</b>{{ $report->reportCategory != null ? $report->reportCategory->name  : ""}}</p>
                        <b>Description:</b>
                        <p>{!! $report->description !!}</p>
                        <hr class="block-user-hr">
                        @endforeach

                <div class="text-end">
                    <button type="submit"
                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0 align-self-end ms-auto w-10">Block
                    </button>
                    <a href="{{ route('admin.reported_users') }}" type="button"
                       class="btn btn-lg bg-gradient-secondary btn-lg mt-4 mb-0 align-self-end ms-auto w-">Cancel</a>
                </div>

            </form>
        </div>
    </div>
@endsection

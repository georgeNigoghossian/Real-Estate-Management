<nav aria-label="breadcrumb">

    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        @foreach($breadcrumb as $key=>$item)
        <li class="breadcrumb-item text-sm {{count($breadcrumb)-1==$key ? 'text-dark active' : ""}}">
            @if(isset($item["url"]) && $item["url"] != "")
            <a class="opacity-5 text-dark" href="{{$item["url"]}}">{{$item["title"]}}</a>
            @else
                {{$item["title"]}}
            @endif
        </li>

        @endforeach
    </ol>
    @if(count($breadcrumb) > 1)
    <h6 class="font-weight-bolder mb-0">{{$breadcrumb[count($breadcrumb)-1]["title"]}}</h6>
    @endif
</nav>

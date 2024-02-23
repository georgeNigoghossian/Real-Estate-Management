<form class="mb-2 filters-form" method="get">
    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-outline my-3">

                <input type="text" class="form-control" name="name" placeholder="Search By Name"
                       value='{{request()->name != "" ? request()->name  : ""}}'>
            </div>
        </div>


        <div class="col-md-3 align-self-end">
            <button class="btn btn-outline-primary px-3" type="submit">
                <span class="material-icons">
                search
                </span></button>

            <button class="btn btn-outline-primary px-3" id="refresh">
                <span class="material-icons">
                refresh
                </span></button>

        </div>

        <div class="col-md-6 text-end">
            <a href="{{route('admin.tags.create')}}" taget="_blank" class="btn btn-icon btn-2 btn-primary" type="button">
                <span class="material-icons">
                add
                </span>
                Create

            </a>
        </div>

    </div>

</form>

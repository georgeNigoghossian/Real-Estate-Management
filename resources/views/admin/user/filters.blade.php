<form class="mb-2 filters-form" method="get" >
    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-outline my-3">

                <input type="text" class="form-control" name="name" placeholder="Search By Name" value='{{request()->name != "" ? request()->name  : ""}}'>
            </div>
        </div>

        @if (stripos($_SERVER['REQUEST_URI'], '/BlockedUser' )===false)
        <div class="col-md-3">

            <div class="input-group input-group-static mb-4 ">
                <label for="isBlocked" class="ms-0">Blocked</label>
                <select class="form-control " id="isBlocked" name="is_blocked">
                    <option value="" {{ (!isset(request()->is_blocked) || request()->is_blocked=="") ? "selected" : ""}}>All
                    </option>
                    <option value="1" {{ (isset(request()->is_blocked) && request()->is_blocked==1)  ? "selected" : ""}}>Yes
                    </option>
                    <option value="0" {{ (isset(request()->is_blocked) && request()->is_blocked==0)  ? "selected" : ""}}>No
                    </option>

                </select>
            </div>
        </div>
       @endif
        <div class="col-md-3 align-self-end" >
            <button class="btn btn-outline-primary px-3" type="submit">
                <span class="material-icons">
                search
                </span></button>

            <button class="btn btn-outline-primary px-3" id = "refresh">
                <span class="material-icons">
                refresh
                </span></button>

        </div>


    </div>

</form>

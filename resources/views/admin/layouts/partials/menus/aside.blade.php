<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">

            <span class="ms-1 font-weight-bold text-white">Dashboard</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Users</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.user.list')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>

                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.user.blocked_list')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">no_accounts</i>
                    </div>

                    <span class="nav-link-text ms-1">Blocked Users</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.reported_users')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">flag</i>
                    </div>

                    <span class="nav-link-text ms-1">Reported Users</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Tags & Amenities</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.tags')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_offer</i>
                    </div>

                    <span class="nav-link-text ms-1">Tags</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.amenities')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">wifi</i>
                    </div>

                    <span class="nav-link-text ms-1">Amenities</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{route('admin.amenity_types')}}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">wifi</i>
                    </div>

                    <span class="nav-link-text ms-1">Amenity Types</span>
                </a>
            </li>

        </ul>
    </div>



</aside>

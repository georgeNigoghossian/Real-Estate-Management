<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
     data-scroll="true">
    <div class="container-fluid py-1 px-3">

        @include('admin.layouts.partials.breadcrumb')
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">


            </div>
            <ul class="navbar-nav  justify-content-end">




                <li class="nav-item dropdown pe-2 d-flex align-items-center">

                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person fs-20 me-sm-1"></i>
                    </a>

                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{route('admin.edit_profile')}}">
                                <div class="d-flex py-1">

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Profile</span>
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <div class="d-flex py-1">

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Logout</span>
                                        </h6>
                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>

                                    </div>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

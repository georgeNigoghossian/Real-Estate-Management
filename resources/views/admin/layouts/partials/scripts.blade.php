
<script src="{{asset('assets/js/core/popper.min.js')}}" ></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/jquery.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/dropzone.min.js')}}" ></script>
<script>
    var routes = {
        switchBlock: "{{ route('admin.user.switch_block') }}",
        updatePriority : "{{route('admin.user.update_priority')}}",
        switchTagActive : "{{ route('admin.tag.switch_active') }}",
        switchAmenityActive : "{{ route('admin.amenities.switch_active') }}",
    };

</script>

<script src="{{asset('assets/js/plugins/sweetalert2@11.js')}}" ></script>
<script src="{{asset('assets/js/custom.js')}}" ></script>

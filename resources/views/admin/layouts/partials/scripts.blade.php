
<script src="{{asset('assets/js/core/popper.min.js')}}" ></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/jquery.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/dropzone.min.js')}}" ></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" ></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

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

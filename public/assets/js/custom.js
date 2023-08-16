$(document).ready(function () {
    $("#refresh").on('click', function () {

        $(':input', '.filters-form')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .prop('checked', false)
            .prop('selected', false);

        $('filters-form').submit();

    });


    $(".blockSwitch").on('change', function () {
        var id = $(this).attr('data-id');
        var is_blocked;

        if ($(this).is(':checked')) {
            is_blocked = 1;
        } else {
            is_blocked = 0;
        }

        var checkbox = $(this); // Store the checkbox element

        if (!checkbox.data('initialClick')) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: routes.switchBlock,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'is_blocked': is_blocked,
                            'id': id
                        },

                    });
                } else {
                    checkbox.data('initialClick', true);
                    checkbox.trigger('click');
                }
            })
        } else {
            checkbox.removeData('initialClick');
        }
    });



    $(".tagActive").on('change', function () {
        var id = $(this).attr('data-id');

        var is_active;
        if ($(this).is(':checked')) {
            is_active = 1;
        } else {
            is_active = 0;
        }

        $.ajax({

            url: routes.switchTagActive,
            type: 'POST',
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                'is_active': is_active,
                'id': id
            },
            success: function (data) {

            },

        });

    })


    $(".amenityActive").on('change', function () {
        var id = $(this).attr('data-id');

        var is_active;
        if ($(this).is(':checked')) {
            is_active = 1;
        } else {
            is_active = 0;
        }

        $.ajax({

            url: routes.switchAmenityActive,
            type: 'POST',
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                'is_active': is_active,
                'id': id
            },
            success: function (data) {

            },

        });

    })

    $('.priority-field').click(function () {
        var currentPriority = $(this).text().trim();
        var inputField = $('<input>', {
            type: 'number',
            class: 'form-control',
            value: currentPriority
        });
        $(this).html(inputField);
        inputField.focus();
    });


    $(document).on('change', 'tr[data-user-id] .priority-field input', function (event) {
        var $input = $(this);
        var newPriority = $input.val().trim();
        var userId = $input.closest('tr').data('user-id');


        if (newPriority !== "") {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: routes.updatePriority,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            userId: userId,
                            newPriority: newPriority
                        },
                        success: function (response) {

                            $input.closest('td.priority-field').html(newPriority);
                        }
                    });
                } else {

                    $input.val(newPriority);
                }
            });
        }
    });

    $(document).on('change', 'tr[data-user-id] .priority-field input', function (event) {
        var $input = $(this);
        var newPriority = $input.val().trim();
        var userId = $input.closest('tr').data('user-id');


        if (newPriority !== "") {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: routes.updatePriority,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            userId: userId,
                            newPriority: newPriority
                        },
                        success: function (response) {

                            $input.closest('td.priority-field').html(newPriority);
                        }
                    });
                } else {

                    $input.val(newPriority);
                }
            });
        }
    });


});
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,

        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});

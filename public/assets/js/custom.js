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

        $.ajax({

            url: routes.switchBlock,
            type: 'POST',
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                'is_blocked': is_blocked,
                'id': id
            },
            success: function (data) {

            },

        });

    })


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


});

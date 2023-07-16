
$(document).ready(function () {
    $(':input', '.filters-form')
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .prop('checked', false)
        .prop('selected', false);

    $('filters-form').submit();

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
                'id':id
            },
            success: function (data) {

            },

        });

    })
});



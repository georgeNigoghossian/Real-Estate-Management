
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


$(document).ready(function() {
    $('.priority-field').click(function() {
        var currentPriority = $(this).text().trim();
        var inputField = $('<input>', {
            type: 'number',
            class: 'form-control',
            value: currentPriority
        });
        $(this).html(inputField);
        inputField.focus();
    });

    $(document).on('blur', '.priority-field input', function() {
        var newPriority = $(this).val().trim();
        var userId = $(this).closest('tr').data('user-id');

        $.ajax({
            url: routes.updatePriority,
            method: 'POST',
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                userId: userId,
                newPriority: newPriority
            },

            success: function(response) {
                $('.priority-field').html(newPriority);
            },
        });
    });
});

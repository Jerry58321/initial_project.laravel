$(document).ready(function () {
    $('#kick-member-all').click(function () {
        var title = $(this).data('title');
        sweetAlert(title, 'kick');
    });

    $('#enable-maintain').click(function () {
        var title = $(this).data('title');
        $('#maintain-status').val('0');
        sweetAlert(title, 'maintain');
    });

    $('#disable-maintain').click(function () {
        var title = $(this).data('title');
        $('#maintain-status').val('1');
        sweetAlert(title, 'maintain');
    });

    $('#enable-api-key').click(function () {
        var title = $(this).data('title');
        $('#api-key-status').val('enable');
        sweetAlert(title, 'api-key');
    });

    $('#disable-api-key').click(function () {
        var title = $(this).data('title');
        $('#api-key-status').val('disable');
        sweetAlert(title, 'api-key');
    })

    function sweetAlert(title, formId)
    {
        swal({
            title: title,
            icon: "warning",
            buttons:['NO','YES']
        })
            .then(willDelete => {
                if (willDelete) {
                    $('#'+formId).submit();
                }
            });
    }
});
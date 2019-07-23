$(document).ready(function () {
    $('#kick-member-id').click(function () {
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
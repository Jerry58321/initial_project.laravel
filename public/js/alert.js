$(document).ready(function () {
    $(".show-del-dialog").click(function () {
        var $this = $(this);
        var url    = $this.data('url');
        var name   = $this.data('name');
        $("#delete-form").attr('action', url);
        $("#name").html(name);
        $("#delete").modal('show');
    });
});

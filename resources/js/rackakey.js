$(function () {
    $('.usbDelete').on('submit, click', function (e) {
        e.preventDefault();
        $('.modal').modal('show');
        $(this).off('submit');
        let parentThis = $(this);

        $("#deleteModalUsbName").text($(this).closest('tr').data("usbname"));
        $("#deleteModalReservationUsbCount").text($(this).closest('tr').data("reservationusbcount"));
        $("#deleteModalUsbFreeSpace").text($(this).closest('tr').data("usbfreespace"));
        $("#deleteModalUsbCreatedAt").text($(this).closest('tr').data("createdat"));

        $('#modalDeleteButton').on('click', function(event) {
            parentThis.submit();
        });
    });
});
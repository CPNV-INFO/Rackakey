$(function () {
    $('.usbDelete').on('submit, click', function (e) {
        e.preventDefault();
        $('.modal').modal('show');
        $(this).off('submit');
        let parentThis = $(this);
        $('#modalDeleteButton').on('click', function(event) {
            parentThis.submit();
        });
    });
});
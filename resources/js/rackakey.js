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

    $('#checkboxFolderFileInput').click(function(){
        if($('#checkboxFolderFileInput').is(':checked')){
            $('#fileInput').attr("webkitdirectory", "");
            $('#fileInput').attr("mozdirectory", "");
            $('#fileInput').attr("msdirectory", "");
            $('#fileInput').attr("odirectory", "");
            $('#fileInput').attr("directory", "");
        }else{
            $('#fileInput').removeAttr("webkitdirectory mozdirectory msdirectory odirectory directory");
        }
    });

    $('#fileInput').on('change', function (e) {
        console.log($(this));
        console.log();
        $.ajax({
            url: "/getMaxFileUploads",
        }).done(function(data) {
            let jsonData = JSON.parse(data);

            if(e.target.files.length > jsonData["max_file_uploads"]){
                $('.modal').modal('show');
            }

        }).fail(function(data){
            console.log("Error from server");
        });
    });

});

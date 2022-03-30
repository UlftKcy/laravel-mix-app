$(function () {
    let product_image = $("#product_image");
    let btn_outer = $(".button_outer");
    let uploaded_file_view = $(".uploaded_file_view");
    product_image.on("change", function (e) {
        let fileType = product_image.val().split(".").pop().toLowerCase();
        const validImageTypes = ['png', 'jpg', 'jpeg'];
        if ($.inArray(fileType, validImageTypes) < 0) {
            $(".error_msg").text("Geçerli bir resim ekleyin...");
        } else {
            $(".error_msg").text("");
            btn_outer.addClass("file_uploading");
            setTimeout(function () {
                btn_outer.addClass("file_uploaded");
            }, 3000);
            let uploadedFile = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view").append('<img src="' + uploadedFile + '"/>').addClass("show");
            }, 3500);
            setTimeout(function () {
                $(".button_outer ,.file_uploading ,.file_uploaded").fadeOut("fast");
            }, 4000);
        }
    })
    $(".file_remove").on("click", function () {
        uploaded_file_view.removeClass("show");
        uploaded_file_view.find("img").remove();
        btn_outer.removeClass("file_uploading");
        btn_outer.removeClass("file_uploaded");
        btn_outer.css('display', 'block');
    })
})

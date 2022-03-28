$(function () {
    let main_category_area = $("#main_category_area");
    let sub_one_category_area = $("#sub_one_category_area");
    let sub_two_category_area = $("#sub_two_category_area");
    let category_name_area = $("#category_name_area");

    main_category_area.hide();
    sub_one_category_area.hide();
    sub_two_category_area.hide();
    category_name_area.hide();
})
$(document).on("change", "#category_type", function () {

    let category_type = $(this).val();

    let main_category_area = $("#main_category_area");
    let sub_one_category_area = $("#sub_one_category_area");
    let sub_two_category_area = $("#sub_two_category_area");
    let category_name_area = $("#category_name_area");

    main_category_area.hide();
    sub_one_category_area.hide();
    sub_two_category_area.hide();
    category_name_area.hide();


    if (category_type === "main_category") {
        category_name_area.show();
    } else if (category_type === "sub_one_category") {
        main_category_area.show();
        category_name_area.show();
    } else {
        main_category_area.show();
        sub_one_category_area.show();
        category_name_area.show();
    }

})

$(document).on("click", "#btn_category", function () {
    let form = $("#form_category");
    let data = new FormData(form);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/",
        method: 'POST',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {

        }
    })
})

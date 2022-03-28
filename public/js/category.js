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
    let category_type = $("#category_type").val();

    // create main category
    if (category_type === "main_category") {
        let form = $("#form_category")[0];
        let data = new FormData(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/store-main-category",
            method: 'POST',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    let main_category = $("#main_category");

                    main_category.children('option:not(:first)').remove();

                    $.each(response.data.main_categories, function (key, item) {
                        main_category.append('<option value="' + item.id + '">' + item.name + '</option>')
                    });
                } else {
                    alert(response.message);
                }
            }
        })
    }
    // create sub-one category
    if (category_type === "sub_one_category") {
        let form = $("#form_category")[0];
        let data = new FormData(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/store-sub-one-category",
            method: 'POST',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {

            }
        })
    }
    // create sub-two category
    if (category_type === "sub_two_category") {
        let form = $("#form_category")[0];
        let data = new FormData(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/store-sub-two-category",
            method: 'POST',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {

            }
        })
    }
})

$(document).on("click", "#btn_add_product_modal", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/fetch-main-categories",
        method: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === "success") {
                let add_product_main_category = $("#add_product_main_category");

                add_product_main_category.children('option:not(:first)').remove();
                $.each(response.data.main_categories, function (key, item) {
                    add_product_main_category.append('<option value="' + item.id + '">' + item.name + '</option>')
                });

            } else {
                alert(response.message);
            }
        }
    })
})

$(document).on("change", "#add_product_main_category", function () {
    let add_product_main_category_id = $(this).val();
    let form_data = new FormData();
    form_data.append("add_product_main_category_id", add_product_main_category_id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/fetch-sub-one-categories",
        method: 'POST',
        data: form_data,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === "success") {
                let add_product_sub_one_category = $("#add_product_sub_one_category");

                add_product_sub_one_category.children('option:not(:first)').remove();
                $.each(response.data.sub_one_categories, function (key, item) {
                    add_product_sub_one_category.append('<option value="' + item.id + '">' + item.name + '</option>')
                });

            } else {
                alert(response.message);
            }
        }
    })
});

$(document).on("change", "#add_product_sub_one_category", function () {
    let add_product_sub_one_category_id = $(this).val();
    let form_data = new FormData();
    form_data.append("add_product_sub_one_category_id", add_product_sub_one_category_id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/fetch-sub-two-categories",
        method: 'POST',
        data: form_data,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === "success") {
                let add_product_sub_two_category = $("#add_product_sub_two_category");

                add_product_sub_two_category.children('option:not(:first)').remove();
                $.each(response.data.sub_two_categories, function (key, item) {
                    add_product_sub_two_category.append('<option value="' + item.id + '">' + item.name + '</option>')
                });

            } else {
                alert(response.message);
            }
        }
    })
});

$(document).on("click","#btn_product",function () {
    let form = $("#form_product")[0];
    let data = new FormData(form);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/product-store",
        type: 'POST',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            if (response.status === "success") {
                window.location.href = response.url;
            } else {
                alert("hata oluştu")
            }
        }
    })
})


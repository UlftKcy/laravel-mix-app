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

function productHtml(product) {
    let html = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">\n' +
        '                            <div class="card">\n' +
        '                                <img src="/product-images/' + product.path + '"\n' +
        '                                    class="p-2"\n' +
        '                                    style="width:100%;height:200px;object-fit: cover;"/>\n' +
        '                                <div class="card-body p-4">\n' +
        '                                    <div class="card-title fw-bolder text-truncate">\n' +
        '                                        ' + product.name + '\n' +
        '                                    </div>\n' +
        '                                    <p class="card-text text-truncate">\n' +
        '                                        ' + product.description + '\n' +
        '                                    </p>\n' +
        '                                </div>\n' +
        '                                <div class="card-footer d-flex justify-content-between">\n' +
        '                                    <span class="text-success fw-bolder">' + product.price + ' TL</span>\n' +
        '                                    <button class="btn btn-primary">\n' +
        '                                        <i class="fa-solid fa-cart-plus"></i>\n' +
        '                                    </button>\n' +
        '                                    <a href="product-edit/' + product.id + '" role="button"\n' +
        '                                       class="btn btn-warning" id="btn_product_edit">\n' +
        '                                        <i class="fa-solid fa-pen-to-square"></i>\n' +
        '                                    </a>\n' +
        '                                    <a href="product-delete/' + product.id + '" class="btn btn-danger"\n' +
        '                                       id="btn_product_delete">\n' +
        '                                        <i class="fa-solid fa-trash-can"></i>\n' +
        '                                    </a>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>'
    return html;
}

$(document).on("click", "#btn_product", function () {
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
                Swal.fire({
                    icon: response.status,
                    text: response.message,
                    showCancelButton: false,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light"
                    },
                });


                let product = response.data.product_item;
                let html = productHtml(product);

                $("#product_area").append(html);
                $("#addProductModal").modal("toggle");

            } else {
                alert("hata oluştu")
            }
        }
    })
})

// edit and delete product

$(document).on("click", "#btn_product_update", function () {
    let product_id = $(this).attr("data-value");
    let form = $("#form_edit_product")[0];
    let data = new FormData(form);
    data.append("product_id", product_id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/product-update",
        method: 'POST',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === "success") {
                window.location.href = response.url;
            } else {
                alert(response.message);
            }
        }
    })
})


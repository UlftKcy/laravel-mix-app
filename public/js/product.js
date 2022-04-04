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
        '                                   <div class="d-flex justify-content-center"><span class="text-success fw-bolder">' + product.price + ' TL</span></div>\n' +
        '                                    <div class="card-title fw-bolder text-truncate">\n' +
        '                                        ' + product.name + '\n' +
        '                                    </div>\n' +
        '                                    <p class="card-text text-truncate">\n' +
        '                                        ' + product.description + '\n' +
        '                                    </p>\n' +
        '                                </div>\n' +
        '                                <div class="card-footer d-flex flex-column">\n' +
        '                                <div class="d-flex justify-content-between mb-3">\n' +
        '                                    <button class="btn btn-primary" id="btn_add_product_to_basket" data-value="' + product.id + '">\n' +
        '                                        <i class="fa-solid fa-cart-plus"></i>\n' +
        '                                    </button>\n' +
        '                                   <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" style="width:150px;">\n' +
        '                                    <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-down rounded-0 btn-decrease"\n' +
        '                                               type="button">-\n' +
        '                                   </button>\n' +
        '                                   <input type="text" name="product_count"\n' +
        '                                           class="form-control text-center border border-dark product_quantity" value="0"/>\n' +
        '                                   <button class="btn btn-sm btn-outline-secondary bootstrap-touchspin-up rounded-0 btn-increase"\n' +
        '                                               type="button">+\n' +
        '                                   </button>\n' +
        '                                   </div>\n' +
        '                                </div>\n' +
        '                                <div class="d-flex justify-content-end">\n' +
        '                                    <a href="product-edit/' + product.id + '" role="button"\n' +
        '                                       class="btn btn-warning me-3" id="btn_product_edit">\n' +
        '                                        <i class="fa-solid fa-pen-to-square"></i>\n' +
        '                                    </a>\n' +
        '                                    <a href="product-delete/' + product.id + '" class="btn btn-danger"\n' +
        '                                       id="btn_product_delete">\n' +
        '                                        <i class="fa-solid fa-trash-can"></i>\n' +
        '                                    </a>\n' +
        '                                </div>\n' +
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
                $(".file_remove").click();
                form.reset();

            } else {
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
                window.location.href = response.url;
            } else {
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
            }
        }
    })
})

// increase and decrease product count

$("input[name=product_count]").prev("button").prop("disabled", true);
$(document).on("keypress", "input[name=product_count]", function (e) {
    let this_input = $(this);
    let this_input_val = this_input.val();
    this_input.val(this_input_val.replace(/[^0-9\.]/g, ''));
    if ((e.which !== 46 || this_input.val().indexOf('.') !== 1) && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
    }
})
$(document).on("keyup", "input[name=product_count]", function (e) {
    let this_input = $(this);
    let this_input_val = this_input.val();
    this_input.val(this_input_val);
    if (this_input_val > 0) {
        $(this).prev("button").prop("disabled", false);
    }
    if (this_input_val === "") {
        this_input.val(0);
        $(this).prev("button").prop("disabled", true);
    }
})
$(document).on("click", ".btn-decrease", function () {
    let chosen_input = $(this).next("input");
    let chosen_input_val = parseInt(chosen_input.val()) - 1;
    chosen_input.val(chosen_input_val);
    if (chosen_input_val === 0) {
        $(this).prop("disabled", true);
    }
});
$(document).on("click", ".btn-increase", function () {
    let chosen_input = $(this).prev("input");
    let chosen_input_val = parseInt(chosen_input.val()) + 1;
    chosen_input.val(chosen_input_val);
    if (chosen_input_val > 0) {
        $(this).prev().prev("button").prop("disabled", false);
    }
});

// basket operations

$(document).on("click", "#btn_add_product_to_basket", function () {
    let product_id = $(this).attr("data-value");
    let product_count_box = $(this).closest("div");
    let product_quantity = product_count_box.find(".product_quantity").val();

    let form_data = new FormData();
    form_data.append("product_id", product_id);
    form_data.append("product_quantity", product_quantity);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/add-product-to-basket",
        method: 'POST',
        data: form_data,
        dataType: 'json',
        processData: false,
        contentType: false,
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
                let product_count_in_basket = $("#product_count_in_basket")
                let product_count_in_basket_count = product_count_in_basket.text();
                product_count_in_basket_count = parseInt(product_count_in_basket_count)+parseInt(product_quantity);
                product_count_in_basket.text(product_count_in_basket_count);

            } else {
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
            }
        }
    })

})


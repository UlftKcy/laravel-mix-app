<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
    <div class="container">
        <a class="navbar-brand" href="#">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto w-100 justify-content-end">
                <li class="nav-item active">
                    <a class="nav-link d-flex align-items-center btn btn-secondary px-3 rounded text-white" href="#">Basket<span class="badge bg-warning ms-3" id="product_count_in_basket">{{$total_basket_quantity}}</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="btn_add_product_modal" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</a>
                </li>
            </ul>
            {{-- <form class="form-inline my-2 my-lg-0">
                 <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                 <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
             </form>--}}
        </div>
    </div>
</nav>


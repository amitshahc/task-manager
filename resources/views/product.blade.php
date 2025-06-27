<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="p-4">

    <div class="container">
        <h2 class="mb-4">Product Form</h2>

        <form id="productForm" class="row g-3 mb-5">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Product name" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity in stock" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price per item" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </form>

        <div id="productTable">
            @include('product_table', ['products' => $products])
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$('#productForm').on('submit', function(e) {
    e.preventDefault();
    let formData = $(this).serialize();

    $.post("{{ route('product.store') }}", formData, function(response) {
        if (response.success) {
            $('#productForm')[0].reset();
            loadTable();
        }
    });
});

function loadTable() {
    $.get("{{ route('product.index') }}", function(response) {
        let html = $(response).find('#productTable').html();
        $('#productTable').html(html);
    });
}
</script>

</body>
</html>
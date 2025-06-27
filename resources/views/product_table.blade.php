<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity in Stock</th>
            <th>Price per Item</th>
            <th>DateTime Submitted</th>
            <th>Total Value</th>
        </tr>
    </thead>
    <tbody>
        @php $sumTotal = 0; @endphp
        @foreach($products as $product)
            @php $sumTotal += $product['total']; @endphp
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>${{ number_format($product['price'], 2) }}</td>
                <td>{{ $product['datetime'] }}</td>
                <td>${{ number_format($product['total'], 2) }}</td>
            </tr>
        @endforeach
        <tr class="table-secondary fw-bold">
            <td colspan="4" class="text-end">Sum Total:</td>
            <td>${{ number_format($sumTotal, 2) }}</td>
        </tr>
    </tbody>
</table>

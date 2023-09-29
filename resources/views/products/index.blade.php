@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Products</h2>
        </div>
        <div class="pull-right">
            @can('product-create')
            <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            @endcan
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
    <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Unit Type</th>
        <th>Price</th>
        <th>Images_1</th>
        <th>Discount Percentage</th>
        <th>Discount Amount</th>
        <th>Discount Start Date</th>
        <th>Discount End Date</th>
        <th>Tax Percentage</th>
        <th>Tax Amount</th>
        <th>Created</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->unit_type }}</td>
        <td>{{ $product->price }}</td>
        <td>
            @if($product->image1)
            <img src="{{ asset('storage/images/'.$product->image1) }}" style="height: 100px; width: 100px;" />
            @else
            <span>No image found!</span>
            @endif
        </td>

        <td>{{ $product->discount_percentage }}</td>
        <td>{{ $product->discount_amount }}</td>
        <td>{{ $product->discount_start_date }}</td>
        <td>{{ $product->discount_end_date }}</td>
        <td>{{ $product->tax_percentage }}</td>
        <td>{{ $product->tax_amount }}</td>
        <td>{{ $product->created_at }}</td>
        <td>

            <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
            @can('product-edit')
            <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
            @endcan


            @can('product-delete')
            <button type="button" class="btn btn-danger delete-product" data-id="{{ $product->id }}">Delete</button>
            @endcan

        </td>
    </tr>
    @endforeach
</table>

{!! $products->links() !!}

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delete-product").click(function() {
            var productId = $(this).data('id');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: "/products/" + productId,
                    type: 'DELETE',
                    data: {
                        '_token': csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            // Optionally, you can remove the deleted product from the UI
                            $("#product-" + productId).remove();
                            alert(response.message);
                            location.reload();
                        } else {
                            alert("An error occurred while deleting the product.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert("An error occurred while deleting the product.");
                    }
                });
            }
        });
    });
</script>
@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2> Show Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div>

<form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{$product->name}}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Unit Type:</strong>
                <select name="unit_type" class="form-control">
                    <option value="Qty" {{ $product->unit_type == 'Qty' ? 'selected' : '' }}>Qty</option>
                    <option value="Ltr" {{ $product->unit_type == 'Ltr' ? 'selected' : '' }}>Ltr</option>
                    <option value="KG" {{ $product->unit_type == 'KG' ? 'selected' : '' }}>KG</option>
                    <option value="Meter" {{ $product->unit_type == 'Meter' ? 'selected' : '' }}>Meter</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="categories">Product Categories</label>
            <select name="categories[]" id="categories" class="form-control" multiple>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $pc->pluck('categories')->flatten()->contains('id', $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>



        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" name="price" value="{{ $product->price}}" class="form-control" placeholder="Price">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>Images:</strong>
            @if($product->image1)
            <img src="{{ asset('storage/images/'.$product->image1) }}" style="height: 100px; width: 100px;" />
            @else
            <span>No image found!</span>
            @endif
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Discount Percentage:</strong>
            <input type="number" name="discount_percentage" value="{{ $product->discount_percentage}}"
                class="form-control" placeholder="Discount Percentage">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Discount Amount:</strong>
            <input type="number" name="discount_amount" value="{{ $product->discount_amount}}" class="form-control"
                placeholder="Discount Amount">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Discount Start Date:</strong>
            <input type="date" name="discount_start_date" value="{{ $product->discount_start_date}}"
                class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Discount End Date:</strong>
            <input type="date" name="discount_end_date" value="{{ $product->discount_end_date}}" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Tax Percentage:</strong>
            <input type="number" name="tax_percentage" value="{{ $product->tax_percentage}}" class="form-control"
                placeholder="Tax Percentage">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Tax Amount:</strong>
            <input type="number" name="tax_amount" value="{{ $product->tax_amount}}" class="form-control"
                placeholder="Tax Amount">
        </div>
    </div>
    <div class="form-group">
        <label for="quantity"><strong>Stock Entry: In Stock with Quantity No’s</strong></label>
        <input type="text" name="quantity" id="quantity" value="" class="form-control" placeholder="Enter quantity">
    </div>



    <div id="formMessages" class="alert" style="display: none;"></div>

</form>
@endsection
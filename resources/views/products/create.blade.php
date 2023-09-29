@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div>
</div>


@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Unit Type:</strong>
                <select name="unit_type" class="form-control">
                    <option value="Qty">Qty</option>
                    <option value="Ltr">Ltr</option>
                    <option value="KG">KG</option>
                    <option value="Meter">Meter</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="categories">Product Category :</label>
            <select name="categories[]" id="categories" class="form-control" multiple>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" name="price" class="form-control" placeholder="Price">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image 1:</strong>
                <input type="file" name="image1" class="form-control-file">
            </div>
        </div>



        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount Percentage:</strong>
                <input type="number" name="discount_percentage" class="form-control" placeholder="Discount Percentage">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount Amount:</strong>
                <input type="number" name="discount_amount" class="form-control" placeholder="Discount Amount">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount Start Date:</strong>
                <input type="date" name="discount_start_date" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Discount End Date:</strong>
                <input type="date" name="discount_end_date" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tax Percentage:</strong>
                <input type="number" name="tax_percentage" class="form-control" placeholder="Tax Percentage">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tax Amount:</strong>
                <input type="number" name="tax_amount" class="form-control" placeholder="Tax Amount">
            </div>
        </div>
        <div class="form-group">
            <label for="quantity"> <strong>Stock Entry: In Stock with Quantity No’s </strong></label>
            <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity">
        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>


</form>

@endsection
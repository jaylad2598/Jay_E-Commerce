@extends('layouts.admin')

@section('content')

<a style="float:right" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card" style="margin:50px">
                        <div class="card-header">
                            Update Product
                        </div>
                        <div class="card-body">

                            <form method="POST" action="/product/update/{{ $product->id }}" enctype="multipart/form-data">
                                @csrf
                                <div class="from-group" style="padding:5px">
                                    <label>Product Name</label>
                                    <input type="text" name="productname" value="{{ $product->name }}" class="form-control" placeholder="Enter Product Name" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                <label>Product Category</label>
                                <select name="productcategory">
                                    @foreach($category as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                </div>


                                <div class="from-group" style="padding:5px">
                                    <label>Product Price</label>
                                    <input type="text" name="productprice" value="{{ $product->price }}" class="form-control" placeholder="Enter Product Price" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                    <label>Product Description</label>
                                    <input type="text" name="productdescription" value="{{ $product->description }}" class="form-control" placeholder="Enter Product Description" />
                                </div>


                                <button type="submit">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

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
                                    <lable>Product Name</lable>
                                    <input type="text" name="productname" value="{{ $product->name }}" class="form-control" placeholder="Enter Product Name" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                <lable>Product Category</lable>
                                    <select name="productcategory">
                                        <option value="samsung">Samsung</option>
                                        <option value="apple">Apple</option>
                                        <option value="vivo">Vivo</option>
                                    </select>
                                </div>

                                
                                <div class="from-group" style="padding:5px">
                                    <lable>Product Price</lable>
                                    <input type="text" name="productprice" value="{{ $product->price }}" class="form-control" placeholder="Enter Product Price" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                    <lable>Product Description</lable>
                                    <input type="text" name="productdescription" value="{{ $product->description }}" class="form-control" placeholder="Enter Product Description" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                        <lable>Product Status</lable>    
                                        <select name="productstatus">
                                        <option value="available">Available</option>
                                        <option value="Unavailable">Unavailable</option>
                                    </select>
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

@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')
<section>
        <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="row card-header">
                  <div class="col-md-8">
                    <h3 class="card-title">Product Details</h3>
                  </div>
                  <div class="col-md-3">
                        <a class="nav-link" href="/cart-index">
                            <i class="fa fa-shopping-cart float-right" style="font-size: 30px" aria-hidden="true"></i>
                        </a>
                  </div>
              </div>

              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>description</th>
                      <th>Image</th>
                      <th>Cart</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($activeproduct as $activeproducts)
                    <tr data-widget="expandable-table" aria-expanded="false">
                      <td>{{ $activeproducts->name }}</td>
                      <td>{{ $activeproducts->category }}</td>
                      <td>{{ $activeproducts->price }}</td>
                      <td>{{ $activeproducts->description }}</td>
                      <td><img src="{{ asset('img/'.$activeproducts->image) }}" height="100px" width="100px"></td>

                      <td>
                        <form action="add_to_cart" method="post">
                          @csrf
                          <input type="hidden" name="productid" value="{{ $activeproducts->id }}">
                                    <button class="fa fa-shopping-cart">Cart</button>
                        </form>

                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        </div>

    </section>
@endsection

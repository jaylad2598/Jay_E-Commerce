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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View Order Details</h3>
              </div>
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>User Id</th>
                      <th>Product Id</th>
                      <th>Status</th>
                      <th>Payment</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($orders as $order)
                    <tr class="todo-{{$order['id']}}" id="{{ $order->id }}" data-widget="expandable-table" aria-expanded="false">
                      <td>{{ $order->userid }}</td>
                      <td>{{ $order->productid }}</td>
                      <td>{{ $order->status }}</td>
                      <td>{{ $order->payment }}</td>

                    </tr>
                    @endforeach
                  </tbody>

                </table>

              </div>
              <span>{{ $orders->links()}}</span>
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
          </div>
        </div>


        </div>

    </section>
@endsection

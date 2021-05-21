@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')

   <section>
        <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Details</h3>
              </div>
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Price</td>
                            <td>{{ $total }}</td>
                        </tr>

                        <tr>
                            <td>Delivery Charge </td>
                            <td>100</td>
                        </tr>

                        <tr>
                            <td>Total Payable Amount</td>
                            <td style="font-weight: bold;">{{ $total + 100}}</td>
                        </tr>
                    </tbody>
                </table>
                <form action="/orderplaced" method="POST">
                @csrf
                    <div class="form-group">
                        <lable>Payment Mode</lable></br>
                        <p><input type="radio" value="online" name="payment"><spam>Online Payment</spam></p>
                        <p><input type="radio" value="cash" name="payment"><spam>Cash On Delivery</spam></p>
                        <p><input type="radio" value="EMI" name="payment"><spam>Emi System</spam></p>
                    </div>

                    <div>
                        <button class="btn btn-primary" style="margin-top:5px">Payment</button>
                    </div>
                </form>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        
        </div>
    </section>
@endsection

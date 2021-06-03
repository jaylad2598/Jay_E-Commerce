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
                <h3 class="card-title">View Product Details</h3>



                <a href="/add-product" style="float:right">Add Product</a><br><br>

                <h4 class="card-title" style="float:right">Total Product Is : {{ $totalproduct }}</h4><br>
                <h4 class="card-title" style="float:right">Total Avaliable Product : {{ $avaliable }}</h4><br>
                <h4 class="card-title" style="float:right">Total Unavaliable Product : {{ $unavaliable }}</h4>

              </div>

            <div>
                <form action="" method="get">
                    <label>Search  Data : </label>
                    <input type="text" id="searchproduct" name="searchproduct" placeholder="Search........" />
                    <button name="submit">Submit</button>
                </form>

                <form action="" method="get">
                    @csrf
                    <label>Filter Category</label>
                        <select name="filterdata">
                            <option value="samsung">Samsung</option>
                            <option value="apple">Apple</option>
                            <option value="vivo">Vivo</option>
                        </select>
                        <button name="submit">Submit</button>
                </form>

            </div>

              <div>
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Data"/>
              </div>
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>description</th>
                      <th>status</th>
                      <th></th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                    <tr class="todo-{{$product['id']}}" id="{{ $product->id }}" data-widget="expandable-table" aria-expanded="false">
                      <td>{{ $product->id }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->category }}</td>
                      <td>{{ $product->price }}</td>
                      <td>{{ $product->description }}</td>

                      <td>
                    @if($product->status === "Avaliable")
                        <span style="color:green;" id="status_{{ $product->id }}">Avaliable</span>

                    @else
                        <span style="color:red;" id="status_{{ $product->id }}">Unavailable</span>
                    @endif
                </td>

                <td>
                    @if($product->status === "Avaliable")
                        <input type="checkbox" id="ChkStatus_{{ $product->id }}" name="status" checked class="chkStatus">
                    @else
                        <input type="checkbox" id="ChkStatus_{{ $product->id }}" name="status" class="chkStatus">
                    @endif
                </td>

                      <td>
                        <a href="/edit-product/{{ $product->id }}" class="fas fa-edit"></a>
                        <a style="margin-top: 5px;" href="#" class="fas fa-trash-alt delete_btn"></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
             <span>{{ $products->links() }}</span>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>


        </div>

    </section>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('.delete_btn').click(function()
        {
            var id = $(this).parents("tr").attr("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : "GET",
                        url : "/product/delete/"+id,
                        success: function (response){
                            Swal.fire({
                                position: 'top-middle',
                                icon: 'success',
                                title: 'Record deleted successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('.todo-'+id).empty();
                        }
                    });
                }
            })
        });

        $('.chkStatus').change(function (){
            var id = $(this).parents("tr").attr("id");

            if($('#ChkStatus_'+id).is(':checked'))
            {
                status = 'Avaliable';
            }
            else
            {
                status = 'Unavaliable';
            }

            $.ajax({
                type : "GET",
                url : "/product/status/"+id,
                data : {
                    id:id,
                    status:status
                },
                success:function (){
                    if(status == "Avaliable"){
                        $('#status_'+id).css('color','green');
                    }
                    else{
                        $('#status_'+id).css('color','red');
                    }
                    $('#status_'+id).text(status);
                },
            });
        });




    });
</script>

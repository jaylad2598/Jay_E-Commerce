@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')

   <section>
        <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cart Details</h3>
              </div>
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>description</th>
                      <th>Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($product as $prd)
                    <tr class="todo-{{$prd->id}}" id="{{ $prd->id }}" data-widget="expandable-table" aria-expanded="false">
                      <td> {{ $prd->name }}</td>
                      <td>{{ $prd->description}}</td>
                      <td>{{ $prd->price }}</td>
                      <td>
                        <a style="margin-top: 5px;" href="#" class="fa fa-trash-o delete_btn"></a>
                        
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
               <a class="btn btn-success" href="/ordernow" style="float:right;margin-top:5px">OrderNow</a>
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
                        url : "/cart-delete/"+id,
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

    });
</script>
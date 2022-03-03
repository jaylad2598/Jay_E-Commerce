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
                            Update User
                        </div>
                        <div class="card-body">
                            
                            <form method="POST" action="/update/{{ $user->id }}" enctype="multipart/form-data"> 
                                @csrf
                                <div class="from-group" style="padding:5px">
                                    <lable>User Name</lable>
                                    <input type="text" name="username" value="{{ $user->name }}" class="form-control" placeholder="Enter User Name" />
                                </div>

                                <div class="from-group" style="padding:5px">
                                    <lable>User Email</lable>
                                    <input type="text" name="useremail" value="{{ $user->email }}" class="form-control" placeholder="Enter User Email" />
                                </div>

                                <button type="submit">Update User</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

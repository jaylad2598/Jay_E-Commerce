@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')
   @foreach($product as $prd)
        {{ $prd->id }}
        {{ $prd->name }}
        {{ $prd->price }}
   @endforeach
@endsection

<!-- index.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Plant Items</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />    
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
<body>

 <div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
              @endforeach
        </ul>
      </div>
    @endif        
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif
  
    
    <h2>Plant Items for {{ $area->name }}</h2>

    <form method="post" action="{{action('ItemController@update', $id)}}" enctype="multipart/form-data">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
      <div class="row">
        <div class="col-md-12"></div>
          <div class="form-group col-md-4">
            <label for="name">Name:</label>
            <input type="text" size="32" maxlength="64" class="form-control" name="name" readonly value="{{$item->name}}">
          </div>
        
          <div class="form-group col-md-4">                 
             <label for="type">Type:</label>
            <select name="type" class="form-control">
            <option value="{{$item->type}}">{{$item->type}}</option>
                
                  <option > Annual </option>   
                  <option > Bulb </option>  
                  <option > Ground Cover </option> 
                  <option > Herb </option> 
                  <option > Perennial </option> 
                  <option > Tree </option> >              
            </select>
          </div>
          <div class="form-group col-md-4">                 
             <label for="rating">Rating:</label>
            <select name="rating" class="form-control">
            <option value="{{$item->rating}}">{{$item->rating}}</option>
                
                  <option > 5 </option>   
                  <option > 4 </option> 
                  <option > 3 </option> 
                  <option > 2 </option> 
                  <option > 1 </option> 
               
            </select>
          </div>
          <div class="form-group col-md-3">
              <label for="photo">Plant Avatar Location:</label>
              <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="photo" value="{{$item->photo}}"></input>
          </div>

          <div class="form-group col-md-4">
            <label for="comment">Comment:</label>
            <input type="text" size="32" maxlength="64" class="form-control" name="comment" value="{{$item->comment}}">
          </div>
                   
      </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/items/{{$param}}" class="btn btn-warning">Back to Plant Items</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection
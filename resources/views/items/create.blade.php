<!-- index.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Clubs</title>
    
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
  
    <h2>Plants for {{ $area->name }}</h2>
        
    <form method="post" action="{{action('ItemController@store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4">
            <label for="name">Name:</label>
            <input type="text" size="32" maxlength="64" class="form-control" name="name" required ></input>
          </div>
         <!-- <div class="form-group col-md-4">
            <label for="type">Type:</label>
            <input type="text" class="form-control" name="type"></input>
          </div>
          -->
          <div class="form-group col-md-4">                 
             <label for="type">Type:</label>
            <select name="type" class="form-control" required>
              <option value="">Select Plant Type</option>
                
                  <option > Annual </option>   
                  <option > Bulb </option>  
                  <option > Ground Cover </option> 
                  <option > Herb </option> 
                  <option > Perennial </option> 
                  <option > Tree </option> 
                               
            </select>
          </div>
         <!-- <div class="form-group col-md-4">
            <label for="rating">Rating:</label>
            <input type="number" class="form-control" name="rating" min="1" max="5" ></input>
          </div>
          -->
          <div class="form-group col-md-4">                 
             <label for="rating">Rating:</label>
            <select name="rating" class="form-control">
              <option value="1">Select Rating 5-Best 1-Worst</option>
                
                  <option > 5 </option>   
                  <option > 4 </option> 
                  <option > 3 </option> 
                  <option > 2 </option> 
                  <option > 1 </option> 
               
            </select>
          </div>


          <div class="form-group col-md-3">
              <label for="photo">Plant Avatar Location:</label>
              <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="photo"></input>
            </div>

          <div class="form-group col-md-4">
            <label for="comment">Comment:</label>
            <input type="text" size="32" maxlength="64" class="form-control" name="comment"  ></input>
          </div>
        
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="/items/{{$param}}" class="btn btn-warning">Back to Plant Items</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

</body>

</html>
@endsection
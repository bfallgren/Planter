<!-- edit.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>PlantScape - Needs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
  <body>

    <div class="container">
              
        @if (\Session::has('success'))
          <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
          </div>
        @endif
      
          <h2>Update Need</h2>
        
        <form method="post" action="{{action('NeedController@update', $id)}}">
          @csrf
          <input name="_method" type="hidden" value="PATCH">
          
          <div class="row">      
              <div class="form-group col-md-4">
                <label for="ph">PH:</label>
                <input type="text" class="form-control" name="ph"  maxlength="16" value="{{$need->ph}}" ></input>
              </div>

              <div class="form-group col-md-4">
                <label for="water">Water:</label>
                <input type="text" class="form-control" name="water"  maxlength="16" value="{{$need->water}}" ></input>
              </div>

              <div class="form-group col-md-4">
                <label for="soil">Soil:</label>
                <input type="text" class="form-control" name="soil"  maxlength="16" value="{{$need->soil}}" ></input>
              </div>
                
              <div class="form-group col-md-3">                 
                <label for="light">Light:</label>
                <select name="light" class="form-control">
                <option value="{{$need->light}}">{{$need->light}}</option>
                    
                      <option > Part Shade </option>      
                      <option > Part Sun </option> 
                      <option > Full Shade </option> 
                      <option > Full Sun </option> 
                                                
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="fertilizer">Fertilizer:</label>
                <input type="text" class="form-control" name="fertilizer"  maxlength="64" value="{{$need->fertilizer}}" ></input>
              </div>   

               
            </div>
        
            <div class="row">
              <div class="col-md-12"></div>
              <div class="form-group col-md-4" style="margin-top:10px">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="/needs/{{$param}}" class="btn btn-warning">Back to Needs</a>
              </div>
            </div>
          </form>
        </div>
    </div> <!-- container / end -->

  </body>
  
</html>
@endsection
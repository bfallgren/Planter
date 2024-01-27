<!-- create.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Plantscape</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
  <body>

    <div class="container">
              
        @if (\Session::has('success'))
          <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
          </div>
        @endif

        @if (!empty($alertMsg))
          <div class="alert alert-danger">
            <p>{{ $alertMsg }}</p>
          </div>
        @endif
      
        <h2> New Property </h2>
        
        
        <form method="post" action="{{action('PropController@store')}}">
            @csrf
            <div class="row">      
              <div class="form-group col-md-4">
                <label for="color">Color:</label>
                <input type="text" class="form-control" name="color"  maxlength="16" required></input>
              </div>

              <div class="form-group col-md-4">
                <label for="height_fr">Height(from):</label>
                <input type="number" class="form-control" name="height_fr"></input>
              </div>

              <div class="form-group col-md-4">
                <label for="height_to">Height(to):</label>
                <input type="number" class="form-control" name="height_to"></input>
              </div>

              <div class="form-group col-md-4">
                <label for="width_fr">width(from):</label>
                <input type="number" class="form-control" name="width_fr"></input>
              </div>

              <div class="form-group col-md-4">
                <label for="width_to">Width(to):</label>
                <input type="number" class="form-control" name="width_to"></input>
              </div>

              <div class="form-group col-md-4">
                <label for="flowering_time">Flowering Time:</label>
                <input type="text" class="form-control" name="flowering_time"  maxlength="64" ></input>
              </div>
                
              <div class="form-group col-md-3">                 
                <label for="trimming_mo">Trimming Month:</label>
                <select name="trimming_mo" class="form-control">
                  <option value="">Select Trimming Month</option>
                    
                      <option > Jan </option>      
                      <option > Feb </option> 
                      <option > Mar </option> 
                      <option > Apr </option> 
                      <option > May </option>      
                      <option > Jun </option> 
                      <option > Jul </option> 
                      <option > Aug </option> 
                      <option > Sep </option>      
                      <option > Oct </option> 
                      <option > Nov </option> 
                      <option > Dec </option> 
                                                
                </select>
              </div>
               
            </div>

            <div class="row">
              <div class="col-md-12"></div>
                <div class="form-group col-md-4" style="margin-top:10px">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <a href="/props/{{$param}}" class="btn btn-warning">Back to Properties</a>
                </div>
            </div>
          </form>
        </div>
    </div> <!-- container / end -->



  </body>
  
</html>
@endsection
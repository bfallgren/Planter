<!-- edit.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>PlantScape - Events</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />    
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
<body>

 <div class="container">
          
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif
  
      <h2>Update Event</h2>
    
    <form method="post" action="{{action('EventController@update', $id)}}">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
      
      <div class="row">      
           
            <div class="form-group col-md-4">
              <label for="plant">Plant:</label>
              <input type="text" class="form-control" name="plant" readonly value="{{$item_event->name}}" ></input>
            </div>

            <div class="form-group col-md-4">
              <label for="entered_at">Date:</label>
              <input type="date" class="form-control" name="entered_at" required value="{{$event->entered_at}}" ></input>
            </div>
           
        </div>

        <div class="row">
          <div class="form-group col-md-4">                 
              <label for="activity_type">Activity:</label>
              <select name="activity_type" class="form-control" value="{{$event->activity_type}}" > 
                <option value="{{$event->activity_type}}">{{$event->activity_type}}</option>
                  
                    <option > Fertilizer </option>      
                    <option > Growing </option> 
                    <option > Planting </option> 
                    <option > Trimming </option> 
                                              
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="qty_used">Quantity:</label>
              <input type="text" class="form-control" name="qty_used" size = "32" maxlength="32" value="{{$event->qty_used}}" ></input>
            </div>

            <div class="form-group col-md-4">
              <label for="descr">Description:</label>
              <input type="textarea" class="form-control" name="descr" maxlength="255" required value="{{$event->descr}}" ></input>
            </div>
        </div>
     
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/events" class="btn btn-warning">Back to Events</a>
          </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->


</body>

</html>
@endsection
<!-- create.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>Clubs</title>
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

    @if (!empty($alertMsg))
      <div class="alert alert-danger">
        <p>{{ $alertMsg }}</p>
      </div>
    @endif
  
    <h2> New Event </h2>
    
    
    <form method="post" action="{{action('EventController@store')}}">
        @csrf
        <div class="row">      
            <div class="form-group col-md-4">
              <label for="plant">Plant:</label>
              <select name="plant" required class="form-control" id="mySelect" >
                <option value="">--Select Plant--</option>
                  @foreach ($plant as $plant => $value)
                    <option > {{ $value }}</option>   
                  @endforeach
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="entered_at">Date:</label>
              <input type="date" class="form-control" name="entered_at" required ></input>
            </div>

            
        </div>

        <div class="row">
          <div class="form-group col-md-4">                 
              <label for="activity_type">Activity:</label>
              <select name="activity_type" class="form-control" required>
                <option value="">Select Activity Type</option>
                  
                    <option > Fertilizer </option>      
                    <option > Growing </option> 
                    <option > Planting </option> 
                    <option > Trimming </option> 
                                              
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="qty_used">Quantity:</label>
              <input type="text" class="form-control" name="qty_used" size = "32" maxlength="32" ></input>
            </div>

            <div class="form-group col-md-4">
              <label for="descr">Description:</label>
              <input type="textarea" class="form-control" name="descr" maxlength="255" required ></input>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12"></div>
            <div class="form-group col-md-4" style="margin-top:10px">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="/events" class="btn btn-warning">Back to Events</a>
            </div>
        </div>
      </form>
    </div>
</div> <!-- container / end -->

<script type="text/javascript">
  jQuery(document).ready(function()
  {
    jQuery('select[name="plant"]').on('change',function() {
      
     var plantName = jQuery(this).val();
     if (plantName)
      {
        var cid = null;
        jQuery.ajax({
          url : '/events/getPlantID/' +courseName,
          type : "GET",
          dataType : "json",
          success:function(data)
          {
            cid = data;
            
          }
      }
        
  });    

  </script>

</body>

</html>
@endsection
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
      
        <h2> New Task </h2>
        
        
        <form method="post" action="{{action('TaskController@store')}}">
            @csrf
            <div class="row">      
                <div class="form-group col-md-3">
                  <label for="plant">Plant:</label>
                  <select name="plant" class="form-control" id="mySelect" >
                    <option value="">--Select Plant--</option>
                      @foreach ($plant as $plant => $value)
                        <option > {{ $value }}</option>   
                      @endforeach
                  </select>
                </div>

                

                <div class="form-group col-md-3">                 
                  <label for="activity_type">Activity:</label>
                  <select name="activity_type" class="form-control">
                    <option value="">Select Activity Type</option>
                      
                        <option > Fertilizer </option>      
                        <option > Flowering </option> 
                        <option > Planting </option> 
                        <option > Trimming </option> 
                                                  
                  </select>
                </div>

                <div class="form-group col-md-3">                 
                  <label for="recurring">Recurring:</label>
                  <select name="recurring" class="form-control">
                    <option value="">Select Recurring Type</option>
                      
                        <option > Daily </option> 
                        <option > Weekly </option> 
                        <option > Monthly </option>     
                        <option > Quarterly </option>
                        <option > Annually </option>
                        <option > Biannually </option>
                        <option > None </option> 
                                                  
                  </select>
                </div>     

                <div class="form-group col-md-3">
                  <label for="start_date">Start Date:</label>
                  <input id="datepicker" type="text" class="form-control" name="start_date" required ></input>
                </div>

                
            </div>

            <div class="row">
              
                <div class="form-group col-md-6">
                  <label for="descr">Description:</label>
                  <input type="textarea" class="form-control" name="descr" maxlength="64" required ></input>
                </div>

                <div class="form-group col-md-4">                 
                  <label for="status">Status:</label>
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                      
                        <option > Complete </option> 
                        <option > Ongoing </option> 
                        <option > Overdue </option> 
                        <option > Pending Product </option>     
                        <option > Other </option> 
                                                  
                  </select>
                </div>         
                
            </div>

            <div class="row">
              <div class="col-md-12"></div>
                <div class="form-group col-md-4" style="margin-top:10px">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <a href="/tasks" class="btn btn-warning">Back to Tasks</a>
                </div>
            </div>
          </form>
        </div>
    </div> <!-- container / end -->



  </body>
  <script>
      $( function() {
        $( "#datepicker" ).datepicker({dateFormat: 'mm(M)-dd'});
      } );
  </script>
</html>
@endsection
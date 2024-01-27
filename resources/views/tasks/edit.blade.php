<!-- edit.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>PlantScape - Tasks</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
  <body>

    <div class="container">
              
        @if (\Session::has('success'))
          <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
          </div>
        @endif
      
          <h2>Update Task</h2>
        
        <form method="post" action="{{action('TaskController@update', $id)}}">
          @csrf
          <input name="_method" type="hidden" value="PATCH">
          
          <div class="row">      
              
                <div class="form-group col-md-3">
                  <label for="plant">Plant:</label>
                  <input type="text" class="form-control" name="plant" readonly value="{{$item_task->name}}" ></input>
                </div>

                <div class="form-group col-md-3">                 
                  <label for="activity_type">Activity:</label>
                  <select name="activity_type" class="form-control" value="{{$task->activity_type}}" > 
                    <option value="{{$task->activity_type}}">{{$task->activity_type}}</option>
                      
                        <option > Fertilizer </option>      
                        <option > Flowering </option> 
                        <option > Planting </option> 
                        <option > Trimming </option> 
                                                  
                  </select>
                </div>

                <div class="form-group col-md-3">                 
                  <label for="recurring">Recurring:</label>
                  <select name="recurring" class="form-control">
                  <option value="{{$task->recurring}}">{{$task->recurring}}</option>
                      
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
                  <input id="datepicker" type="text" class="form-control" name="start_date" required value="{{$task->start_date}}" ></input>
                </div>
              
            </div>

            <div class="row">
              
                <div class="form-group col-md-6">
                      <label for="descr">Description:</label>
                      <input type="textarea" class="form-control" name="descr" maxlength="100" required value="{{$task->descr}}" ></input>
                    </div>
            

                <div class="form-group col-md-4">                 
                  <label for="status">Status:</label>
                  <select name="status" class="form-control" value="{{$task->status}}" > 
                    <option value="{{$task->status}}">{{$task->status}}</option>
                      
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
                <button type="submit" class="btn btn-success">Update</button>
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
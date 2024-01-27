<!-- index.blade.php -->
@extends('layout')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>PlantScape - Events</title>
     
    </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h5>{{ __('Events') }}</h5>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" style="font-weight: 500" href="{{ route('events.create') }}"> Create Event</a>
            <a class="btn btn-success" style="font-weight: 500" href="{{ url('showCal') }}"> Show Calendar</a>
          </div>
          
        </div>
      </div> 
      
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <div class="card-body">

         
          <table style=width:100% class="row-border table" id="datatable-crud">
            <thead style=color:green>
              <tr>
                <th>Plant</th>
                <th>Date</th>
                <th>Activity</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>

      </div>


      <!-- Delete Area Modal -->


<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this record?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </sdiv>
    </div>
</div>

  </body>

 

<script type="text/javascript">

  
 $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#datatable-crud').DataTable({
           
           processing: true,
           serverSide: false, /* disabled for sql join */
           "info": false,
                     
           ajax: "{{ url('events') }}",
           columns: [
                                       
                    { data: 'name', name: 'items.name', orderable: true, searchable: true, visible: true},
                    { data: 'entered_at', name: 'entered_at' },
                    { data: 'activity_type', name: 'date_played' },
                    { data: 'descr', name: 'descr' },
                    { data: 'qty_used', name: 'qty_used' },
                   
                    {data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"30%"},
                    { "targets": 1, "width":"10%"},
                    { "targets": 2, "width":"10%"},
                    { "targets": 4, "width":"10%"},
                    { "targets": 5, "width":"10%"}
                  ],

                 order: [[1, 'desc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
    //console.log('table :', table);

    $('#datatable-crud').on('click', 'tr', function() {
    table.row(this).nodes().to$().addClass('larger-font')
    }) ;     
    var row_id;
    var $tr;
    var $button = $(this);

    // Delete action
    $(document).on('click', '.deleteButton', function(){
        row_id = $(this).attr('id');
        $tr = $(this).closest('tr'); //here we hold a reference to the clicked tr which will be later used to delete the ro
        $('#deleteModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       
            type: "POST",
            data:{
            _method:"DELETE"
            },
            url:"/events/" + row_id,
         
        });
            $.ajax({
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
            success:function(data)
            {
                setTimeout(function(){
                    $('#deleteModal').modal('hide');
                    $tr.find('td').fadeOut(1000,function(){ 
                            $tr.remove();   
                          }); 
                       
                  // $('#datatable-crud').DataTable().ajax.reload(); 
                  // DataTables warning: table id=datatable-crud - Invalid JSON response. 
                }, 1000);
            }
        });
    });


});

  

</script>
</html>  

@endsection
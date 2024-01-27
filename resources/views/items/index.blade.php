<!-- index.blade.php -->
@extends('layout')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>PlantScape - Items</title>
     
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
  </head>
  <body>

  <div class="container">
          
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif
  
    <h2>Plant Items for {{ $area->name }} </h2>
    <div class="form-group col-md-4">
        <input type="hidden" name="area_id" id="area_id" value="{{$area->id}}">
    </div>        
    
    <div class="row"> 
      <div class="col-lg-9 margin-tb">
          <div class="pull-right mb-2">
            <a class="btn btn-success" style="font-weight: 500" href="{{ route('items.create') }}"> Create Item</a>
          </div>
        </div>
      <div class="col-md-3">
          <a href="/areas" class="btn btn-warning">Back to Plant Areas</a>
      </div>
    </div>
     
    <div class="card-body">
      
      <table style=width:100% class="row-border table" id="datatable-crud">
        <thead style=color:green>
          <tr>
          
            <th>Name</th>
            <th>Type</th>
            <th>Rating</th>
            <th>Photo</th>
            <th>Comment</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>

    </div>
 </div> <!-- container / end -->
 
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
              
            ajax: {
              "url": "items",  
              "data": function ( d ) {                 
                  d.item = $('#area_id').val();      
                } 
                      
          },
           
           columns: [
                                  
                    { data: 'name', name: 'items.name', orderable: true, searchable: true, visible: true},
                    { data: 'type', name: 'type' },
                    { data: 'rating', name: 'rating' },
                    { data: 'photo', name: 'photo' }, 
                    { data: 'comment', name: 'comment'},                 
                    { data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"30%"},
                    { "targets": 1, "width":"10%"},
                    { "targets": 2, "width":"10%"},
                    { "targets": 3, render: function(data) {
                      return '<a href="/images/'+data+'" target="_blank"> <img src="/images/'+data+'" alt="" title="Click to open in new window" style="width: 100px;height: 100px;vertical-align:middle;border-style: none;"> </a>';
                      
                      //  return '<img src="/images/'+data+'"style="height:50px;width:100px;"/>';
                      }},
                    { "targets": 4, "width":"30%"},
                    { "targets": 5, "width":"10%"}
                  ],

                 order: [[0, 'asc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
    
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
      console.log('deleting ',row_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       
            type: "POST",
            data:{
            _method:"DELETE"
            },
            url:"/items/" + row_id,
         
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
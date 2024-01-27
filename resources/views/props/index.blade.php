<!-- index.blade.php -->
@extends('layout')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>PlantScape - Props</title>
     
    </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h5>{{ __('Properties') }}</h5>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="pull-right mb-9">
              <a class="btn btn-success" style="font-weight: 500" href="{{ route('props.create') }}"> Create Properties</a>
        </div>
        <div class="col-md-3">
          <a href="/items/{{$areaID}}" class="btn btn-warning">Back to Plant Item</a>
        </div>
      </div> 
      
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <h2>Plant Properties for {{ $item->name }} </h2>
      <div class="form-group col-md-4">
          <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}">
      </div> 

      <div class="card-body">

         
          <table style=width:100% class="row-border table" id="datatable-crud">
            <thead style=color:green>
              <tr>
                <th>Plant</th>
                <th>Color</th>
                <th>Height(from)</th>
                <th>Height(to)</th>
                <th>Width(from)</th>
                <th>Width(to)</th>
                <th>Flowering Time</th>
                <th>Trimming Month</th>
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
                     
            ajax: {
              "url": "props",  
              "data": function ( d ) {                 
                  d.prop = $('#item_id').val();      
                } 
                      
          },
           columns: [
                                       
                    { data: 'name', name: 'items.name', orderable: true, searchable: true, visible: true}, 
                    { data: 'color', name: 'color' },
                    { data: 'height_fr', name: 'height_fr' },
                    { data: 'height_to', name: 'height_to' },
                    { data: 'width_fr', name: 'width_fr' },
                    { data: 'width_to', name: 'width_to' },
                    { data: 'flowering_time', name: 'flowering_time' },
                    { data: 'trimming_mo', name: 'trimming_mo' },
                    {data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"20%"},
                    { "targets": 1, "width":"20%"},
                    { "targets": 2, "width":"5%"},
                    { "targets": 3, "width":"5%"},
                    { "targets": 4, "width":"5%"},
                    { "targets": 5, "width":"5%"},
                    { "targets": 6, "width":"10%"},
                    { "targets": 7, "width":"10%"},
                    { "targets": 8, "width":"20%"}
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       
            type: "POST",
            data:{
            _method:"DELETE"
            },
            url:"/props/" + row_id,
         
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
                }, 1000);
            }
        });
    });


});

  

</script>
</html>  

@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Auth;

class TaskController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::check()) { 
            /* join tables */
                        
            $data = DB::table('tasks')
            ->join('items','items.id','=', 'tasks.plant_id')
            ->select('tasks.*','items.name')
            ->orderBy('items.name', 'asc')
            ->get();
                        
            if (isset($data[0])) {                                
                if(request()->ajax()) {
                    return datatables()->of($data)
                
                    ->addColumn('action', function ($rows) {
                    $button = '<div class="btn-group btn-group-xs">';
                    $button .= '<a href="/tasks/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                    $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                    $button .= '</div>';
                    return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
                }
                return view('tasks.index'); 
            }
            // no data ... call create() function
            return $this->create();
        }
        else {
            return redirect()->to('/');
        }   
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()) { 
            $plant = DB::table('items')
            ->orderby('name','asc')
            ->pluck("name","id");

            if ($plant->count() == 0) {
                $alertMsg = "You must add a plant item first";
                return view('tasks.create',compact('plant'))->with('alertMsg',$alertMsg);
                
            }
            return view('tasks.create',compact('plant'));
        }
        else {
          return redirect()->to('/');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'descr' => 'required',
        ]);
        /* return plant id from item name selected in blade */
        $plant_select = $request->get('plant');
        $item_db = DB::table('items')
        ->select('id')
        ->where('name', $plant_select)
        ->first();
        $returned_plant_id = $item_db->id;
                                
        $newRec = new Task();
        $newRec->user_id = Auth::user()->id;
        $newRec->plant_id = $returned_plant_id;
        $newRec->activity_type = $request->get('activity_type');
        $newRec->descr = $request->get('descr');
        $newRec->start_date = $request->get('start_date');
        $newRec->recurring = $request->get('recurring');
        $newRec->status = $request->get('status');
                
        $newRec->save();
        return redirect('tasks')->with('success','Task has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()) { 
            $task = task::find($id);
            $plant = DB::table('items')
            ->orderby('name','asc')
            ->pluck("name","id");
            
            $item_task = DB::table('tasks')
                ->join('items','items.id','=', 'tasks.plant_id')
                ->select('items.name','items.id')
                ->where('tasks.id',$id)
                ->first();

            return view('tasks.edit',compact('id','task','plant','item_task'));
        }
        else {
          return redirect()->to('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'descr' => 'required',
        ]);
        /* return plant id from item name selected in blade */
        $task = task::find($id);

        $plant_select = $request->get('plant');
        $item_db = DB::table('items')
        ->select('id')
        ->where('name', $plant_select)
        ->first();
        $returned_plant_id = $item_db->id;
        $task->user_id = Auth::user()->id;
        $task->plant_id = $returned_plant_id;
        $task->activity_type = $request->get('activity_type');
        $task->descr = $request->get('descr');
        $task->start_date = $request->get('start_date');
        $task->recurring = $request->get('recurring');
        $task->status = $request->get('status');
   
        $task->save();
        return redirect('tasks')->with('success','Task has been updated');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("tasks")->delete($id);
        return redirect('tasks')->with('success','Task Has Been Deleted'); //
    }

    public function getPlantID($plantName)
    {
        $plantID = DB::table("items")->where("name",$plantName)->pluck("id");
        
        return(json_encode($plantID));
    }
    
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
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
                    
            $data = DB::table('events')
            ->join('items','items.id','=', 'events.plant_id')
            ->select('events.*','items.name')
            ->orderBy('items.name', 'asc')
            ->get();
                        
            if (isset($data[0])) {                       
                if(request()->ajax()) {
                    return datatables()->of($data)
                
                    ->addColumn('action', function ($rows) {
                        $button = '<div class="btn-group btn-group-xs">';
                        $button .= '<a href="/events/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                        $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('events.index'); 
            }
            // no data ... call create() function
            return $this->create();
        }
        else {
          return redirect()->to('/');
        }
      
    }

    public function show()
    {
        $events = Event::all();
        return view('events.calendar', compact('events'));
    }
 /*
    
   */ 
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
                return view('events.create',compact('plant'))->with('alertMsg',$alertMsg);
                //return view('home_clubs.create',compact('course'))-> alert()->warning('Sweet Alert with warning.');
            }
            return view('events.create',compact('plant'));
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
                                
        $newRec = new Event();
        $newRec->user_id = Auth::user()->id;
        $newRec->plant_id = $returned_plant_id;
        $newRec->entered_at = $request->get('entered_at');
        $newRec->activity_type = $request->get('activity_type');
        $newRec->descr = $request->get('descr');
        $newRec->qty_used = $request->get('qty_used');
        
        $newRec->save();
        return redirect('events')->with('success','Event has been added');
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
            $event = event::find($id);
            $plant = DB::table('items')
            ->orderby('name','asc')
            ->pluck("name","id");
            
            $item_event = DB::table('events')
                ->join('items','items.id','=', 'events.plant_id')
                ->select('items.name','items.id')
                ->where('events.id',$id)
                ->first();

            return view('events.edit',compact('id','event','plant','item_event'));
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
        $event = event::find($id);
        
        $plant_select = $request->get('plant');
        $item_db = DB::table('items')
        ->select('id')
        ->where('name', $plant_select)
        ->first();
        $returned_plant_id = $item_db->id;

        // dd ($id, $returned_plant_id, $plant_select) ; 
        $event->user_id = Auth::user()->id;
        $event->plant_id = $returned_plant_id;
        $event->entered_at = $request->get('entered_at');
        $event->activity_type = $request->get('activity_type');
        $event->descr = $request->get('descr');
        $event->qty_used = $request->get('qty_used');
        
        $event->save();
        return redirect('events')->with('success','Event has been updated');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("events")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect('events')->with('success','Event Has Been Deleted'); //
    }

    public function getPlantID($plantName)
    {
        $plantID = DB::table("items")->where("name",$plantName)->pluck("id");
        
        return(json_encode($plantID));
    }
    
    
}

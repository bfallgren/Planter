<?php

namespace App\Http\Controllers;

use App\Need;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Datatables;
use Yajra\DataTables\Html\Builder;
use Barryvdh\Debugbar\Facade as DebugBar;
use Illuminate\Routing\Route;
use Auth;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request,$id)
    {
        if(Auth::check()) { 
            $q_item = null;
            
            if($request->has('need')) {
                $q_item = $request->input('need');
                $request->session()->put('glob',$q_item);
            }
        
            $areaID = $request->session()->get('globA');
            $item = DB::table('items')
            ->where('id','=',$id)
            ->first();
        

            $need = DB::table('needs')
            ->join('items', 'needs.plant_id', '=', 'items.id')
            ->select('needs.id','items.id AS a_id','items.name','needs.plant_id','needs.ph','needs.water','needs.soil','needs.light','needs.fertilizer')
            ->where('needs.plant_id','=', $q_item)
            ->get()
            ;
            app('debugbar')->error( $request,$id,$q_item,$item,$areaID);
        
            if(request()->ajax()) {
                return datatables()->of($need)
                ->addColumn('action', function ($rows) {
                    app('debugbar')->error( $rows);
                
                $button = '<div class="btn-group btn-group-xs">';
                $button .= '<a href="/needs/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
            }
            
            return view('needs.index',compact('item','id','need','q_item','areaID'));
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
    public function create(Request $request)
    {
        if(Auth::check()) { 
            $param = $request->session()->get('glob');
                
            $item = DB::table('items')
            ->where('id','=',$param)
            ->first();
            app('debugbar')->error( $param,$item);
            return view('needs.create',compact('param','item'));
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
        $validator = \Validator::make($request->all(), [
            'light' => 'required|max:16',
        ]);           
        $newRec = new Need();
        $param = $request->session()->get('glob');
        $newRec->user_id = Auth::user()->id;
        $newRec->plant_id = $param;
        $newRec->ph = $request->get('ph');
        $newRec->soil = $request->get('soil');
        $newRec->water = $request->get('water');
        $newRec->light = $request->get('light');
        $newRec->fertilizer = $request->get('fertilizer');
        $newRec->save();
        
        return redirect()->action('NeedController@index',['need'=>$param])->with('success','Plant Need Has Been Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Need  $need
     * @return \Illuminate\Http\Response
     */
    public function show(Need $need)
    {
     //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Need  $need
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {   
        if(Auth::check()) {  
            $param = $request->session()->get('glob');
            $need = need::find($id);
            $item = DB::table('items')
            ->where('id','=',$param)
            ->first();
            return view('needs.edit',compact('id','need','param','item'));
        }
        else {
          return redirect()->to('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Need  $need
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'light' => 'required|max:16',
        ]);    
        $need = need::find($id);
        $param = $request->session()->get('glob');
        $need->user_id = Auth::user()->id;
        $need->plant_id = $param;
        $need->ph = $request->get('ph');
        $need->soil = $request->get('soil');
        $need->water = $request->get('water');
        $need->light = $request->get('light');
        $need->fertilizer = $request->get('fertilizer');
        $need->save();
        return redirect()->action('NeedController@index',['need'=>$param])->with('success','Plant Need Has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Need  $need
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("needs")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect()->back()->with('success','PLant Need Has Been Deleted');
    }
}

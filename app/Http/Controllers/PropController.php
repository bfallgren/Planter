<?php

namespace App\Http\Controllers;

use App\Prop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Datatables;
use Yajra\DataTables\Html\Builder;
use Barryvdh\Debugbar\Facade as DebugBar;
use Illuminate\Routing\Route;
use Auth;

class PropController extends Controller
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
            
            if($request->has('prop')) {
                $q_item = $request->input('prop');
                app('debugbar')->error( $q_item);
                $request->session()->put('glob',$q_item);
            }
        
            $areaID = $request->session()->get('globA');
            $item = DB::table('items')
            ->where('id','=',$id)
            ->first();
        
            $prop = DB::table('props')
            ->join('items', 'props.plant_id', '=', 'items.id')
            ->select('props.id','items.id AS a_id','items.name','props.plant_id','props.color','props.height_fr','props.height_to','props.width_fr','props.width_to','props.flowering_time','props.trimming_mo')
            ->where('props.plant_id','=', $q_item)
            ->get()
            ;
            app('debugbar')->error( $request,$id,$item);
        
            if(request()->ajax()) {
                return datatables()->of($prop)
                ->addColumn('action', function ($rows) {
                    app('debugbar')->error( $rows);
                
                $button = '<div class="btn-group btn-group-xs">';
                $button .= '<a href="/props/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
            }
            
            return view('props.index',compact('item','id','prop','areaID'));
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
            return view('props.create',compact('param','item'));
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
            'color' => 'required|max:16',
        ]);               
        $newRec = new Prop();
        $param = $request->session()->get('glob');
        $newRec->user_id = Auth::user()->id;
        $newRec->plant_id = $param;
        $newRec->color = $request->get('color');
        $newRec->height_fr = $request->get('height_fr');
        $newRec->height_to = $request->get('height_to');
        $newRec->width_fr = $request->get('width_fr');
        $newRec->width_to = $request->get('width_to');
        $newRec->flowering_time = $request->get('flowering_time');
        $newRec->trimming_mo = $request->get('trimming_mo');
        $newRec->save();
        
        return redirect()->action('PropController@index',['prop'=>$param])->with('success','Plant Property Has Been Added');
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
            $prop = prop::find($id);
            $item = DB::table('items')
            ->where('id','=',$param)
            ->first();
            return view('props.edit',compact('id','prop','param','item'));
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
            'color' => 'required|max:16',
        ]);    
        $prop = prop::find($id);
        $param = $request->session()->get('glob');
        $prop->user_id = Auth::user()->id;
        $prop->plant_id = $param;
        $prop->color = $request->get('color');
        $prop->height_fr = $request->get('height_fr');
        $prop->height_to = $request->get('height_to');
        $prop->width_fr = $request->get('width_fr');
        $prop->width_to = $request->get('width_to');
        $prop->flowering_time = $request->get('flowering_time');
        $prop->trimming_mo = $request->get('trimming_mo');
        $prop->save();
        return redirect()->action('PropController@index',['prop'=>$param])->with('success','Plant Property Has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Need  $need
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("props")->delete($id);
        /* return response()->json(['success'=>"Golf Course Deleted successfully.", 'tr'=>'tr_'.$id]); */
        return redirect()->back()->with('success','Plant Property Has Been Deleted');
    }
}

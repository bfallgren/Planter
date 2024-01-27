<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Datatables;
use Yajra\DataTables\Html\Builder;
use Barryvdh\Debugbar\Facade as DebugBar;
use Illuminate\Routing\Route;
use Auth;

class ItemController extends Controller
{
    
    public function index(Request $request,$id)
    {
        if(Auth::check()) { 
            $q_area = null;
            
            if($request->has('item')) {
                $q_area = $request->input('item');
                $request->session()->put('globA',$q_area);
            }
        
            $area = DB::table('areas')
            ->where('id','=',$id)
            ->first();
        
            $item = DB::table('items')
            ->join('areas', 'items.area_id', '=', 'areas.id')
            ->select('items.id','areas.id AS a_id','items.area_id','items.name','items.type','items.rating','items.photo','items.comment')
            ->where('items.area_id','=', $q_area)
            ->get()
            ;
            // app('debugbar')->error( $request,$id,$item);
        
            if(request()->ajax()) {
                return datatables()->of($item)
                ->addColumn('action', function ($rows) {
            //       app('debugbar')->error( $rows);
                
                $button = '<div class="btn-group btn-group-xs">';
                $button .= '<a href="/items/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
                $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:12px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                $button .= '<a href="/needs/' . $rows->id . ' " title="Needs" name="needbutton" id="' . $rows->id . '" ><i class="fa fa-question" style="margin-left:10px;color:orange;font-size:15px;margin-right:10px"></i></a>';
                $button .= '<a href="/props/' . $rows->id . ' " title="Properties" name="propbutton" id="' . $rows->id . '"><i class="fa fa-binoculars" style="margin-left:10px;color:green;font-size:15px;margin-right:10px"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
            }
        
            return view('items.index',compact('area','id','item'));
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
            $param = $request->session()->get('globA');
        
            $area = DB::table('areas')
            ->where('id','=',$param)
            ->first();
            return view('items.create',compact('param','area'));
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $filename= $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $filename);
            $newRec = new Item();
            $param = $request->session()->get('globA');
            $newRec->user_id = Auth::user()->id;
            $newRec->area_id = $param;
            $newRec->name = $request->get('name');
            $newRec->type = $request->get('type');
            $newRec->rating = $request->get('rating');
            $newRec->photo = $filename;
            $newRec->comment = $request->get('comment');
            $newRec->save();
            return redirect()->action('ItemController@index',['item'=>$param])->with('success','Plant Has Been Added');
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
    public function edit(Request $request,$id)
    {   
        if(Auth::check()) {  
            $param = $request->session()->get('globA');
            $item = item::find($id);
            $area = DB::table('areas')
            ->where('id','=',$param)
            ->first();
            return view('items.edit',compact('id','item','param','area'));
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $filename= $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $filename);
            $item = item::find($id);
            $param = $request->session()->get('globA');
            $item->user_id = Auth::user()->id;
            $item->area_id = $param;
            $item->name = $request->get('name');
            $item->type = $request->get('type');
            $item->rating = $request->get('rating');
            $item->photo = $filename;
            $item->comment = $request->get('comment');
            $item->save();
            return redirect()->action('ItemController@index',['item'=>$param])->with('success','Plant Has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("items")->delete($id);
        return redirect()->back()->with('success','PLant Has Been Deleted');
    }
}

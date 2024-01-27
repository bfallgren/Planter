<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Auth;
use Datatables;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(Auth::check()) { 
            return view('areas.index');
        }
      else {
        return redirect()->to('/');
      }
    }
    
    public function getAreas(Request $request, Area $area)
    {
      if(request()->ajax()) {
        return datatables()->of(Area::select('*'))
       
        ->addColumn('action', function ($rows) {
        
          $button = '<button type="button" id="getEditAreaData" title="Edit" data-id="'.$rows->id.'"><i class="fa fa-edit" style="font-size:12px;color:blue"></i></button>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:15px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          //$button .= '<button type="button" title="Plants" name="plantButton" id="' . $rows->id . '" class="plantButton" style="font-size:15px"><i class="fas fa-leaf" style="color:green"></i></button>';
          $button .= '<a href="/items/' . $rows->id . ' " title="Plant Items" name="plantbutton" id="' . $rows->id . '" ><i class="fas fa-leaf fa-fw" style="font-size:15px; color:green"></i>&nbsp</a>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);
    }
        return view('areas.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()) { 
           //
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
            'name' => 'required|max:64',
            'location' => 'required|max:64',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $newRec = new Area();
        $newRec->user_id = Auth::user()->id;
        $newRec->name = $request->get('name');
        $newRec->location = $request->get('location');
        $newRec->save();
        return redirect('areas')->with('success','Area has been added');
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
            $param = request()->route()->parameter('item');
            $request->session()->put('glob',$param);
            $area = Area::find($id);

            $html = '<div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" name="name" id="editName" value="'.$area->name.'">
                    </div>
                    <div class="form-group">
                        <label for="Name">Location:</label>
                        <textarea class="form-control" name="location" id="editLocation">'.$area->location.'                        
                        </textarea>
                    </div>';

            return response()->json(['html'=>$html]);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:64',
            'location' => 'required|max:64',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $area = Area::find($id);
        $area->user_id = Auth::user()->id;
        $area->name = $request->get('name');
        $area->location = $request->get('location');
        $area->save();
        return response()->json(['success'=>'Area updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("areas")->delete($id);
        return response()->json(['success'=>'Area deleted successfully']);
    }
}

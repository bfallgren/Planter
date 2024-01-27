<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Datatables;
use Auth;

class LinkController extends Controller
{
   
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    
        public function index()
        {
            if(Auth::check()) { 
                return view('links.index');
            }
            else {
              return redirect()->to('/');
            }
        }
        
        public function getLinks(Request $request, Link $link)
        {
          if(request()->ajax()) {
            return datatables()->of(Link::select('*'))
           
            ->addColumn('action', function ($rows) {
             /*   
              $button = '<div class="btn-group btn-group-xs">';
              $button .= '<a href="/links/' . $rows->id . '/edit" id="getEditLinkData" title="Edit" ><i class="fa fa-edit" style="font-size:15px;margin-right:10px"></i></a>';
            */
              $button = '<button type="button" id="getEditLinkData" title="Edit" data-id="'.$rows->id.'"><i class="fa fa-edit" style="font-size:12px;color:blue"></i></button>';
              $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton" style="font-size:15px"><i class="fas fa-trash-alt" style="color:red"></i></button>';
             
            //  $button .= '</div>';
              return $button;
          })
          ->rawColumns(['action'])
          ->make(true);
    
    
        }
    
            return view('links.index'); 
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
                    'name' => 'required|max:32',
                    'description' => 'required|max:64',
                    'urlname' => 'required|max:128',
                ]);
                
                if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }


                $newRec = new Link();
                $newRec->user_id = Auth::user()->id;
                $newRec->name = $request->get('name');
                $newRec->description = $request->get('description');
                $newRec->urlname = $request->get('urlname');
                $newRec->save();
                return redirect('links')->with('success','Link has been added');
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
                $link = Link::find($id);
        
                $html = '<div class="form-group">
                            <label for="Name">Name:</label>
                            <input type="text" class="form-control" name="name" id="editName" value="'.$link->name.'">
                        </div>
                        <div class="form-group">
                            <label for="Description">Description:</label>
                            <textarea class="form-control" name="description" id="editDescription">'.$link->description.'                        
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="urlname">URL Name:</label>
                            <textarea class="form-control" name="urlname" id="editURLname">'.$link->urlname.'                        
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
                'name' => 'required|max:32',
                'description' => 'required|max:64',
                'urlname' => 'required|max:128',
            ]);
            
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            
            $link = Link::find($id);
            $link->user_id = Auth::user()->id;
            $link->name = $request->get('name');
            $link->description = $request->get('description');
            $link->urlname = $request->get('urlname');
            $link->save();
            return response()->json(['success'=>'Link updated successfully']);
    
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table("links")->delete($id);
            return response()->json(['success'=>'Link deleted successfully']);
        }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RelshowsEpisode;
use App\Models\RelShow;
use App\Models\KidShowsSeason;





class RelShowEpisodes extends Controller
{
    public function index(Request $request, $id){
        $id = base64_decode($id); 
        $show = RelShow::where('id', $id)->first();                   
        return view('admin.relepisode.index', compact('id', 'show'));
    }

    /* Process ajax request */
    public function getRelShowEpisodesList(Request $request, $id){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        // Total records
        $totalRecords = RelshowsEpisode::select('count(*) as allcount')->whereNull('rel_episodes.deleted_at')->where('show_id', $id)->count();
        $inactiveRecords = RelshowsEpisode::select('count(*) as allcount')->where('status','0')->whereNull('rel_episodes.deleted_at')->where('show_id', $id)->count();
        $activeRecords = RelshowsEpisode::select('count(*) as allcount')->where('status','1')->whereNull('rel_episodes.deleted_at')->where('show_id', $id)->count();
        $deletedRecords = RelshowsEpisode::select('count(*) as allcount')->whereNotNull('rel_episodes.deleted_at')->where('show_id', $id)->count();


        $totalRecordswithFilter = RelshowsEpisode::select('count(*) as allcount')
        ->where('title', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNull('rel_episodes.deleted_at')->where('show_id', $id)
        ->count();

        // Get records, also we have included search filter as well
        $records = RelshowsEpisode::orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)
            ->whereNull('rel_episodes.deleted_at')
            ->where('rel_episodes.title', 'like', '%' . $searchValue . '%')
            ->where('show_id', $id)

            // ->orWhere('channels.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('channels.contact_email', 'like', '%' . $searchValue . '%')
            ->select('rel_episodes.*')->orderBy('rel_episodes.created_at','asc')            
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('religious-episode/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('religious-episode/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            $type = $record->type == 1 ? 'Premiun' : 'Free';
            $downloadable = $record->downloadable == 1 ? 'Yes' : 'No';

            $data_arr[] = array(
                "title" => $record->title,                                                            
                "status" => $status,                
                "image" => '<img src="'.$record->episode_image.'" width="100px;">',                
                "source" => $record->source,                
                "downloadable" => '<span class="badge bg-primary">'.$downloadable.'</span>',                
                "type" => '<span class="badge bg-primary">'.$type.'</span>',                
                "url" => $record->url,                
                "created_at" => date('j M Y h:i a',strtotime($record->updated_at)),
                "action" => '<div class="action-btn">
                        <a href="'.route("rel_episodes.edit",base64_encode($record->id)).'" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>

                        <a href="javascript:;" onclick="deleteRowModal(\''.base64_encode($record->id).'\')">'.$del_icon.'</a>
                      </div>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "totalRecords" => number_format($totalRecords),
            "activeRecords" => number_format($activeRecords),
            "inactiveRecords" => number_format($inactiveRecords),
            "deletedRecords" => number_format($deletedRecords),
        );
        echo json_encode($response);
    }

    public function create(Request $request, $id){                
        $id = base64_decode($id);
        $this->data['id'] = $id;        
        return view('admin.relepisode.add',$this->data);
    }


    public function edit(Request $request, $id){                
        $id = base64_decode($id);

        $this->data['episode'] = RelshowsEpisode::where('id', $id)->first();
        $this->data['id'] = $id;  
        
        // print_r($this->data); exit;
        return view('admin.relepisode.add',$this->data);
    }


    public function save(Request $request){
        $request->validate([
            'name' => 'required',                                                                        
            'source_url'  => 'required'                                                                                        
        ]); 


        // print_r($request->all()); exit;
        
        if(!empty($request->id)){
            $episode = RelshowsEpisode::firstwhere('id',$request->id);  
            
            

            $episode->title = $request->name;            
            $episode->show_id = $request->show_id;            
            $episode->episode_order = $request->order;            
            $episode->episode_image = $request->thumbnail_url ?? null;            
            $episode->episode_description = $request->description ?? '';                       
            $episode->url = $request->source_url;            
            $episode->downloadable = $request->downloadable;            
            $episode->type = $request->type;            
            $episode->status = $request->status;            
            $episode->source = $request->source;            
            if($episode->save()){                
                return back()->with('message','Episode updated successfully');
            }else{
                return back()->with('message','Episode not updated successfully');
            }

        }else{
            $episode = new RelshowsEpisode();

            $episode->title = $request->name;            
            $episode->show_id = $request->show_id;            
            $episode->episode_order = $request->order ?? null;            
            $episode->episode_image = $request->thumbnail_url ?? null;            
            $episode->episode_description = $request->description ?? ''; 
            $episode->url = $request->source_url;                        
            $episode->downloadable = $request->downloadable;            
            $episode->type = $request->type;            
            $episode->status = $request->status;            
            $episode->source = $request->source;            

            // print_r($episode); exit;
            if($episode->save()){                                
                return back()->with('message','Episode added successfully');
            }else{
                return back()->with('message','Episode not added successfully');
            }
        }

    }

    public function destroy(Request $request){
        $episode = RelshowsEpisode::where('id',base64_decode($request->id))->first();
        $episode->deleted_at = time();
        if($episode->save()){            
            echo json_encode(['message','Episode deleted successfully']);
        }else{
            echo json_encode(['message','Episode not deleted successfully']);
        }
    }

    public function updateStatus($id){
        $episode = RelshowsEpisode::find(base64_decode($id));        
        if($episode){
            $episode->status = $episode->status == '1' ? '0' : '1';
            $episode->save();
            echo json_encode(['message','Episode status updated successfully']);
        }else{
            echo json_encode(['message','Something went wrong!!']);
        }
    }
}

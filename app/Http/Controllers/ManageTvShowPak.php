<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TvShowPak;
use App\Models\WebSeries;
use App\Models\Genre;
use App\Models\WebSeriesSeason;

class ManageTvShowPak extends Controller
{
    public function index($id)    
    {        
        $id = base64_decode($id);
        return view('admin.tvshowpak.index', compact('id'));
    }
    
    public function getTvShowOrderList($id)
    {   $id = base64_decode($id);
        $this->data['tvshowspak'] = TvShowPak::whereNull('deleted_at')->where('tv_channel_id',$id)->orderBy('order', 'asc')->get();

        $allTvShowsPak = [];
        $dataForLoop = [];

        foreach ($this->data['tvshowspak'] as $tvshowpak) {
            $allTvShowsPak[] = $tvshowpak->order;
            $dataForLoop[$tvshowpak->order] = $tvshowpak;
        }

        $this->data['dataForLoop'] = $dataForLoop;
        $this->data['allTvShowsPak'] = $allTvShowsPak;

        return view('admin.tvshowpak.dragdrop', $this->data);
    }

    
    public function getTvShowPakList(Request $request, $id){
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
        $totalRecords = TvShowPak::select('count(*) as allcount')->whereNull('tv_shows_pak.deleted_at')->where('tv_channel_id', $id)->count();
        $inactiveRecords = TvShowPak::select('count(*) as allcount')->where('status','0')->whereNull('tv_shows_pak.deleted_at')->where('tv_channel_id', $id)->count();
        $activeRecords = TvShowPak::select('count(*) as allcount')->where('status','1')->whereNull('tv_shows_pak.deleted_at')->where('tv_channel_id', $id)->count();
        $deletedRecords = TvShowPak::select('count(*) as allcount')->whereNotNull('tv_shows_pak.deleted_at')->where('tv_channel_id', $id)->count();


        $totalRecordswithFilter = TvShowPak::select('count(*) as allcount')
        ->where('name', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNull('tv_shows_pak.deleted_at')->where('tv_channel_id', $id)
        ->count();

        // Get records, also we have included search filter as well
        $records = TvShowPak::orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)
            ->whereNull('tv_shows_pak.deleted_at')
            ->where('tv_shows_pak.name', 'like', '%' . $searchValue . '%')
            ->where('tv_channel_id', $id)

            // ->orWhere('channels.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('channels.contact_email', 'like', '%' . $searchValue . '%')
            ->select('tv_shows_pak.*')->orderBy('tv_shows_pak.created_at','asc')            
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('tvshow/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('tvshow/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            $data_arr[] = array(
                "name" => $record->name,                                                            
                "desc" => $record->description,                                                            
                "status" => $status,                
                "image" => '<img src="'.$record->thumbnail.'" width="100px;">',                                                                              
                "created_at" => date('j M Y h:i a',strtotime($record->updated_at)),
                "action" => '<div class="action-btn">
                        <a href="'.route("editTvShowpak",base64_encode($record->id)).'" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                        <a href="'.route("admin.tvshowpak.season", base64_encode($record->id)) .'" title="Manage Seasons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 1 0-7l1-1a5 5 0 0 1 7 7l-1 1"></path><path d="M14 11a5 5 0 0 1 0 7l-1 1a5 5 0 0 1-7-7l1-1"></path></svg></a>
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

    public function addtvshow(Request $request, $id)
    {
        $id = base64_decode($id);
        $genres = Genre::all();

        return view('admin.tvshowpak.add', compact('id', 'genres'));
    }

    public function updateStatus($id)
    {
        $tvshow = TvShowPak::find(base64_decode($id));

        if ($tvshow) {
            $tvshow->status = $tvshow->status == 1 ? 0 : 1;
            $tvshow->save();
            return response()->json(['message' => 'TvShowPak status updated successfully']);
        }

        return response()->json(['message' => 'Something went wrong!!']);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'genre' => 'required'
        ]);

        if (!empty($request->id)) {
            $tvshow = TvShowPak::find($request->id);
        } else {
            $tvshow = new TvShowPak();
            $tvshow->order = $request->order ?? 0;
        }

        // print_r($request->all()); exit;

        $tvshow->name = $request->name;
        $tvshow->tv_channel_id = $request->tv_channel_id;
        $tvshow->thumbnail = $request->thumbnail ?? null;
        
        $tvshow->genre = implode(',', $request->genre);
        $tvshow->description = $request->description;
        $tvshow->status = $request->status;


        if (!empty($request->id)) {
            if ($tvshow->save()) {
                return back()->with('message', $request->id ? 'TvShow updated successfully' : 'TvShow added successfully');
            } else {
                return back()->with('message', $request->id ? 'TvShow not updated' : 'TvShow not added');
            }
        }
        else{
            if ($tvshow->save()) {
                return redirect()->route('admin.tvshowpak.season', base64_encode($tvshow->id))->with('message', $request->id ? 'TvShow updated successfully' : 'TvShow added successfully');
            } else {
                return back()->with('message', $request->id ? 'TvShow not updated' : 'TvShow not added');
            }
        }
    }

    public function editTvShow($id)
    {
        $tvshow = TvShowPak::find(base64_decode($id));
        $this->data['tvshow'] = $tvshow;
        $this->data['id'] = $tvshow->tv_channel_id;
        $genres = Genre::all();

        $currentGenres = explode(',', $tvshow->genre);
        $this->data['genres'] = $genres;
        $this->data['currentGenres'] = $currentGenres;
        return view('admin.tvshowpak.add', $this->data);
    }

    public function destroy(Request $request)
    {
        $tvshow = TvShowPak::find(base64_decode($request->id));
        $tvshow->deleted_at = time();

        if ($tvshow->save()) {
            return response()->json(['message' => 'TvShowPak deleted successfully']);
        } else {
            return response()->json(['message' => 'TvShowPak not deleted']);
        }
    }
    public function saveTvShowPakOrder(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            foreach ($ids as $index => $id) {
                TvShowPak::where('id', $id)->update(['order' => $index + 1]);
            }
        }

        return redirect()->back()->with('success', 'Tv Show order updated successfully.');
    }
    
}

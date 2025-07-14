<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournamentMatches;
use App\Models\WebSeries;
use App\Models\Genre;
use App\Models\WebSeriesSeason;

use carbon;



class ManageTournamentMatches extends Controller
{
    public function index($id)    
    {   
        // echo $id; exit;     
        $id = base64_decode($id);
        
        return view('admin.tournamentmatches.index', compact('id'));
    }

    public function getTournamentMatchesOrderList($id)
    {
        $id = base64_decode($id);
        $this->data['tournamentmatch'] = TournamentMatches::whereNull('deleted_at')->where('tournament_season_id', $id)->orderBy('match_order', 'asc')->get();

        $this->data['id'] = $id;
        $allTvShowEpisodes = [];
        $dataForLoop = [];

        foreach ($this->data['tournamentmatch'] as $episode) {
            $allTvShowEpisodes[] = $episode->match_order;
            $dataForLoop[$episode->match_order] = $episode;
        }

        $this->data['dataForLoop'] = $dataForLoop;
        $this->data['allTvShowEpisodes'] = $allTvShowEpisodes;

        return view('admin.tournamentmatches.dragdrop', $this->data);
    }


    public function getSportsTournamentSeasonEpisodeList(Request $request, $id){
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
        
        $totalRecords = TournamentMatches::select('count(*) as allcount')->whereNull('tournament_matches.deleted_at')->where('tournament_season_id', $id)->count();
        $inactiveRecords = TournamentMatches::select('count(*) as allcount')->whereNull('tournament_matches.deleted_at')->where('tournament_season_id', $id)->where('status', 0)->count();
        $activeRecords = TournamentMatches::select('count(*) as allcount')->whereNull('tournament_matches.deleted_at')->where('tournament_season_id', $id)->where('status', 1)->count();
        $deletedRecords = TournamentMatches::select('count(*) as allcount')->whereNotNull('tournament_matches.deleted_at')->where('tournament_season_id', $id)->count();


        $totalRecordswithFilter = TournamentMatches::select('count(*) as allcount')
        ->where('match_title', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNull('tournament_matches.deleted_at')->where('tournament_season_id', $id)
        ->count();

        // Get records, also we have included search filter as well
        $records = TournamentMatches::where(function ($query) use ($searchValue) {
                $query->where('tournament_matches.match_title', 'like', '%' . $searchValue . '%')
                    ->orWhere('tournament_matches.match_type', 'like', '%' . $searchValue . '%')
                    ->orWhere('tournament_matches.streaming_info', 'like', '%' . $searchValue . '%');
            })
            ->whereNull('tournament_matches.deleted_at')
            ->where('tournament_season_id', $id)
            ->orderBy($columnName, $columnSortOrder)
            ->orderBy('tournament_matches.created_at', 'asc')
            ->select('tournament_matches.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('tournament-season-episodes/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('tournament-season-episodes/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            $matchdateTime = '';

            if (!empty($record->match_date) && !empty($record->match_time)) {
                $matchdateTime = \Carbon\Carbon::parse($record->match_date)->format("D M Y") . ', ' . $record->match_time;
            } elseif (!empty($record->match_date)) {
                $matchdateTime = \Carbon\Carbon::parse($record->match_date)->format('D M Y');
            } elseif (!empty($record->match_time)) {
                $matchdateTime = $record->match_time;
            }

            $data_arr[] = array(
                "match_title" => $record->match_title,                                                            
                "match_type" => $record->match_type,                                                            
                "desc" => $record->description,                                                            
                "streaming_info" => $record->streaming_info,                                                            
                "match_datetime" => $matchdateTime,                                                            
                "status" => $status,                
                "start_date" => $record->start_date,                
                "end_date" => $record->end_date,                
                "logo" => '<img src="'.$record->logo.'" width="100px;">',                                                                              
                "created_at" => date('j M Y h:i a',strtotime($record->updated_at)),
                "action" => '<div class="action-btn">
                        <a href="'.route("editsportstournamentseasonepisodes",base64_encode($record->id)).'" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>                        
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

    public function add(Request $request, $id)
    {
        $id = base64_decode($id);        

        return view('admin.tournamentmatches.add', compact('id'));
    }

    public function updateStatus($id)
    {
        $tournamentseason = TournamentMatches::find(base64_decode($id));

        if ($tournamentseason) {
            $tournamentseason->status = $tournamentseason->status == 1 ? 0 : 1;
            $tournamentseason->save();
            return response()->json(['message' => 'TournamentMatches status updated successfully']);
        }

        return response()->json(['message' => 'Something went wrong!!']);
    }

    public function save(Request $request)
    {
        $request->validate([
            'match_title' => 'required',
            'video_url' => 'required'
        ]);

        if (!empty($request->id)) {
            $match = TournamentMatches::find($request->id);
        } else {
            $match = new TournamentMatches();
        }

        // print_r($request->all()); exit;

        $match->match_title = $request->match_title;
        $match->tournament_season_id  = $request->tournament_season_id;        
        $match->match_type  = $request->match_type;        
        $match->match_date  = $request->match_date;        
        $match->match_time = $request->match_time ?? null;        
        $match->streaming_info = $request->streaming_info ?? null;        
        $match->video_url = $request->video_url ?? null;                    
        $match->thumbnail_url = $request->thumbnail_url ?? null;                    
        $match->description = $request->description;
        $match->status = $request->status;

        // print_r($match); exit;


        if (!empty($request->id)) {
            if ($match->save()) {
                return back()->with('message','Tournament Match updated successfully');
            } else {
                return back()->with('message','Tournament Match not updated');
            }
        }
        else{
            if ($match->save()) {
                return back()->with('message', $request->id ? 'TournamentMatches not updated' : 'Tournament Match added');
            } else {
                return back()->with('message', $request->id ? 'TournamentMatches not updated' : 'Tournament Match not added');
            }
        }
    }

    public function edit($id)
    {        
        $match = TournamentMatches::find(base64_decode($id));   
        // print_r($tournamentseason); exit;     
        $this->data['id'] = $match->tournament_season_id ;                             
        $this->data['match'] = $match;                             
        return view('admin.tournamentmatches.add', $this->data);
    }

    public function destroy(Request $request)
    {
        $tournamentseason = TournamentMatches::find(base64_decode($request->id));
        $tournamentseason->deleted_at = time();

        if ($tournamentseason->save()) {
            return response()->json(['message' => 'Tournament Matches deleted successfully']);
        } else {
            return response()->json(['message' => 'Tournament Matches not deleted']);
        }
    }
    
    public function saveTournamentMatchesOrders(Request $request)
    {
        $ids = $request->ids; 
        if (!empty($ids)) {
            foreach ($ids as $index => $id) {
                TournamentMatches::where('id', $id)->update(['match_order' => $index + 1]);
            }
        }

        return redirect()->back()->with('success', 'Matches order updated successfully.');
    }
}

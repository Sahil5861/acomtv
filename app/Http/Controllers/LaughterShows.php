<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laughterhow;
use App\Models\Genre;
use App\Models\ContentNetwork;
use App\Models\LaugtershowContentNetwork;
use Illuminate\Support\Facades\DB;


class LaughterShows extends Controller
{
    public function index()
    {
        $content_networks = ContentNetwork::where('status', 1)->get();
        $genres = Genre::where('status',1)->get();


        $playlist_ids = Laughterhow::where('playlist_id', '!=', null)->pluck('playlist_id')->unique()->values();        
        return view('admin.laughtershow.index', compact('content_networks', 'genres', 'playlist_ids'));
    }
    public function getLaughterShowOrderList(){
        $this->data['movies'] = Laughterhow::whereNull('deleted_at')->orderBy('movie_order', 'asc')->get();
        // echo count($this->data['movies']); exit;
        $allMovies = [];
        $dataForLoop = [];

        foreach ($this->data['movies'] as $movie) {
            $allMovies[] = $movie->movie_order;
            $dataForLoop[$movie->movie_order] = $movie;
        }

        $this->data['dataForLoop'] = $dataForLoop;
        $this->data['allMovies'] = $allMovies;

        return view('admin.laughtershow.dragdrop', $this->data);
    }
    public function deletedChannel(){
        return view('admin.laughtershow.deleted');
    }
    
    public function getLaughterShowsList(Request $request)
    {
        
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


        $playlist_id = $request->input('playlist_id');
        $status = $request->input('status');
        $status = number_format($status);   

        $movieQuery = Laughterhow::query()->whereNull('laughter_show.deleted_at');

        if ($request->has('playlist_id') && $playlist_id != '') {           
            $movieQuery->where('playlist_id', $playlist_id);
        }

        if ($request->has('status') && $status != '') {                    
            $movieQuery->where('status', $status);
        }

        $totalRecords = Laughterhow::select('count(*) as allcount')->whereNull('deleted_at');
        $inactiveRecords = Laughterhow::select('count(*) as allcount')->whereNull('deleted_at')->where('status','0');
        $activeRecords = Laughterhow::select('count(*) as allcount')->whereNull('deleted_at')->where('status','1');
        $deletedRecords = Laughterhow::select('count(*) as allcount')->where('deleted_at', '!=', null);

        $totalRecords = $totalRecords->count();
        $inactiveRecords = $inactiveRecords->count();
        $activeRecords = $activeRecords->count();
        $deletedRecords = $deletedRecords->count();


        $totalRecordswithFilter = (clone $movieQuery)->where(function($query) use ($searchValue) {
                                                        $query->where('laughter_show.name', 'like', '%' . $searchValue . '%')
                                                            ->orWhere('laughter_show.playlist_id', 'like', '%' . $searchValue . '%');
                                                    }) 
                                            ->count();

        // Get records, also we have included search filter as well
        $records = (clone $movieQuery)->orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)            
            ->where(function($query) use ($searchValue) {
                $query->where('laughter_show.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('laughter_show.playlist_id', 'like', '%' . $searchValue . '%');
            })                      
            ->select('laughter_show.*')->orderBy('laughter_show.updated_at','desc')            
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('laughter-show/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('laughter-show/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,                                                            
                "status" => $status, 
                'playlist_id' => $record->playlist_id ?? '',               
                "play_btn" => '<a href="javascript:void(0);" class="btn btn-primary play-video" data-video-id="'.$record->movie_url.'" onclick="openVideoModal(this)"><svg xmlns="http://www.w3.org/2000/svg" 
                    width="20" height="20" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    class="feather feather-eye">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                </a>',
                "banner" => '<img src="'.$record->banner.'" width="100px">',
                "created_at" => date('j M Y h:i a',strtotime($record->updated_at)),
                "action" => '<div class="action-btn">
                        <a href="edit-laughter-show/'.base64_encode($record->id).'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>                        
                        <a href="javascript:;" onclick="deleteRowModal(\''.base64_encode($record->id).'\',\'stage_show\')">'.$del_icon.'</a>
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
            "deletedRecords" => $deletedRecords,
        );
        echo json_encode($response);
    }

    public function getDeletedChannelList(Request $request){
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
        $totalRecords = Channel::select('count(*) as allcount')->whereNull('channels.deleted_at')->count();
        $inactiveRecords = Channel::select('count(*) as allcount')->where('status','0')->whereNull('channels.deleted_at')->count();
        $activeRecords = Channel::select('count(*) as allcount')->where('status','1')->whereNull('channels.deleted_at')->count();
        $deletedRecords = Channel::select('count(*) as allcount')->whereNotNull('channels.deleted_at')->count();


        $totalRecordswithFilter = Channel::select('count(*) as allcount')
        ->where('channel_name', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNotNull('channels.deleted_at')
        ->orWhere(function($query) use ($searchValue)
        {
            $query->where('channels.channel_number', 'like', '%' . $searchValue . '%')
            ->whereNotNull('channels.deleted_at');
        })

        ->orWhere(function($query)  use ($searchValue)
        {
            $query->Where('channels.channel_language', 'like', '%' . $searchValue . '%')
            ->whereNotNull('channels.deleted_at');
        })
        ->count();

        // Get records, also we have included search filter as well
        $records = Channel::orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)
            ->whereNotNull('channels.deleted_at')
            ->where('channels.channel_name', 'like', '%' . $searchValue . '%')

            ->orWhere(function($query) use ($searchValue)
            {
                $query->where('channels.channel_number', 'like', '%' . $searchValue . '%')
                      ->whereNotNull('channels.deleted_at');
            })

            ->orWhere(function($query)  use ($searchValue)
            {
                $query->Where('channels.channel_language', 'like', '%' . $searchValue . '%')
                      ->whereNotNull('channels.deleted_at');
            })


            // ->orWhere('channels.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('channels.contact_email', 'like', '%' . $searchValue . '%')
            ->select('channels.*')->with('language')
            // ->leftJoin('channels', 'channels.id', '=', 'Channel.Channel_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('channel/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('channel/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            // <a href="'.route('admin.channel.recoverChannel',base64_encode($record->id)).'" data-toggle="tooltip" title="Undo Channel" class="undo-channel">'.$del_icon.'</a>

            $data_arr[] = array(
                "channel_name" => $record->channel_name,
                "channel_number" => $record->channel_number,
                "channel_logo" => $record->channel_logo,
                // "channel_genre" => $record->channel_genre,
                "channel_language" => $record->language ? $record->language->title : '',
                "channel_link" => '<a class="btn btn-primary mb-3 rounded bs-tooltip" data-toggle="tooltip" title="Click to open link" href="'.$record->channel_link.'" target="_blank" >Link</a>',
                "status" => $status,

                "created_at" => date('j M Y h:i a',strtotime($record->created_at)),
                "action" => '<div class="action-btn">

                        <a data-toggle="tooltip" title="Undo Channel" onclick="undoChannel('.$record->id.')">'.$del_icon.'</a>
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

    public function recoverChannel($id){
        $id = base64_decode($id);
        $update = Channel::where('id',$id)->update(['deleted_at'=>null]);
        if($update){
            return back()->with('message','Channel recover successfully');
        }else{
            return back()->with('message','Something went wrong');
        }
    }

    public function addChannel(){        
        $this->data['genres'] = Genre::where('status',1)->get();
        $this->data['networks'] = ContentNetwork::where('deleted_at', null)->get();
        return view('admin.laughtershow.add',$this->data);
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required',            
            'movie_url' => 'required',            
            'banner' => 'required',            
            'movie_genre' => 'required',                                 
        ]);
        // print_r($request->all()); exit();
        if(!empty($request->id)){

            $laughter_show = Laughterhow::firstwhere('id',$request->id);
            $laughter_show->name = $request->name;
            $laughter_show->banner = $request->banner;                                  
            $laughter_show->description = $request->movie_description;                        
            $laughter_show->release_date = $request->release_date ?? null;                                                                    
            $laughter_show->status = $request->status;
            $laughter_show->index = $request->index ?? 0;
            $laughter_show->movie_order = $request->index ?? 0;
            $laughter_show->source_type = $request->source_type;
            $laughter_show->youtube_trailer = $request->trailer_url ?? null;
            $laughter_show->movie_url = $request->movie_url ?? null;
            $laughter_show->genres = implode(',', $request->movie_genre);
            if($laughter_show->save()){
                
                LaugtershowContentNetwork::where('movie_id',$laughter_show->id)->delete();
                if ($request->has('content_network') && !empty($request->content_network)) {                    
                    DB::table('content_network_log')->where('content_id', $laughter_show->id)->where('content_type', $laughter_show->content_type)->delete();                                                                
                    foreach ($request->content_network as $key => $network) {
                        $LaughterhowNetwork = new LaugtershowContentNetwork();
                        $LaughterhowNetwork->movie_id = $laughter_show->id;
                        $LaughterhowNetwork->network_id = $network;
                        if ($LaughterhowNetwork->save()) {                           
                            DB::table('content_network_log')->insert([
                                'content_id' => $laughter_show->id,
                                'network_id' => $network,
                                'content_type' => $laughter_show->content_type,                            
                            ]);
                        }
                    }
                }


                return back()->with('message','Stage Show updated successfully');
            }else{
                return back()->with('message','Stage Show not updated successfully');
            }

        }else{

            // print_r($request->all()); exit;
            $addedMovies = Laughterhow::whereNull('deleted_at')->get();
            foreach ($addedMovies as $key => $movie) {
                if ($movie->name == $request->name || $movie->movie_url == $request->movie_url) {
                    return redirect()->back()->withInput()->withErrors(['message' => 'Show with the same name or URL already exists.']);
                }
            }
            $laughter_show = new Laughterhow();
            $laughter_show->name = $request->name;
            $laughter_show->banner = $request->banner;                                  
            $laughter_show->description = $request->movie_description ?? null;                        
            $laughter_show->release_date = $request->release_date ?? null;                                                                    
            $laughter_show->status = $request->status;
            $laughter_show->index = $request->index ?? 0;
            $laughter_show->movie_order = $request->index ?? 0;
            $laughter_show->source_type = $request->source_type;                
            $laughter_show->movie_url = $request->source_type;                            
            $laughter_show->genres = implode(',', $request->movie_genre);
            if($laughter_show->save()){                                
                if ($request->has('content_network') && !empty($request->content_network)) {
                    $cur_movies = Laughterhow::where('id', $laughter_show->id)->first();
                    $newtworkMovies = LaugtershowContentNetwork::where('movie_id',$laughter_show->id)->get();
                    if ($newtworkMovies) {
                        LaugtershowContentNetwork::where('movie_id',$laughter_show->id)->delete();
                    }
                    foreach ($request->content_network as $key => $network) {
                        $MovieNetwork = new LaugtershowContentNetwork();
                        $MovieNetwork->movie_id = $laughter_show->id;
                        $MovieNetwork->network_id = $network;
                        
                        if ($MovieNetwork->save()) {
                            DB::table('content_network_log')->insert([
                                'content_id' => $laughter_show->id,
                                'network_id' => $network,
                                'content_type' => $cur_movies->content_type,                            
                            ]);
                        }
                    }
                }

                return back()->with('message','Stage Show added successfully');
            }else{
                return back()->with('message','Stage Show not added successfully');
            }
        }

    }

    public function editlaughtershow($id){  
        $laughter_show = Laughterhow::where('id', base64_decode($id))->first();              
        $this->data['laughter_show'] = $laughter_show;
        $this->data['genres'] = Genre::where('status',1)->get();
        $this->data['networks'] = ContentNetwork::where('deleted_at', null)->get();
        // $channelGenre = MovieGenre::where('laughter_show_id',base64_decode($id))->get();

        $this->data['channelGenre'] = explode(',', $laughter_show->genres);
        $laughtershowsnetwork = LaugtershowContentNetwork::where('movie_id', base64_decode($id))->get();        
        // print_r($channelGenre); exit();
        // $this->data['channelGenre'] = [];
        $this->data['laughtershowsnetwork'] = [];
        // if($channelGenre){
        //     foreach ($channelGenre as $key => $value) {
        //         $this->data['channelGenre'][] = $value->genre_id;
        //     }
        // }

        if($laughtershowsnetwork){
            foreach ($laughtershowsnetwork as $key => $value) {
                $this->data['laughtershowsnetwork'][] = $value->network_id;
            }
        }
        // print_r($this->data['laughtershowsnetwork']); exit;
        return view('admin.laughtershow.add',$this->data);
    }

    public function destroy(Request $request){
        $movie = Laughterhow::where('id',base64_decode($request->id))->first();

        
        $movie->deleted_at = time();
        if($movie->save()){

            LaugtershowContentNetwork::where('movie_id',$movie->id)->delete();            
            echo json_encode(['message','Laughter Show deleted successfully']);
        }else{
            echo json_encode(['message','Laughter Show not deleted successfully']);
        }
    }
    public function saveLaughterShowOrder(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            foreach ($ids as $index => $id) {
                Laughterhow::where('id', $id)->update(['movie_order' => $index + 1]);
            }
        }

        return redirect()->back()->with('success', 'Laughter show order updated successfully.');
    }
    public function updateStatus($id){
        $movie = Laughterhow::find(base64_decode($id));        
        if($movie){
            $movie->status = $movie->status == '1' ? '0' : '1';
            $movie->save();
            echo json_encode(['message','Laughterhow status updated successfully']);
        }else{
            echo json_encode(['message','Something went wrong!!']);
        }
    }


    public function importlaughtershows(Request $request){
        $request->validate([
            'playlist_id' => 'required',
            'genre' => 'required',
            'content_network' => 'required'
        ]);
        $playlistId = $request->input('playlist_id');
        $genres = implode(',', $request->genre) ?? '';

        $apiKey = 'AIzaSyBrsmSKZ5yG6BFkVHsHMxLCkSsvzaH7szk';
        $baseurl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$apiKey}";
        $nextPageToken = null;

        do {
            $url = $baseurl;
            if ($nextPageToken) {
                $url .= "&pageToken=" . $nextPageToken;
            }

            $ch = curl_init($url);
    
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
            $response = curl_exec($ch);
    
            if(curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                return response()->json(['success' => false, 'error' => $error_msg], 500);
            }
            curl_close($ch);
            
            $data = json_decode($response, true);        

            if (!isset($data['items'])) break;

            foreach ($data['items'] as $key => $item) {    
                $snippet = $item['snippet'];
                $movieName = $snippet['title'] ?? null;
                $movie_url = $snippet['resourceId']['videoId'] ?? null;

                if ($this->checkIsExist($movieName, $movie_url) || trim($movieName) == 'Private video') {
                    continue;
                }

                $rawBannerUrl = $snippet['thumbnails']['high']['url'] ?? null;
                $cleanBannerUrl = $rawBannerUrl ? explode('?', $rawBannerUrl)[0] : null;
                        
                $movie = new Laughterhow();

                $channel_number = Laughterhow::whereNull('deleted_at')->count();
                $formated_number = $channel_number + 1;   

                $movie->name = $movieName;
                $movie->description = $snippet['description'] ?? null;
                
                $movie->banner = $cleanBannerUrl;
                $movie->status = 0;
                $movie->source_type = 'YoutubeLive';            
                $movie->youtube_trailer = '' ?? null;
                $movie->movie_url = $movie_url;
                $movie->genres = $genres;
                $movie->index = $formated_number;
                $movie->playlist_id = $playlistId;

                if ($movie->save()) {
                    if ($request->has('content_network') && !empty($request->content_network)) {
                        $cur_movies = Laughterhow::where('id', $movie->id)->first();                        
                        foreach ($request->content_network as $key => $network) {
                            $MovieNetwork = new LaugtershowContentNetwork();
                            $MovieNetwork->movie_id = $movie->id;
                            $MovieNetwork->network_id = $network;
                            
                            if ($MovieNetwork->save()) {
                                DB::table('content_network_log')->insert([
                                    'content_id' => $movie->id,
                                    'network_id' => $network,
                                    'content_type' => $cur_movies->content_type,                            
                                ]);
                            }
                        }
                    }
                }            
            }

            $nextPageToken = $data['nextPageToken'] ?? null;                    
        } while ($nextPageToken);  

        

        return back()->with('message','Playlist Uploaded successfully');

    }


    public function checkIsExist($movie_name, $url){
        return Laughterhow::where(function ($query) use ($movie_name, $url){
            $query->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($movie_name))])
                    ->orWhereRaw('LOWER(TRIM(movie_url)) = ?', [strtolower(trim($url))]);
        })
        ->whereNull('deleted_at')
        ->first();
    }



}

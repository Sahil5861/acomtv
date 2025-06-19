<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieLink;
use App\Models\Genre;
use App\Models\MovieGenre;
use App\Models\ContentNetwork;
use App\Models\MovieContentNetwork;
use Illuminate\Support\Facades\DB;




class Movies extends Controller
{
    public function index()
    {
        return view('admin.movie.index');
    }

    public function deletedChannel(){
        return view('admin.movie.deleted');
    }

    public function getChannelOrderList()
    {
        $this->data['channels'] = Channel::whereNull('deleted_at')->with('language')->orderBy('channel_number','asc')->get();
        // print_r($this->data['channels']); exit();
        $lockedChannels = [];
        $allChannels = [];
        $lastChannel = $this->data['channels'][count($this->data['channels']) - 1]->channel_number;
        $dataForLoop = [];
        for ($i=1; $i < $lastChannel; $i++) { 
            # code...
            $dataForLoop[$i] = "";
        }
        foreach ($this->data['channels'] as $key => $value) {
            # code...
            $allChannels[] = $value->channel_number;
            $dataForLoop[$value->channel_number] = $value;
            if($value->position_locked == 1){
                $lockedChannels[] = $value->channel_number;
            }
        }
        // print_r($dataForLoop); exit;
        $this->data['dataForLoop'] = $dataForLoop;
        $this->data['allChannels'] = $allChannels;
        $this->data['lockedChannels'] = $lockedChannels;
        return view('admin.channel.dragdrop',$this->data);
    }

    /* Process ajax request */
    public function getMoviesList(Request $request)
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

        // Total records
        // Total records
        $totalRecords = Movie::select('count(*) as allcount')->whereNull('movies.deleted_at')->count();
        $inactiveRecords = Movie::select('count(*) as allcount')->where('status','0')->whereNull('movies.deleted_at')->count();
        $activeRecords = Movie::select('count(*) as allcount')->where('status','1')->whereNull('movies.deleted_at')->count();
        $deletedRecords = Movie::select('count(*) as allcount')->whereNotNull('movies.deleted_at')->count();


        $totalRecordswithFilter = Movie::select('count(*) as allcount')
        ->where('name', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNull('movies.deleted_at')
        ->count();

        // Get records, also we have included search filter as well
        $records = Movie::orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)
            ->whereNull('movies.deleted_at')
            ->where('movies.name', 'like', '%' . $searchValue . '%')

            // ->orWhere('channels.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('channels.contact_email', 'like', '%' . $searchValue . '%')
            ->select('movies.*')->orderBy('movies.updated_at','desc')            
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('movie/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('movie/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }

            if($record->deleted_at){
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>';
            }else{
                $del_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
            }

            $data_arr[] = array(
                "name" => $record->name,                                                            
                "status" => $status,
                "banner" => '<img src="'.$record->banner.'" width="100px">',
                "created_at" => date('j M Y h:i a',strtotime($record->updated_at)),
                "action" => '<div class="action-btn">
                        <a href="edit-movie/'.base64_encode($record->id).'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>                        
                        <a href="javascript:;" onclick="delete_item(\''.base64_encode($record->id).'\',\'movie\')">'.$del_icon.'</a>
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
        return view('admin.movie.add',$this->data);
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

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/movie/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $banner = $filePath;
            // }else{
            //     $banner = '';
            // }

            // if ($request->hasFile('movie_poster')) {
            //     $file = $request->file('movie_poster');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/movie/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $movie_poster = $filePath;
            // }else{
            //     $movie_poster = '';
            // }
            // print_r($request->all()); exit;
            // echo $request->channel_description; exit;
            $movie = Movie::firstwhere('id',$request->id);
            $movie->name = $request->name;
            $movie->banner = $request->banner;                                  
            $movie->description = $request->movie_description;                        
            $movie->release_date = $request->release_date ?? null;                                                                    
            $movie->status = $request->status;
            $movie->source_type = $request->source_type;
            $movie->youtube_trailer = $request->trailer_url ?? null;
            $movie->movie_url = $request->movie_url ?? null;
            $movie->genres = implode(',', $request->movie_genre);
            if($movie->save()){
                // MovieGenre::where('movie_id',$movie->id)->delete();
                // foreach ($request->movie_genre as $key => $genre) {
                //     $MovieGenre = new MovieGenre();
                //     $MovieGenre->movie_id = $movie->id;
                //     $MovieGenre->genre_id = $genre;
                //     $MovieGenre->save();
                // }

                MovieContentNetwork::where('movie_id',$movie->id)->delete();
                if ($request->has('content_network') && !empty($request->content_network)) {                    
                    DB::table('content_network_log')->where('content_id', $movie->id)->where('content_type', $movie->content_type)->delete();                                                                
                    foreach ($request->content_network as $key => $network) {
                        $MovieNetwork = new MovieContentNetwork();
                        $MovieNetwork->movie_id = $movie->id;
                        $MovieNetwork->network_id = $network;
                        if ($MovieNetwork->save()) {                           
                            DB::table('content_network_log')->insert([
                                'content_id' => $movie->id,
                                'network_id' => $network,
                                'content_type' => $movie->content_type,                            
                            ]);
                        }
                    }
                }


                return back()->with('message','Movie updated successfully');
            }else{
                return back()->with('message','Movie not updated successfully');
            }

        }else{

            // print_r($request->all()); exit;

            // $channelNumberExists = Channel::where('channel_number',$request->channel_number)->first();
            // $channelNameExists = Genre::where('title',$request->channel_name)->first();
            // if($channelNumberExists){
            //     return back()->with('error','This channel number is already exists.');
            // }
            // if($channelNameExists){
            //     return back()->with('error','This channel name is not available.');
            // }

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/movie/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $banner = $filePath;
            // }else{
            //     $banner = '';
            // }

            // if ($request->hasFile('movie_poster')) {
            //     $file = $request->file('movie_poster');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/channel/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $movie_poster = $filePath;
            // }else{
            //     $movie_poster = '';
            // }

            $movie = new Movie();
            $movie->name = $request->name;
            $movie->banner = $request->banner;                                  
            $movie->description = $request->movie_description ?? null;                        
            $movie->release_date = $request->release_date ?? null;                                                                    
            $movie->status = $request->status;
            $movie->source_type = $request->source_type;    
            $movie->youtube_trailer = $request->trailer_url ?? null;
            $movie->movie_url = $request->movie_url ?? null;
            $movie->genres = implode(',', $request->movie_genre);
            if($movie->save()){                
                // foreach ($request->movie_genre as $key => $genre) {
                //     $MovieGenre = new MovieGenre();
                //     $MovieGenre->movie_id = $movie->id;
                //     $MovieGenre->genre_id = $genre;
                //     $MovieGenre->save();
                // }

                if ($request->has('content_network') && !empty($request->content_network)) {
                    $cur_movies = Movie::where('id', $movie->id)->first();
                    $newtworkMovies = MovieContentNetwork::where('movie_id',$movie->id)->get();
                    if ($newtworkMovies) {
                        MovieContentNetwork::where('movie_id',$movie->id)->delete();
                    }
                    foreach ($request->content_network as $key => $network) {
                        $MovieNetwork = new MovieContentNetwork();
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

                return back()->with('message','Movie added successfully');
            }else{
                return back()->with('message','Movie not added successfully');
            }
        }

    }

    public function editChannel($id){  
        $movie = Movie::where('id', base64_decode($id))->first();              
        $this->data['movie'] = $movie;
        $this->data['genres'] = Genre::where('status',1)->get();
        $this->data['networks'] = ContentNetwork::where('deleted_at', null)->get();
        // $channelGenre = MovieGenre::where('movie_id',base64_decode($id))->get();

        $this->data['channelGenre'] = explode(',', $movie->genres);
        $movieNetwork = MovieContentNetwork::where('movie_id', base64_decode($id))->get();        
        // print_r($channelGenre); exit();
        // $this->data['channelGenre'] = [];
        $this->data['movieNetwork'] = [];
        // if($channelGenre){
        //     foreach ($channelGenre as $key => $value) {
        //         $this->data['channelGenre'][] = $value->genre_id;
        //     }
        // }

        if($movieNetwork){
            foreach ($movieNetwork as $key => $value) {
                $this->data['movieNetwork'][] = $value->network_id;
            }
        }
        // print_r($this->data['movieNetwork']); exit;
        return view('admin.movie.add',$this->data);
    }

    public function destroy(Request $request){
        $movie = Movie::where('id',base64_decode($request->id))->first();

        
        $movie->deleted_at = time();
        if($movie->save()){

            MovieContentNetwork::where('movie_id',$movie->id)->delete();
            $links = MovieLink::where('movie_id', $movie->id)->get();
            if ($links) {
                MovieLink::where('movie_id', $movie->id)->delete();
            }
            echo json_encode(['message','Movie deleted successfully']);
        }else{
            echo json_encode(['message','Movie not deleted successfully']);
        }
    }

    public function updateStatus($id){
        $movie = Movie::find(base64_decode($id));        
        if($movie){
            $movie->status = $movie->status == '1' ? '0' : '1';
            $movie->save();
            echo json_encode(['message','Movie status updated successfully']);
        }else{
            echo json_encode(['message','Something went wrong!!']);
        }
    }

}

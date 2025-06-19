<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebSeries;
use App\Models\WebSeriesSeason;
use App\Models\WebSeriesEpisode;
use App\Models\Genre;
use App\Models\WebSeriesGenre;
use App\Models\ContentNetwork;
use App\Models\WebSeriesContentNetwork;
use Illuminate\Support\Facades\DB;

class Webserieses extends Controller
{
    public function index(){
        return view('admin.webseries.index');
    }

    /* Process ajax request */
    public function getWebseriesList(Request $request){
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
        $totalRecords = WebSeries::select('count(*) as allcount')->whereNull('web_series.deleted_at')->count();
        $inactiveRecords = WebSeries::select('count(*) as allcount')->where('status','0')->whereNull('web_series.deleted_at')->count();
        $activeRecords = WebSeries::select('count(*) as allcount')->where('status','1')->whereNull('web_series.deleted_at')->count();
        $deletedRecords = WebSeries::select('count(*) as allcount')->whereNotNull('web_series.deleted_at')->count();


        $totalRecordswithFilter = WebSeries::select('count(*) as allcount')
        ->where('name', 'like', '%' . $searchValue . '%')
        // ->where('channels.status', '=', 1)
        ->whereNull('web_series.deleted_at')
        ->count();

        // Get records, also we have included search filter as well
        $records = WebSeries::orderBy($columnName, $columnSortOrder)
            // ->where('channels.status', '=', 1)
            ->whereNull('web_series.deleted_at')
            ->where('web_series.name', 'like', '%' . $searchValue . '%')

            // ->orWhere('channels.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('channels.contact_email', 'like', '%' . $searchValue . '%')
            ->select('web_series.*')->orderBy('web_series.updated_at','desc')            
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('web-seies/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('web-seies/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
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
                        <a href="edit-webseries/'.base64_encode($record->id).'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                        <a href="web-series-season/'.base64_encode($record->id).'" title="Manage Seasons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 1 0-7l1-1a5 5 0 0 1 7 7l-1 1"></path><path d="M14 11a5 5 0 0 1 0 7l-1 1a5 5 0 0 1-7-7l1-1"></path></svg></a>

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

    public function create(){        
        $this->data['genres'] = Genre::where('status',1)->get();
        $this->data['networks'] = ContentNetwork::where('deleted_at', null)->get();
        return view('admin.webseries.add',$this->data);
    }

    public function save(Request $request){
        $request->validate([
            'name' => 'required',            
            'webseries_genre' => 'required',            
            'banner' => 'required',                        
            'webseries_description'  => 'sometimes',                                
        ]); 
        
        // print_r($request->all()); exit;

        // $genre = implode(',', $request->webseries_genre);

        // print_r($genre); exit;
        if(!empty($request->id)){

            $webseries = WebSeries::firstwhere('id',$request->id);
            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/webseries/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $banner = $filePath;
            // }else{
            //     $banner = $webseries->image;
            // }

            // if ($request->hasFile('webseries_poster')) {
            //     $file = $request->file('webseries_poster');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/webseries/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $webseries_poster = $filePath;
            // }else{
            //     $webseries_poster = $webseries->poster;
            // }
            $webseries->name = $request->name;
            $webseries->banner = $request->banner;                                  
            $webseries->description = $request->webseries_description;                        
            $webseries->release_date = $request->release_date ?? null;                                                                    
            $webseries->status = $request->status;
            $webseries->youtube_trailer = $request->trailer_url ?? null;
            $webseries->genres = implode(',', $request->webseries_genre);
            
            if($webseries->save()){
                // WebSeriesGenre::where('web_series_id',$webseries->id)->delete();
                // foreach ($request->webseries_genre as $key => $genre) {
                //     $WebseriesGenre = new WebSeriesGenre();
                //     $WebseriesGenre->web_series_id = $webseries->id;
                //     $WebseriesGenre->genre_id = $genre;
                //     $WebseriesGenre->save();
                // }

                if ($request->has('content_network') && !empty($request->content_network)) {
                    WebSeriesContentNetwork::where('webseries_id',$webseries->id)->delete();
                    DB::table('content_network_log')->where('content_id', $webseries->id)->where('content_type', $webseries->content_type)->delete();                                           
                    foreach ($request->content_network as $key => $network) {
                        $MovieNetwork = new WebSeriesContentNetwork();
                        $MovieNetwork->webseries_id  = $webseries->id;
                        $MovieNetwork->network_id = $network;                    
    
                        if ($MovieNetwork->save()) {                             
                            DB::table('content_network_log')->insert([
                                'content_id' => $webseries->id,
                                'network_id' => $network,
                                'content_type' => $webseries->content_type,                            
                            ]);
                        }
                    }
                }

                return back()->with('message','Webseries updated successfully');
            }else{
                return back()->with('message','Webseries not updated successfully');
            }

        }else{

            // if ($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/webseries/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $banner = $filePath;
            // }else{
            //     $banner = '';
            // }

            // if ($request->hasFile('webseries_poster')) {
            //     $file = $request->file('webseries_poster');
            //     $imageName=time().uniqid().$file->getClientOriginalName();
            //     $filePath = 'images/webseries/' . $imageName;
            //     \Storage::disk('public')->put($filePath, file_get_contents($file));
            //     $webseries_poster = $filePath;
            // }else{
            //     $webseries_poster = '';
            // }

            $webseries = new WebSeries();
            $webseries->name = $request->name;
            $webseries->banner = $request->banner;                                  
            $webseries->description = $request->webseries_description;                        
            $webseries->release_date = $request->release_date ?? null;                                                                    
            $webseries->status = $request->status;
            $webseries->youtube_trailer = $request->trailer_url ?? null;
            $webseries->genres = implode(',', $request->webseries_genre);

            // print_r($request->all()); exit;
            if($webseries->save()){                
                // foreach ($request->webseries_genre as $key => $genre) {
                //     $WebseriesGenre = new WebSeriesGenre();
                //     $WebseriesGenre->web_series_id = $webseries->id;
                //     $WebseriesGenre->genre_id = $genre;
                //     $WebseriesGenre->save();
                // }

                if ($request->has('content_network') && !empty($request->content_network)) {
                    $cur_webseries = WebSeries::where('id', $webseries->id)->first();                
                    foreach ($request->content_network as $key => $network) {
                        $MovieNetwork = new WebSeriesContentNetwork();
                        $MovieNetwork->webseries_id  = $webseries->id;
                        $MovieNetwork->network_id = $network;                    
    
                        if ($MovieNetwork->save()) {
                            DB::table('content_network_log')->insert([
                                'content_id' => $webseries->id,
                                'network_id' => $network,
                                'content_type' => $cur_webseries->content_type,                            
                            ]);
                        }
                    }
                }
                // return back()->with('message','Webseries added successfully');
                return redirect()->route('admin.webseries.seasons', base64_encode($webseries->id))->with('message', 'Webseries added successfully');
            }else{
                return back()->with('message','Webseries not added successfully');
            }
        }

    }

    public function edit($id){  
        $webseries = Webseries::where('id', base64_decode($id))->first();              
        $this->data['webseries']  = $webseries;
        $this->data['genres'] = Genre::where('status',1)->get();
        $this->data['networks'] = ContentNetwork::where('deleted_at', null)->get();
        
        $channelGenre = explode(',', $webseries->genres);
        $this->data['channelGenre'] = $channelGenre;
        // $channelGenreIds = Genre::whereIn('title', $channelGenre)->pluck('id')->toArray();

        $seriesNetwork = WebSeriesContentNetwork::where('webseries_id', base64_decode($id))->get();
        // print_r($channelGenre); exit();
        // $this->data['channelGenre'] = [];
        $this->data['seriesNetwork'] = [];
        

        if($seriesNetwork){
            foreach ($seriesNetwork as $key => $value) {
                $this->data['seriesNetwork'][] = $value->network_id;
            }
        }
        // print_r($this->data['seriesNetwork']); exit;
        return view('admin.webseries.add',$this->data);
    }

    public function destroy(Request $request){
        $webseries = Webseries::where('id',base64_decode($request->id))->first();
        $webseries->deleted_at = time();
        if($webseries->save()){
            $seasons = WebSeriesSeason::where('web_series_id', $webseries->id)->get();

            if ($seasons) {                
                foreach ($seasons as $key => $season) {
                    $episodes = WebSeriesEpisode::where('seson_id', $season->id)->get();
                    if ($episodes) {                    
                        WebSeriesEpisode::where('season_id', $season->id)->delete();
                    }
                } 
                WebSeriesSeason::where('web_series_id', $webseries->id)->delete();           
            }
            echo json_encode(['message','Webseries deleted successfully']);
        }else{
            echo json_encode(['message','Webseries not deleted successfully']);
        }
    }

    public function updateStatus($id){
        $webseries = Webseries::find(base64_decode($id));        
        if($webseries){
            $webseries->status = $webseries->status == '1' ? '0' : '1';
            $webseries->save();
            echo json_encode(['message','Webseries status updated successfully']);
        }else{
            echo json_encode(['message','Something went wrong!!']);
        }
    }
}

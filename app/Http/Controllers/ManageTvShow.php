<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TvShow;

class ManageTvShow extends Controller
{
    public function index()
    {
        return view('admin.tvshow.index');
    }

    public function getTvShowList(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'name',
            2 => 'thumbnail',
            3 => 'genre',
            4 => 'description',
            5 => 'tv_channel_id',
            6 => 'release_date',
        ];

        $totalData = TvShow::whereNull('deleted_at')->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order.0.column') ? $columns[$request->input('order.0.column')] : 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';

        if (empty($request->input('search.value'))) {
            $tvshows = TvShow::whereNull('deleted_at')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $tvshows = TvShow::where(function($query) use ($search) {
                    $query->where('id', 'LIKE', "%{$search}%")
                          ->orWhere('name', 'LIKE', "%{$search}%");
                })
                ->whereNull('deleted_at')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = TvShow::where(function($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%");
            })
            ->whereNull('deleted_at')
            ->count();
        }

        $data = [];
        foreach ($tvshows as $tvshow) {
            $tvshowsData['id'] = $tvshow->id;
            $tvshowsData['name'] = $tvshow->name;
            $tvshowsData['thumbnail'] = $tvshow->image ?? '';
            $tvshowsData['genre'] = $tvshow->genre ?? '';
            $tvshowsData['description'] = $tvshow->description ?? '';
            $tvshowsData['tv_channel_id'] = $tvshow->tv_channel_id ?? '';
            $tvshowsData['release_date'] = $tvshow->release_date ?? '';

            $statusUrl = url('tvshow/update-status', base64_encode($tvshow->id));
            $checked = $tvshow->status == 1 ? 'checked' : '';
            $tvshowsData['status'] = '<a onchange="updateStatus(\'' . $statusUrl . '\')" href="javascript:void(0);">
                <label class="switch s-primary mr-2">
                    <input type="checkbox" value="' . $tvshow->status . '" ' . $checked . ' id="accountSwitch' . $tvshow->id . '">
                    <span class="slider round"></span>
                </label>
            </a>';

            $tvshowsData['action'] = '<div class="action-btn">
                <a href="edit-tvshow/' . base64_encode($tvshow->id) . '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                        <a href="javascript:;" onclick="delete_item(\''.base64_encode($tvshow->id) . '\',\'tvshow\')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                      </div>';

            $data[] = $tvshowsData;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,
        ]);
    }

    public function addtvshow()
    {
        return view('admin.tvshow.add');
    }

    public function updateStatus($id)
    {
        $tvshow = TvShow::find(base64_decode($id));

        if ($tvshow) {
            $tvshow->status = $tvshow->status == 1 ? 0 : 1;
            $tvshow->save();
            return response()->json(['message' => 'TvShow status updated successfully']);
        }

        return response()->json(['message' => 'Something went wrong!!']);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if (!empty($request->id)) {
            $tvshow = TvShow::find($request->id);
        } else {
            $tvshow = new TvShow();
        }

        $tvshow->name = $request->name;
        $tvshow->description = $request->description;
        $tvshow->status = $request->status;

        if ($tvshow->save()) {
            return back()->with('message', $request->id ? 'TvShow updated successfully' : 'TvShow added successfully');
        } else {
            return back()->with('message', $request->id ? 'TvShow not updated' : 'TvShow not added');
        }
    }

    public function editTvShow($id)
    {
        $this->data['tvshow'] = TvShow::find(base64_decode($id));
        return view('admin.tvshow.add', $this->data);
    }

    public function destroy(Request $request)
    {
        $tvshow = TvShow::find(base64_decode($request->id));
        $tvshow->deleted_at = time();

        if ($tvshow->save()) {
            return response()->json(['message' => 'TvShow deleted successfully']);
        } else {
            return response()->json(['message' => 'TvShow not deleted']);
        }
    }

    public function getTvShowOrderList()
    {
        $this->data['tvshows'] = TvShow::orderBy('index', 'asc')->get();
        return view('admin.tvshow.dragdrop', $this->data);
    }

    public function saveTvShowOrders(Request $request)
    {
        foreach ($request->numbers as $key => $id) {
            $tvshow = TvShow::find($id);
            $tvshow->index = $key + 1;
            $tvshow->save();
        }

        return back()->with('message', 'TvShow ordered successfully');
    }
}

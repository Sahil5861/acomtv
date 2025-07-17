@extends('layout.default')
@section('mytitle', 'Admin List')
@section('page', 'Channels  /  List')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <p class=""><small>Total Episodes</small></p>
                            <h6 class="value" id="totalRecords">--</h6>
                            <!-- <p class=""><small>Total Channels</small></p> -->
                        </div>
                        <div class="">
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <p class=""><small>Active Episodes</small></p>
                            <h6 class="value" id="activeRecords">--</h6>
                            <!-- <p class=""><small>Total Channels</small></p> -->
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #8dbf42;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <p class=""><small>Inactive Episodes</small></p>
                            <h6 class="value" id="inactiveRecords">--</h6>
                            <!-- <p class=""><small>Total Channels</small></p> -->
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color:#e2a03f">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <p class=""><small>Deleted Episodes</small></p>
                            <h6 class="value" id="deletedRecords">--</h6>
                            <!-- <p class=""><small>Total Channels</small></p> -->
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #e7515a">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            
            <div class="widget-content widget-content-area br-6">

                <div id="delete_bd_ms"></div>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>    
                        <strong>{{ session()->get('message') }}</strong>
                    </div>
                @endif 
                
                <?php
                    $season = \App\Models\KidShowsSeason::where('id',$id)->first();
                    $show = \App\Models\KidsShow::where('id',$season->show_id)->first();
                    $channel = \App\Models\KidsChannel::where('id',$show->kid_channel_id)->first();
                    // $channel = \App\Models\KidsChannel::where('id',$show->kid_channel_id)->first();
                ?>
                <div class="text-left">
                    <p>
                        <a href="{{route('admin.kidschannel')}}">{{strtoupper('Kids Channels')}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.kidsshows', base64_encode($channel->id))}}">{{strtoupper($channel->name)}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.kidshowsseason', base64_encode($show->id))}}">{{strtoupper($show->name)}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.kid-shows.episodes', base64_encode($season->id))}}">{{strtoupper($season->season_name)}}</a>&nbsp; &gt;                        
                    </p>
                </div>
                <div class="text-right"> 
                    <a href="{{ route('admin.kidsshowepisode.order', base64_encode($id)) }}" class="btn btn-primary mb-2">Order Episode</a>
                    <a href="{{url('add-kid-shows-episode/'.base64_encode($id))}}" class="btn btn-primary mb-2">Add +</a>
                    <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addContentModal">
                        Import from Playlist
                    </button> 
                </div>
                <div class="modal fade" id="addContentModal" tabindex="-1" role="dialog" aria-labelledby="addContentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="addContentModalLabel">Add Movies From Playlist</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">                                
                            <form id="importmoviesForm" method="POST" action="{{route('importkidshowsepisode')}}">
                            @csrf
                            <input type="hidden" name="season_id" id="season_id" value="{{$season->id}}">
                                <div class="form-group">
                                    <label for="networkName">Playlits Id</label>                                    
                                    <input type="text" class="form-control" name="playlist_id" id="playlist_id" required placeholder="Enter Playlist Id"> 
                                </div>
                                
                                <div class="form-group">
                                    <label for="networkName">Type</label>                                    
                                    <select name="type" id="type" class="form-control select">
                                        <option value="0" @if(isset($episode) && $episode->type == 0){{'selected'}}@endif>Free</option>
                                        <option value="1" @if(isset($episode) && $episode->type == 1){{'selected'}}@endif>Premium</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" form="importmoviesForm" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                        </div>
                    </div>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    
                    <table id="multi-column-ordering" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>                                                                                                                         
                                <th>Thumbnail</th>
                                <th>Status</th>
                                <th>Source</th>
                                <th>Play</th>
                                <th>Downloadable</th>
                                <th>Type</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableItem">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>                                                                                                                                
                                <th>Thumbnail</th>
                                <th>Status</th>
                                <th>Source</th>
                                <th>Play</th>
                                <th>Downloadable</th>
                                <th>Type</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog action-modal">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="d_title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="delete_user_deletemsg">Do you want to delete this <span id="d_body"></span>?</p>
            </div>
            <input type="hidden" name="id" id="d_id" value="">
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
              <button type="button" class="btn btn-danger" onclick="delete_row(this);" >Yes, Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

@endsection

@section('footer')
<!-- <script>
    $(document).ready(function() { 
      var table = $('#multi-column-ordering').DataTable({ 
            // "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
             "language": {
                "infoFiltered": '' 
            },
     
            // Load data for the table's content from an Ajax source
            "ajax": { 
                "url": "{{route('getAdminList')}}",
                // "type": "POST",
                "data": function ( d ) {
                    console.log(d);
                    // d.parent_cat = $("#parent_cat").val();
                            
                }
            },

            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile', name: 'mobile'},
                {data: 'address', name: 'address'},
                {data: 'city', name: 'city'},
                {data: 'country', name: 'country'},
                {data: 'company_name', name: 'company_name'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
          
        });

      $("input#search").on("keyup", function (event) {
            if ($('#search').val().length >= 3 || $('#search').val().length == 0) {
                table.draw(), event.preventDefault()
            }
        });
        $("#btn-search").click(function (a) {
            table.draw(), a.preventDefault()
        });

    });
    </script> -->

    <script src="cdn.datatables.net/plug-ins/1.12.1/sorting/date-uk.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){        
      // DataTable
      $('#multi-column-ordering').DataTable({
         processing: true,
         serverSide: true,
         order: [[7, 'desc']],
         ajax: "{{route('getKidsShowEpisodesList', $id)}}",
         columns: [
            { data: 'Episoade_Name' },                        
            { data: 'image',orderable: false, searchable: false },                        
            { data: 'status',orderable: false, searchable: false  },
            { data: 'source' },
            { data: 'play_btn' },
            { data: 'downloadable',orderable: false, searchable: false  },
            { data: 'type',orderable: false, searchable: false  },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false },
         ],
         drawCallback: function (settings) { 
            
            var response = settings.json;
            $('#totalRecords').text(response.totalRecords);
            $('#activeRecords').text(response.activeRecords);
            $('#inactiveRecords').text(response.inactiveRecords);
            $('#deletedRecords').text(response.deletedRecords);
            console.log(response);
            $('[data-toggle="tooltip"]').tooltip();
            updateIcon()
        },
      });
    });

    function deleteRowModal(id){ 
        $('#d_title').text('Kid shows Episode')
        $('#d_id').val(id);
        $('#delete_modal').modal('show');        
    }

    function delete_row(){
        var id = $('#d_id').val();
        $.ajax({
            type: 'POST',
            url: "{{route('kid-shows-episode.destroy')}}",
            data: {
                _token: '{{ csrf_token() }}',
                id:id
            },
            success: function(data){
                $('#delete_modal').modal('hide');
                $('#multi-column-ordering').DataTable().ajax.reload();
            }
        })
    }
    </script>

   
<!-- footer script if required -->
@endsection
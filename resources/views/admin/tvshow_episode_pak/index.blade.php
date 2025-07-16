@extends('layout.default')
@section('mytitle', 'Admin List')
@section('page', 'Show Episodes Pak  /  List')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <p class=""><small>Total Episodes Pak</small></p>
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
                            <p class=""><small>Active Episodes Pak</small></p>
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
                            <p class=""><small>Inactive Episodes Pak</small></p>
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
                            <p class=""><small>Deleted Episodes Pak</small></p>
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

                <div class="alert alert-success alert-block" id="alert-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong class="success-message"></strong>
                </div>

                <div class="alert alert-danger alert-block" id="alert-danger" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong class="error-message"></strong>
                </div>

                <div id="delete_bd_ms"></div>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>    
                        <strong>{{ session()->get('message') }}</strong>
                    </div>
                @endif  
                
                <?php                     
                    $season = \App\Models\TvShowSeasonPak::where('id', $id)->first();
                    $show = \App\Models\TvShowPak::where('id', $season->show_id)->first();
                    $channel = \App\Models\TvChannelPak::where('id', $show->tv_channel_id)->first();
                ?>

                <div class="text-left">
                    <p>
                        <a href="{{route('admin.tvchannel')}}">{{strtoupper('TV Channels Pak')}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.tvshow', base64_encode($channel->id))}}">{{strtoupper($channel->name)}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.tvshow.season', base64_encode($show->id))}}">{{strtoupper($show->name)}}</a>&nbsp; &gt;                        
                        <a href="{{route('admin.tvshow.episode', base64_encode($id))}}">{{strtoupper($season->title)}}</a>
                    </p>
                </div>
                
                <div class="text-right" style="display: flex; justify-content:flex-end;align-items:center; gap:10px;">                    
                    <a href="{{ route('admin.tvshowepisode.order', base64_encode($id)) }}" class="btn btn-primary mb-2">Order Episode</a>
                    <a href="{{route('addTvShowEpisodepak', base64_encode($id))}}" class="btn btn-primary mb-2">Add +</a>
                    <div class="text-left">
                        <button type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#addContentModal">
                            Import from Playlist
                        </button>   
                    </div>                    
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
                                <form id="importmoviesForm" method="POST" action="{{route('importtvshowsepisodeplaylits')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                    <div class="form-group">
                                        <label for="networkName">Playlits Id</label>                                    
                                        <input type="text" class="form-control" name="playlist_id" id="playlist_id" required placeholder="Enter Playlist Id"> 
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
                    
                    <table id="multi-column-ordering" class="table table-hover" data-table="shows_episodes">
                        <thead>
                            <tr>                                
                                <th class="editable-th" data-column="title">Title</th>                                                                                                                         
                                <th>Thumbnail</th>                                                                                                                                                                                                                                                                                                                     
                                <th>Status</th> 
                                <th>Play</th>                                                                                                                                                                                                                                                                                                                          
                                <th>Duration</th>                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                <th>Playlist_id</th>                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableItem">
                            
                        </tbody>
                        <tfoot>
                            <tr>                                
                                <th>Title</th>                                                                                                                         
                                <th>Thumbnail</th> 
                                <th>Status</th>  
                                <th>Play</th>                                                                                                                                                                                                                                                                                                                            
                                <th>Duration</th>
                                <th>Playlist_id</th>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
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
         order: [[4, 'desc']],
         ajax: "{{route('getTvShowEpisodeListPak', $id)}}",
         columns: [            
            { data: 'title' },                                                          
            { data: 'thumbnail',orderable: false, searchable: false },                                                                                      
            { data: 'status' },            
            { data: 'play_btn' },            
            { data: 'duration' },            
            { data: 'playlist_id' },            
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false },
         ],
         columnDefs: [
            {
                targets: 0, // index of 'name' column
                createdCell: function(td, cellData, rowData, row, col) {
                    // $(td).addClass('editable');
                    $(td).attr('data-id', rowData.id); // Set data-id attribute
                }
            },            
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
            setTimeout(() => {        
                setEditable();
            }, 500);
        },
      });        
    });

    function setEditable(){
    $('#multi-column-ordering thead th').each(function (index) {            
            
        if ($(this).hasClass('editable-th')) {                    
            $('#tableItem tr').each(function () {
                $(this).find('td').eq(index).addClass('editable');                                
            });
        }
    });
}


    function deleteRowModal(id){ 
        $('#d_title').text('TV Shows Episode Pak')
        $('#d_id').val(id);
        $('#delete_modal').modal('show');        
    }

    function delete_row(){
        var id = $('#d_id').val();
        $.ajax({
            type: 'POST',
            url: "{{route('tvshowepisodepak.destroy')}}",
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

    document.addEventListener('dblclick', function (event){
        const target = event.target
        if (target.classList.contains('editable')) {        
            if (target.querySelector('input')) return;
            const currentText = target.textContent.trim();
            const input = document.createElement('input'); 
            const id = target.getAttribute('data-id');       

            input.type = 'text';
            input.value = currentText;
            input.style.width = '100%';
            input.classList.add('form-control');
            input.setAttribute('data-id', id);

            target.textContent = '';
            target.appendChild(input);
            input.focus();

            input.addEventListener('blur', function () {
                const newValue = input.value.trim();
                target.textContent = newValue || currentText; // fallback to old value if empty
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    input.blur(); // triggers blur above
                    const table = document.getElementById('multi-column-ordering').getAttribute('data-table');                
                    const td = input.closest('td');


                    const column = document.querySelector('.editable-th').getAttribute('data-column');
                    let id = input.getAttribute('data-id');

                    console.log(id, table, column);
                    // return false;
                    

                    $.ajax({
                        method : 'POST',
                        url : "{{route('update-column')}}",                    
                        data: {
                            id : id,                        
                            table : table,
                            column : column,  
                            value : input.value, 
                            _token: "{{ csrf_token() }}" // ✅ Add this line                     
                        },
                        success: function(response){
                            if (response.success) {
                                const capitalizedColumn = column.charAt(0).toUpperCase() + column.slice(1);
                                $('.success-message').html(`${capitalizedColumn} updated successfully !`);
                                $('#alert-success').show();
                                setTimeout(() => {
                                    $('#alert-success').hide();
                                }, 2000);
                                // $('#multi-column-ordering').DataTable().ajax.reload();
                            }
                            else{
                                const capitalizedColumn = column.charAt(0).toUpperCase() + column.slice(1);
                                $('.error-message').html(response.message);
                                $('#alert-danger').show();
                                setTimeout(() => {
                                    $('#alert-danger').hide();
                                }, 2000);
                                target.textContent = currentText;
                                // $('#multi-column-ordering').DataTable().ajax.reload();
                            }
                        }
                    })
                    
                }
            });    
        }
    })
    </script>

   
<!-- footer script if required -->
@endsection
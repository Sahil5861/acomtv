@extends('layout.default')
@section('mytitle', 'Tv Channel List')
@section('page', 'Tv Channel / List')
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div id="delete_bd_ms"></div>

                @if(session()->has('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>    
                        <strong>{{ session()->get('message') }}</strong>
                    </div>
                @endif

                <div class="text-right">
                    <a href="{{ url('add-tvchannel') }}" class="btn btn-primary mb-2">Add +</a>
                </div>

                <div class="table-responsive mb-4 mt-4">
                    <table id="multi-column-ordering" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Logo</th>
                                <th>Language</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Logo</th>
                                <th>Language</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
$(document).ready(function() {
    var table = $('#multi-column-ordering').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        language: {
            infoFiltered: ''
        },
        ajax: {
            url: "{{ route('getTvChannelList') }}",
            data: function (d) {
                console.log(d);
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { 
                data: 'logo', 
                name: 'logo',
                render: function(data) {
                    if (data) {
                        return '<img src="/' + data + '" alt="Logo" height="40">';
                    } else {
                        return '—';
                    }
                },
                orderable: false,
                searchable: false
            },
            { data: 'language', name: 'language' },
            { 
                data: 'description', 
                name: 'description',
                render: function(data) {
                    return data ? data.substring(0, 50) + '...' : '';
                }
            },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function(settings) {
            if (typeof updateIcon === 'function') {
                updateIcon(); // Only if your project uses Feather or similar
            }
        }
    });

    $("#search").on("keyup", function (event) {
        if ($('#search').val().length >= 3 || $('#search').val().length == 0) {
            table.draw();
            event.preventDefault();
        }
    });

    $("#btn-search").click(function (a) {
        table.draw();
        a.preventDefault();
    });
});
</script>
@endsection

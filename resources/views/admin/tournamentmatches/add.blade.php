@extends('layout.default')
@section('mytitle', 'Manage TvShow')
@if(isset($match))
@section('page', 'Matches / Update')
@else
@section('page', 'Season / Add')
@endif

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">

                @if(session()->has('message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session()->get('message') }}</strong>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="text-left">
                    <a href="{{route('admin.sporttournamentseasonsepisodes', base64_encode($id))}}" class="btn btn-sm  btn-primary mb-3">Back to List</a>
                </div>

                <form id="tournamentseason-form" method="post" action="{{ route('savesportstournamentseasonepisodes') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @if (isset($match))                        
                        <input type="hidden" name="id" value="{{isset($match) ? $match->id : ''}}">
                    @endif

                    <input type="hidden" name="tournament_season_id" id="tournament_season_id" value="{{$id}}">

                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-md-6 mb-4">
                            <label for="name">Match Title</label>
                            <input type="text" class="form-control" id="match_title" name="match_title" placeholder="Match Title" value="{{ old('match_title', $match->match_title ?? '') }}" required>
                            <div class="invalid-feedback">
                                @error('season_title') {{ $message }} @enderror
                            </div>
                        </div>




                        <!-- Match Date -->
                        <div class="col-md-6 mb-4">
                            <label for="thumbnail">Match Date</label>
                            <input type="date" class="form-control" id="match_date" name="match_date" placeholder="Enter Match Date" value="{{ old('match_date', $match->match_date ?? '') }}">                            
                            <div class="invalid-feedback">
                                @error('match_date') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Match Time -->
                        <div class="col-md-6 mb-4">
                            <label for="thumbnail">Match Time</label>
                            <input type="text" class="form-control flat_picker" id="match_time" name="match_time" placeholder="Enter Match Time" value="{{ old('match_time', $match->match_time ?? '') }}">                            
                            <div class="invalid-feedback">
                                @error('match_time') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Streaming Info -->
                        <div class="col-md-6 mb-4">
                            <label for="status">Streaming Info</label>
                            <select name="streaming_info" id="streaming_info" class="form-control select">
                                <option value="">--Select Streaming Info--</option>
                                <option value="Live" @if(old('streaming_info', $match->streaming_info ?? '') == 'Live') selected @endif>Live</option>
                                <option value="Replay" @if(old('streaming_info', $match->streaming_info ?? '') == 'Replay') selected @endif>Replay</option>
                                <option value="Highlights" @if(old('streaming_info', $match->streaming_info ?? '') == 'Highlights') selected @endif>Highlights</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('streaming_info') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Streaming Info -->
                        <div class="col-md-6 mb-4">
                            <label for="status">Match Type</label>
                            <select name="match_type" id="match_type" class="form-control select">
                                <option value="">--Select Match Type--</option>
                                <option value="League" @if(old('streaming_info', $match->match_type ?? '') == 'League') selected @endif>League</option>
                                <option value="Knockout" @if(old('streaming_info', $match->match_type ?? '') == 'Knockout') selected @endif>Knockout</option>
                                <option value="Final" @if(old('streaming_info', $match->match_type ?? '') == 'Final') selected @endif>Final</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('streaming_info') {{ $message }} @enderror
                            </div>
                        </div>




                        <!-- Status -->
                        <div class="col-md-6 mb-4">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if(old('status', $match->status ?? '') == 1) selected @endif>Active</option>
                                <option value="0" @if(old('status', $match->status ?? '') == 0) selected @endif>Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('status') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Description">{{ old('description', $match->description ?? '') }}</textarea>
                            <div class="invalid-feedback">
                                @error('description') {{ $message }} @enderror
                            </div>
                        </div>
                        
                    </div>

                    <button class="btn btn-primary submit-fn mt-4" type="submit">
                        {{ isset($tournamentseason) ? 'Update' : 'Add' }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<!-- Custom JS if needed -->
@endsection

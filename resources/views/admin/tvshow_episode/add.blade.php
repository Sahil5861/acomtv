@extends('layout.default')
@section('mytitle', 'Manage TvShow')
@if(isset($episode))
@section('page', 'TvShow / Update')
@else
@section('page', 'TvShow / Add')
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

                <form id="episode-form" method="post" action="{{ route('saveTvShowEpisode') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @if (isset($episode))                        
                        <input type="hidden" name="id" value="{{isset($episode) ? $episode->id : ''}}">
                    @endif

                    <input type="hidden" name="season_id" id="season_id" value="{{$id}}">

                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-md-6 mb-4">
                            <label for="name">Title*</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ isset($episode) ? $episode->title : '' }}" required>
                            <div class="invalid-feedback">
                                @error('title') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Episode Number -->
                        <div class="col-md-6 mb-4">
                            <label for="name">Episode Number</label>
                            <input type="text" class="form-control" id="episode_number" name="episode_number" placeholder="Episode Number" value="{{ old('title', $episode->title ?? 0) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="col-md-6 mb-4">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter Duration in minutes" value="{{ old('logo', $episode->duration ?? '') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">                            
                            <div class="invalid-feedback">
                                @error('thumbnail') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="name">Video Url*</label>
                            <input type="text" class="form-control" id="url" name="video_url" placeholder="URL" value="{{ old('url', $episode->video_url ?? '') }}" required>
                            <div class="invalid-feedback">
                                @error('url') {{ $message }} @enderror
                            </div>
                        </div>

                        
                        <!-- Status -->
                        <div class="col-md-6 mb-4">
                            <label for="status">Thumbnail</label>
                            <input type="text" name="thumbnail" id="thumbnail" class="form-control" placeholder="Thumbnail Url" value="{{old('thumbnail', $episode->thumbnail ?? '')}}">
                            <div class="invalid-feedback">
                                @error('status') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="status">Release Date</label>
                            <input type="date" name="release_date" id="release_date" class="form-control" placeholder="Release Date" value="{{old('release_date', $episode->release_date ?? '')}}">
                            <div class="invalid-feedback">
                                @error('release_date') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Description">{{ old('description', $episode->description ?? '') }}</textarea>
                            <div class="invalid-feedback">
                                @error('description') {{ $message }} @enderror
                            </div>
                        </div>
                        
                    </div>

                    <button class="btn btn-primary submit-fn mt-4" type="submit">
                        {{ isset($episode) ? 'Update' : 'Add' }}
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

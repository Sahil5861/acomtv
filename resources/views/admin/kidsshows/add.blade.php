@extends('layout.default')
@section('mytitle', 'Manage TvShow')
@if(isset($kidsshow))
@section('page', 'TvShow / Update')
@else
@section('page', 'TvShow / Add')
@endif

kidsshows
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

                <form id="kidsshow-form" method="post" action="{{ route('admin.kidsshows.save') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($kidsshow))                        
                        <input type="hidden" name="id" value="{{isset($kidsshow) ? $kidsshow->id : ''}}">
                    @endif

                    <input type="hidden" name="kid_channel_id" id="kid_channel_id" value="{{$id}}">

                    <div class="form-row">
                        <!-- Name -->
                        <div class="col-md-6 mb-4">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Name"
                                value="{{ old('name', $kidsshow->name ?? '') }}" required>
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @enderror
                            </div>
                        </div>

                        {{-- Sets order: uses existing value for edit, or calculates next order based on channel for add --}}
                        @php
                            $order = isset($tv_shows)
                                ? $tv_shows->order
                                : (\App\Models\KidsShow::where('kid_channel_id', $id)
                                    ->whereNull('deleted_at')
                                    ->max('order') ?? 0) + 1;
                        @endphp

                        <input type="hidden" name="order" value="{{ old('order', $order) }}">

                        {{-- <!-- Language -->
                        <div class="col-md-6 mb-4">
                            <label for="language">Language</label>
                            <input type="text" class="form-control" id="language" name="language"
                                placeholder="e.g. Hindi, English"
                                value="{{ old('language', $kidsshow->language ?? '') }}" required>
                            <div class="invalid-feedback">
                                @error('language') {{ $message }} @enderror
                            </div>
                        </div> --}}

                        <!-- Logo -->
                        <div class="col-md-6 mb-4">
                            <label for="thumbnail">Thumbnail</label>
                            <input type="text" class="form-control" id="thumbnail" name="thumbnail"
                                placeholder="Enter image path or URL"
                                value="{{ old('logo', $kidsshow->thumbnail ?? '') }}">
                            @if(isset($kidsshow) && $kidsshow->thumbnail)
                                <img src="{{ $kidsshow->thumbnail }}" width="70" style="margin-top: 5px;" alt="Logo Preview">
                            @endif
                            <div class="invalid-feedback">
                                @error('thumbnail') {{ $message }} @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="genre">Genre</label>
                            {{-- <input type="text" class="form-control" id="genre" name="genre"placeholder="Genre"value="{{ old('genre', $kidsshow->genre ?? '') }}" required> --}}
                            <select name="genre[]" id="genre" class="form-control select" multiple required>
                                @foreach ($genres as $genre)
                                    <option value="{{$genre->title}}"
                                        @if (isset($kidsshow) && in_array($genre->title, $currentGenres)) selected @endif>
                                        {{$genre->title}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('genre') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-4">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if(old('status', $kidsshow->status ?? '') == 1) selected @endif>Active</option>
                                <option value="0" @if(old('status', $kidsshow->status ?? '') == 0) selected @endif>Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('status') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Description">{{ old('description', $kidsshow->description ?? '') }}</textarea>
                            <div class="invalid-feedback">
                                @error('description') {{ $message }} @enderror
                            </div>
                        </div>
                        
                    </div>

                    <button class="btn btn-primary submit-fn mt-4" type="submit">
                        {{ isset($kidsshow) ? 'Update' : 'Add' }}
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

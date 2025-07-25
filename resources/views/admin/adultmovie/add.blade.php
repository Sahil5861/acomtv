@extends('layout.default')
@section('mytitle', 'Manage Channels')
@if(isset($channel))
@section('page', 'Channel  / Update')
@endif
@if(!isset($channel))
@section('page', 'Channel  / Add')
@endif
@section('content')

<style>
    .channel-error, .channel-number-error{
        color: #e7515a;
        font-size: 13px;
        letter-spacing: 1px;
    }
</style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
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
                <!-- <div class="row"> -->
                    <a href="{{route('admin.adultmovies')}}" class="btn btn-primary mb-3">Back to List</a>
                    <form id="user-form"  method="post" action="{{route('save-above-18')}}" enctype="multipart/form-data" novalidate class="simple-example" >
                        @csrf
                        <input type="hidden" name="id" value="@if(isset($movie)){{$movie->id}}@endif">
                        <input type="hidden" name="channel_logo_old" value="@if(isset($channel)){{$channel->channel_logo}}@endif">
                        <div class="form-row">
                            {{-- <div class="col-md-6 mb-4">
                                <label for="fullName">Channel Number*</label>
                                <input type="text" class="form-control" id="channel_number" onkeyup="channelNumber(this.value)" name="channel_number" placeholder="Channel Number" value="{{old('channel_number')}}@if(isset($channel)){{$channel->channel_number}}@endif" required>
                                <div class="invalid-feedback">
                                    @error('channel_number') {{ $message }} @enderror
                                </div>
                                <div class="channel-number-error"></div>
                            </div> --}}

                            <?php 
                                $channel_number = \App\Models\AdultMovie::whereNull('deleted_at')->count();
                                $formated_number = $channel_number + 1;
                            ?>

                            <div class="col-md-6 mb-4">
                                <label for="fullName">Movie Name*</label>
                                <input type="text" class="form-control" id="name" onkeyup="channel(this.value)" name="name" placeholder="Movie Name" value="{{old('name')}}@if(isset($movie)){{$movie->name}}@endif" required>
                                <div class="invalid-feedback">
                                    @error('channel_name') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="fullName">Movie Index*</label>
                                <input type="number" class="form-control" id="index" name="index" placeholder="Movie Index" value="{{old('index',isset($movie) ? $movie->index : $formated_number)}}" required>
                                <div class="invalid-feedback">
                                    @error('channel_name') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="release_date">Release Date</label>
                                <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date', isset($movie) ? $movie->release_date : '') }}">
                                <div class="invalid-feedback">
                                    @error('release_date') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>

                            </div>

                            {{-- <div class="col-md-6 mb-4">
                                <label for="release_date">Runtime <small>(in minutes)</small> *</label>
                                <input type="number" name="runtime" id="runtime" class="form-control" value="{{old('runtime', isset($movie) ? $movie->runtime : '')}}" required placeholder="Runtime (in minutes)">
                                <div class="invalid-feedback">
                                    @error('runtime') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>
                            </div> --}}

                            <div class="col-md-6 mb-4">
                                <label for="stream_type">Stream Type*</label>
                                <select name="source_type" id="source_type" class="form-control select">
                                    <option value="M3u8" @if(isset($movie) && $movie->source_type == 'M3u8'){{'selected'}} @endif>M3u8</option>
                                    <option value="YoutubeLive" @if(isset($movie) && $movie->source_type == 'YoutubeLive'){{'selected'}} @endif>Youtube</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('stream_type') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="trailer">Trailer Url <small>(youtube id only)</small></label>
                                <input type="text" name="trailer_url" id="trailer_url" class="form-control" value="{{old('trailer', isset($movie) ? $movie->youtube_trailer : '')}}" placeholder="Trailer Url">
                                <div class="invalid-feedback">
                                    @error('trailer') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="trailer">Movie Url*</label>
                                <input type="text" name="movie_url" id="movie_url" class="form-control" value="{{old('trailer', isset($movie) ? $movie->movie_url : '')}}" placeholder="Movie Url" required>
                                <div class="invalid-feedback">
                                    @error('movie_url') {{ $message }} @enderror
                                </div>
                                <div class="channel-error"></div>
                            </div>

                            {{-- <div class="col-md-6 mb-4">
                                <label for="fullName">Movie Image* </label>
                                <input type="file" class="form-control" id="image" name="image" >
                                @if(isset($movie) && $movie->banner!='')
                                    <img style="position: absolute;" src="{{asset($movie->banner)}}" width="30px">
                                @endif
                                <div class="invalid-feedback">
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="fullName">Movie Poster Image* </label>
                                <input type="file" class="form-control" id="movie_poster" name="movie_poster">
                                @if(isset($movie) && $movie->poster!='')
                                    <img style="position: absolute;" src="{{asset($movie->poster)}}" width="30px">
                                @endif
                                <div class="invalid-feedback">
                                    @error('channel_bg') {{ $message }} @enderror
                                </div>
                            </div>                         --}}

                            <div class="col-md-6 mb-4">
                                <label for="banner">Movie Banner*</label>
                                <input type="text" name="banner" id="banner" class="form-control" placeholder="Movie Banner" value="{{ old('banner', isset($movie) ? $movie->banner : '') }}" required>
                                @if (isset($movie->banner))
                                    <img src="{{$movie->banner}}" alt="image" style="width:100px" class="img my-2">
                                @endif
                            </div>

                            {{-- <div class="col-md-6 mb-4">
                                <label for="banner">Movie Poster</label>
                                <input type="text" name="poster" id="poster" class="form-control" placeholder="Movie Poster" value="{{ old('poster', isset($movie) ? $movie->poster : '') }}">
                            </div> --}}

                            <div class="col-md-6 mb-4">
                                <label for="fullName">Genre*</label>
                                <select name="movie_genre[]" id="movie_genre" multiple class="form-control select" required>
                                     <!-- <option value="">--Select Genre--</option> -->
                                    <?php
                                    foreach($genres as $genre){
                                        if(isset($channelGenre) && in_array($genre->title,$channelGenre)){

                                             echo '<option value="'.$genre->title.'" selected>'.$genre->title.'</option>';

                                        }else{
                                            echo '<option value="'.$genre->title.'">'.$genre->title.'</option>';
                                        }
                                    }
                                 ?>
                                </select>
                                <div class="invalid-feedback">
                                    @error('movie_genre') {{ $message }} @enderror
                                </div>                                
                            </div>
                            

                            {{-- <div class="col-md-6 mb-4">
                                <label for="channel_link">Channel Link*</label>
                                <input type="text" class="form-control" id="channel_link" name="channel_link" placeholder="Channel Link" value="{{old('channel_link')}}@if(isset($channel)){{$channel->channel_link}}@endif" required>
                                <div class="invalid-feedback">
                                    @error('channel_link') {{ $message }} @enderror
                                </div>
                            </div> --}}
                            
                            <div class="col-md-6 mb-4">
                                <label for="fullName">Content Networks</label>
                                <select name="content_network[]" id="content_networks" multiple class="form-control select">
                                     <!-- <option value="">--Select Genre--</option> -->
                                    <?php
                                    foreach($networks as $network){
                                        if(isset($movieNetwork) && in_array($network->id,$movieNetwork)){
                                            echo '<option value="'.$network->id.'" selected>'.$network->name.'</option>';
                                        }else{
                                            echo '<option value="'.$network->id.'">'.$network->name.'</option>';
                                        }
                                    }
                                 ?>
                                </select>
                                <div class="invalid-feedback">
                                    @error('movie_genre') {{ $message }} @enderror
                                </div>                                
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="fullName">Status</label>
                                <select name="status" id="status" class="form-control select">
                                    <option value="1" @if(isset($movie) && $movie->status == 1){{'selected'}}@endif>Active</option>
                                    <option value="0" @if(isset($movie) && $movie->status == 0){{'selected'}}@endif>De-Active</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('status') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="channel_description">Movie Description</label>
                                <textarea type="text" class="form-control" id="movie_description" name="movie_description" rows="3" placeholder="Movie Description">{{old('movie_description', isset($movie) ? $movie->description : '')}}</textarea>
                                <div class="invalid-feedback">
                                    @error('movie_description') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        @if(isset($movie))
                        <button class="btn btn-primary submit-fn mt-2" type="submit">Update</button>
                        @else
                        <button class="btn btn-primary submit-fn mt-2" type="submit">Add</button>
                        @endif

                    </form>
                <!-- </div> -->
            </div>
        </div>
    </div>

</div>

<script>
    function channel(val){
        var channel_name = val;
        console.log(channel_name);
        $.ajax({
            url: "{{ url('check-channel-name') }}",
            method: 'post',
            data: {
                'channel_name': channel_name,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result){
                if(result){
                    $('.channel-error').text('');
                }else{
                    $('.channel-error').text('Channel name not available');
                }
            }
        });
    }

    function channelNumber(val){
        var channel_number = val;
        $.ajax({
            url: "{{ url('check-channel-number') }}",
            method: 'post',
            data: {
                'channel_number': channel_number,
                "_token": "{{ csrf_token() }}"
            },
            success: function(result){
                if(result){
                    $('.channel-number-error').text('');
                }else{
                    $('.channel-number-error').text('Channel number already exists!!!');
                }
            }
        });
    }
</script>

@endsection

@section('footer')

<!-- footer script if required -->
@endsection

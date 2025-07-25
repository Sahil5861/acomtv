
<style>
    .tit{
        background: #0e1726;
        padding: 5px;
        width: 100%;
    }
</style>

<nav id="sidebar">
    <div class="shadow-bottom"></div>
    <ul class="list-unstyled menu-categories" id="accordionExample" style="padding-top: 30px;">
        <div class="tit">Main</div>
        <li class="menu">
            <a href="{{route('admin.dashboard')}}" <?php if(request()->is('*dashboard*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Dashboard</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <!-- <ul class="collapse submenu list-unstyled show" id="dashboard" data-parent="#accordionExample">
                <li class="active">
                    <a href="index.html"> Sales </a>
                </li>
                <li>
                    <a href="index2.html"> Analytics </a>
                </li>
            </ul> -->
        </li>
        <div class="tit">Content</div>
        @if(Auth::user()->role == 1)
        <li class="menu">
            <a href="{{route('admin.sliders')}}" <?php if(request()->is('*slider*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <span>Manage Slider</span>
                </div>
            </a>
        </li>
        {{-- <li class="menu">
            <a href="{{route('admin.superAdminWallet')}}" <?php if(request()->is('*admin-wallet*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path d="M18,7H15.79a5.49,5.49,0,0,0-1-2H18a1,1,0,0,0,0-2H7A1,1,0,0,0,7,5h3.5a3.5,3.5,0,0,1,3.15,2H7A1,1,0,0,0,7,9h7a3.5,3.5,0,0,1-3.45,3H7a.7.7,0,0,0-.14,0,.65.65,0,0,0-.2,0,.69.69,0,0,0-.19.1l-.12.07,0,0a.75.75,0,0,0-.14.17,1.1,1.1,0,0,0-.09.14.61.61,0,0,0,0,.18A.65.65,0,0,0,6,13s0,0,0,0a.7.7,0,0,0,0,.14.65.65,0,0,0,0,.2.69.69,0,0,0,.1.19s0,.08.07.12l6,7a1,1,0,0,0,1.52-1.3L9.18,14H10.5A5.5,5.5,0,0,0,16,9h2a1,1,0,0,0,0-2Z" stroke="currentColor" class="color000 svgShape"></path></svg>
                    <span>Wallet Transactions</span>
                </div>
            </a>
        </li> --}}
        <li class="menu">
            <a href="{{route('admin.roles')}}" <?php if(request()->is('*role*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage Role</span>
                </div>
            </a>
        </li>

        <!-- <li class="menu">
            <a href="{{route('admin.genres')}}" <?php if(request()->is('*genre*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage Genre</span>
                </div>
            </a>
        </li> -->
        <li class="menu">
            <a href="{{route('admin.contentnetwork')}}" <?php if(request()->is('*contentnetwork*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Content Networks</span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a href="{{route('admin.languages')}}" <?php if(request()->is('*language*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage Language</span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a href="#app1" data-toggle="collapse" <?php if(request()->is('*genre*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage Genre</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*genre*')){ echo 'show';} ?>" id="app1" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*genres')){ echo 'active';} ?>" >
                    <a href="{{route('admin.genres')}}"> List </a>
                </li>

                <li class="<?php if(request()->is('*channels-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.genre.order')}}"> Genre Order</a>
                </li>
            </ul>
        </li>
        <li class="menu">
            <a href="#app" data-toggle="collapse" <?php if(request()->is('channel*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Channels</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*channels*')){ echo 'show';} ?>" id="app" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*channels')){ echo 'active';} ?>" >
                    <a href="{{route('admin.channels')}}"> List </a>
                </li>

                <li class="<?php if(request()->is('*channels-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.channels.order')}}"> Change Order</a>
                </li>

                {{-- <li class="<?php if(request()->is('*deleted-channel')){ echo 'active';} ?>">
                    <a href="{{route('admin.channels.deleted')}}"> Deleted Channel</a>
                </li> --}}
            </ul>
        </li>

        <li class="menu">
            <a href="#app2" data-toggle="collapse" <?php if(request()->is('*movies*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Movie</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*movie*')){ echo 'show';} ?>" id="app2" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*movies')){ echo 'active';} ?>" >
                    <a href="{{route('admin.movies')}}"> List </a>
                </li>

                <li class="<?php if(request()->is('*movies-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.movie.order')}}"> Movie Order</a>
                </li>

                {{-- <li class="<?php if(request()->is('*deleted-channel')){ echo 'active';} ?>">
                    <a href="{{route('admin.channels.deleted')}}"> Deleted Channel</a>
                </li> --}}
            </ul>
        </li>

        <li class="menu">
            <a href="#app3" data-toggle="collapse" <?php if(request()->is('*webseries*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage webseries</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*webseries*')){ echo 'show';} ?>" id="app3" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*webseries')){ echo 'active';} ?>" >
                    <a href="{{route('admin.webseries')}}"> List </a>
                </li>
                <li class="<?php if(request()->is('*webseries-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.webseries.order')}}"> Webseries Order </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#tvapp" data-toggle="collapse" <?php if(request()->is('*tvshow*') || request()->is('*tvchannel*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage TV Channels</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*tvshow*') || request()->is('*tvchannel*')){ echo 'show';} ?>" id="tvapp" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*tvchannel')){ echo 'active';} ?>" >
                    <a href="{{route('admin.tvchannel')}}"> List </a>
                </li>
                <li class="<?php if(request()->is('*tvshow-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.tvchannel.order')}}"> TV Channels Order </a>
                </li>
            </ul>
            
        </li>

        <li class="menu">
            <a href="#sports" data-toggle="collapse" <?php if(request()->is('*sports*') || request()->is('*sports*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Manage Sports</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*sports*') || request()->is('*sports*')){ echo 'show';} ?>" id="sports" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*sports')){ echo 'active';} ?>" >
                    <a href="{{route('admin.sportscategory')}}"> List </a>
                </li>
                <li class="<?php if(request()->is('*sportscategory-order')){ echo 'active';} ?>">
                    <a href="{{route('admin.sportscategory.order')}}"> Sports Category Order </a>
                </li>
            </ul>
            
        </li>



        

        

        <li class="menu">
            <a href="{{route('admin.admins')}}" <?php if(request()->is('admins') || request()->is('add-admin')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Manage Admin</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{route('admin.netadmins')}}" <?php if(request()->is('netadmins') || request()->is('add-netadmin')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Manage Net Admin</span>
                </div>
            </a>
        </li>

        
        
        <li class="menu">
            <a href="#webapp" data-toggle="collapse" <?php if(request()->is('*webapp*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Webseries App</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*webapp*')){ echo 'show';} ?>" id="webapp" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*webapp')){ echo 'active';} ?>" >
                    <a href="{{route('admin.webseriesapp')}}"> List </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#applive" data-toggle="collapse" <?php if(request()->is('*livechannel*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Live Channels</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*livechannel*')){ echo 'show';} ?>" id="applive" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*livechannel')){ echo 'active';} ?>" >
                    <a href="{{route('admin.livechannel')}}"> List </a>
                </li>
            </ul>
        </li>
        
        <li class="menu">
            <a href="#movieapp" data-toggle="collapse" <?php if(request()->is('*movieapp*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Movie App</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*movieapp*')){ echo 'show';} ?>" id="movieapp" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*movieapp')){ echo 'active';} ?>" >
                    <a href="{{route('admin.movieapp')}}"> List </a>
                </li>
            </ul>
        </li>
        
        <li class="menu">
            <a href="#youtubeapp" data-toggle="collapse" <?php if(request()->is('*youtubeapp*')){ echo 'aria-expanded="true" data-active="true"';}else{echo 'aria-expanded="false"';} ?> class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Alwd Youtube Channels</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php if(request()->is('*youtubeapp*')){ echo 'show';} ?>" id="youtubeapp" data-parent="#accordionExample">
                <li class="<?php if(request()->is('*youtubeapp')){ echo 'active';} ?>" >
                    <a href="{{route('admin.youtubeapp')}}"> List </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="{{route('admin.superAdminPlans')}}" <?php if(request()->is('*admin-plan*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>
                    <span>Manage Packages</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{route('reseller.resellers')}}" <?php if(request()->is('*reseller*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Manage Reseller</span>
                </div>
            </a>
        </li>
        @endif


        @if(Auth::user()->role == 2)
        <li class="menu">
            <a href="{{route('admin.AdminWallet')}}" <?php if(request()->is('*admin-wallet*') || request()->is('add-reseller-wallet')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path d="M18,7H15.79a5.49,5.49,0,0,0-1-2H18a1,1,0,0,0,0-2H7A1,1,0,0,0,7,5h3.5a3.5,3.5,0,0,1,3.15,2H7A1,1,0,0,0,7,9h7a3.5,3.5,0,0,1-3.45,3H7a.7.7,0,0,0-.14,0,.65.65,0,0,0-.2,0,.69.69,0,0,0-.19.1l-.12.07,0,0a.75.75,0,0,0-.14.17,1.1,1.1,0,0,0-.09.14.61.61,0,0,0,0,.18A.65.65,0,0,0,6,13s0,0,0,0a.7.7,0,0,0,0,.14.65.65,0,0,0,0,.2.69.69,0,0,0,.1.19s0,.08.07.12l6,7a1,1,0,0,0,1.52-1.3L9.18,14H10.5A5.5,5.5,0,0,0,16,9h2a1,1,0,0,0,0-2Z" stroke="currentColor" class="color000 svgShape"></path></svg>
                    <span>Wallet Transactions</span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a href="{{route('admin.adminPlans')}}" <?php if(request()->is('*admin-plan*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>
                    <span>Manage Packages</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{route('reseller.resellers')}}" <?php if(request()->is('*resellers*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Manage Reseller</span>
                </div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 3)
        <li class="menu">
            <a href="{{route('reseller.resellerWallet')}}" <?php if(request()->is('*reseller-wallet*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path d="M18,7H15.79a5.49,5.49,0,0,0-1-2H18a1,1,0,0,0,0-2H7A1,1,0,0,0,7,5h3.5a3.5,3.5,0,0,1,3.15,2H7A1,1,0,0,0,7,9h7a3.5,3.5,0,0,1-3.45,3H7a.7.7,0,0,0-.14,0,.65.65,0,0,0-.2,0,.69.69,0,0,0-.19.1l-.12.07,0,0a.75.75,0,0,0-.14.17,1.1,1.1,0,0,0-.09.14.61.61,0,0,0,0,.18A.65.65,0,0,0,6,13s0,0,0,0a.7.7,0,0,0,0,.14.65.65,0,0,0,0,.2.69.69,0,0,0,.1.19s0,.08.07.12l6,7a1,1,0,0,0,1.52-1.3L9.18,14H10.5A5.5,5.5,0,0,0,16,9h2a1,1,0,0,0,0-2Z" stroke="currentColor" class="color000 svgShape"></path></svg>
                    <span>Wallet Transactions</span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a href="{{route('reseller.resellerPlans')}}" <?php if(request()->is('*reseller-plan*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>
                    <span>Manage Packages</span>
                </div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 6)
        <li class="menu">
            <a href="{{route('netadmin.wallet')}}" <?php if(request()->is('*wallet*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path d="M18,7H15.79a5.49,5.49,0,0,0-1-2H18a1,1,0,0,0,0-2H7A1,1,0,0,0,7,5h3.5a3.5,3.5,0,0,1,3.15,2H7A1,1,0,0,0,7,9h7a3.5,3.5,0,0,1-3.45,3H7a.7.7,0,0,0-.14,0,.65.65,0,0,0-.2,0,.69.69,0,0,0-.19.1l-.12.07,0,0a.75.75,0,0,0-.14.17,1.1,1.1,0,0,0-.09.14.61.61,0,0,0,0,.18A.65.65,0,0,0,6,13s0,0,0,0a.7.7,0,0,0,0,.14.65.65,0,0,0,0,.2.69.69,0,0,0,.1.19s0,.08.07.12l6,7a1,1,0,0,0,1.52-1.3L9.18,14H10.5A5.5,5.5,0,0,0,16,9h2a1,1,0,0,0,0-2Z" stroke="currentColor" class="color000 svgShape"></path></svg>
                    <span>Wallet Transactions</span>
                </div>
            </a>
        </li>
        <li class="menu">
            <a href="{{route('netadmin.channels')}}" <?php if(request()->is('*channels*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Manage Channels</span>
                </div>
            </a>
        </li>
        @endif

        <li class="menu">
            <a href="{{route('user.users')}}" <?php if(request()->is('*user*')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Manage Users</span>
                </div>
            </a>
        </li>
        @if(Auth::user()->role == 1)
       <!--  <li class="menu">
            <a href="{{route('plan-max-price')}}" <?php if(request()->is('plan-max-price')){ echo 'data-active="true"';} ?> aria-expanded="false" class="dropdown-toggle">
                <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path d="M18,7H15.79a5.49,5.49,0,0,0-1-2H18a1,1,0,0,0,0-2H7A1,1,0,0,0,7,5h3.5a3.5,3.5,0,0,1,3.15,2H7A1,1,0,0,0,7,9h7a3.5,3.5,0,0,1-3.45,3H7a.7.7,0,0,0-.14,0,.65.65,0,0,0-.2,0,.69.69,0,0,0-.19.1l-.12.07,0,0a.75.75,0,0,0-.14.17,1.1,1.1,0,0,0-.09.14.61.61,0,0,0,0,.18A.65.65,0,0,0,6,13s0,0,0,0a.7.7,0,0,0,0,.14.65.65,0,0,0,0,.2.69.69,0,0,0,.1.19s0,.08.07.12l6,7a1,1,0,0,0,1.52-1.3L9.18,14H10.5A5.5,5.5,0,0,0,16,9h2a1,1,0,0,0,0-2Z" stroke="currentColor" class="color000 svgShape"></path></svg>
                <span>Plan Max Price</span>
                </div>
            </a>
        </li> -->
        @endif
        <!-- <li class="menu">
            <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    <span>Components</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="components" data-parent="#accordionExample">
                <li>
                    <a href="component_tabs.html"> Tabs </a>
                </li>
                <li>
                    <a href="component_accordion.html"> Accordions  </a>
                </li>
                <li>
                    <a href="component_modal.html"> Modals </a>
                </li>
                <li>
                    <a href="component_cards.html"> Cards </a>
                </li>
                <li>
                    <a href="component_bootstrap_carousel.html">Carousel</a>
                </li>
                <li>
                    <a href="component_blockui.html"> Block UI </a>
                </li>
                <li>
                    <a href="component_countdown.html"> Countdown </a>
                </li>
                <li>
                    <a href="component_counter.html"> Counter </a>
                </li>
                <li>
                    <a href="component_sweetalert.html"> Sweet Alerts </a>
                </li>
                <li>
                    <a href="component_timeline.html"> Timeline </a>
                </li>
                <li>
                    <a href="component_snackbar.html"> Notifications </a>
                </li>
                <li>
                    <a href="component_session_timeout.html"> Session Timeout </a>
                </li>
                <li>
                    <a href="component_media_object.html"> Media Object </a>
                </li>
                <li>
                    <a href="component_list_group.html"> List Group </a>
                </li>
                <li>
                    <a href="component_pricing_table.html"> Pricing Tables </a>
                </li>
                <li>
                    <a href="component_lightbox.html"> Lightbox </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Elements</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="elements" data-parent="#accordionExample">
                <li>
                    <a href="element_alerts.html"> Alerts </a>
                </li>
                <li>
                    <a href="element_avatar.html"> Avatar </a>
                </li>
                <li>
                    <a href="element_badges.html"> Badges </a>
                </li>
                <li>
                    <a href="element_breadcrumbs.html"> Breadcrumbs </a>
                </li>
                <li>
                    <a href="element_buttons.html"> Buttons </a>
                </li>
                <li>
                    <a href="element_buttons_group.html"> Button Groups </a>
                </li>
                <li>
                    <a href="element_color_library.html"> Color Library </a>
                </li>
                <li>
                    <a href="element_dropdown.html"> Dropdown </a>
                </li>
                <li>
                    <a href="element_infobox.html"> Infobox </a>
                </li>
                <li>
                    <a href="element_jumbotron.html"> Jumbotron </a>
                </li>
                <li>
                    <a href="element_loader.html"> Loader </a>
                </li>
                <li>
                    <a href="element_pagination.html"> Pagination </a>
                </li>
                <li>
                    <a href="element_popovers.html"> Popovers </a>
                </li>
                <li>
                    <a href="element_progress_bar.html"> Progress Bar </a>
                </li>
                <li>
                    <a href="element_search.html"> Search </a>
                </li>
                <li>
                    <a href="element_tooltips.html"> Tooltips </a>
                </li>
                <li>
                    <a href="element_treeview.html"> Treeview </a>
                </li>
                <li>
                    <a href="element_typography.html"> Typography </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="fonticons.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    <span>Font Icons</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="widgets.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Widgets</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Tables</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="#datatables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>DataTables</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                <li>
                    <a href="table_dt_basic.html"> Basic </a>
                </li>
                <li>
                    <a href="table_dt_basic-light.html"> Light </a>
                </li>
                <li>
                    <a href="table_dt_ordering_sorting.html"> Order Sorting </a>
                </li>
                <li>
                    <a href="table_dt_multi-column_ordering.html"> Multi-Column </a>
                </li>
                <li>
                    <a href="table_dt_multiple_tables.html"> Multiple Tables</a>
                </li>
                <li>
                    <a href="table_dt_alternative_pagination.html"> Alt. Pagination</a>
                </li>
                <li>
                    <a href="table_dt_custom.html"> Custom </a>
                </li>
                <li>
                    <a href="table_dt_range_search.html"> Range Search </a>
                </li>
                <li>
                    <a href="table_dt_html5.html"> HTML5 Export </a>
                </li>
                <li>
                    <a href="table_dt_live_dom_ordering.html"> Live DOM ordering </a>
                </li>
                <li>
                    <a href="table_dt_miscellaneous.html"> Miscellaneous </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                    <span>Forms</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="forms" data-parent="#accordionExample">
                <li>
                    <a href="form_bootstrap_basic.html"> Basic </a>
                </li>
                <li>
                    <a href="form_input_group_basic.html"> Input Group </a>
                </li>
                <li>
                    <a href="form_layouts.html"> Layouts </a>
                </li>
                <li>
                    <a href="form_validation.html"> Validation </a>
                </li>
                <li>
                    <a href="form_input_mask.html"> Input Mask </a>
                </li>
                <li>
                    <a href="form_bootstrap_select.html"> Bootstrap Select </a>
                </li>
                <li>
                    <a href="form_select2.html"> Select2 </a>
                </li>
                <li>
                    <a href="form_bootstrap_touchspin.html"> TouchSpin </a>
                </li>
                <li>
                    <a href="form_maxlength.html"> Maxlength </a>
                </li>
                <li>
                    <a href="form_checkbox_radio.html"> Checkbox &amp; Radio </a>
                </li>
                <li>
                    <a href="form_switches.html"> Switches </a>
                </li>
                <li>
                    <a href="form_wizard.html"> Wizards </a>
                </li>
                <li>
                    <a href="form_fileupload.html"> File Upload </a>
                </li>
                <li>
                    <a href="form_quill.html"> Quill Editor </a>
                </li>
                <li>
                    <a href="form_markdown.html"> Markdown Editor </a>
                </li>
                <li>
                    <a href="form_date_range_picker.html"> Date &amp; Range Picker </a>
                </li>
                <li>
                    <a href="form_clipboard.html"> Clipboard </a>
                </li>
                <li>
                    <a href="form_typeahead.html"> Typeahead </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Users</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="users" data-parent="#accordionExample">
                <li>
                    <a href="user_profile.html"> Profile </a>
                </li>
                <li>
                    <a href="user_account_setting.html"> Account Settings </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                    <span>Pages</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="pages" data-parent="#accordionExample">
                <li>
                    <a href="pages_helpdesk.html"> Helpdesk </a>
                </li>
                <li>
                    <a href="pages_contact_us.html"> Contact Form </a>
                </li>
                <li>
                    <a href="pages_faq.html"> FAQ </a>
                </li>
                <li>
                    <a href="pages_faq2.html"> FAQ 2 </a>
                </li>
                <li>
                    <a href="pages_privacy.html"> Privacy Policy </a>
                </li>
                <li>
                    <a href="pages_coming_soon.html"> Coming Soon </a>
                </li>
                <li>
                    <a href="#pages-error" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Error <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                    <ul class="collapse list-unstyled sub-submenu" id="pages-error" data-parent="#pages">
                        <li>
                            <a href="pages_error404.html"> 404 </a>
                        </li>
                        <li>
                            <a href="pages_error500.html"> 500 </a>
                        </li>
                        <li>
                            <a href="pages_error503.html"> 503 </a>
                        </li>
                        <li>
                            <a href="pages_maintenence.html"> Maintanence </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="#authentication" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span>Authentication</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="authentication" data-parent="#accordionExample">
                <li>
                    <a href="auth_login_boxed.html"> Login Boxed </a>
                </li>
                <li>
                    <a href="auth_register_boxed.html"> Register Boxed </a>
                </li>
                <li>
                    <a href="auth_lockscreen_boxed.html"> Unlock Boxed </a>
                </li>
                <li>
                    <a href="auth_pass_recovery_boxed.html"> Recover ID Boxed </a>
                </li>
                <li>
                    <a href="auth_login.html"> Login Cover </a>
                </li>
                <li>
                    <a href="auth_register.html"> Register Cover </a>
                </li>
                <li>
                    <a href="auth_lockscreen.html"> Unlock Cover </a>
                </li>
                <li>
                    <a href="auth_pass_recovery.html"> Recover ID Cover </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="dragndrop_dragula.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg>
                    <span>Drag and Drop</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="map_jvector.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                    <span>Maps</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="charts_apex.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                    <span>Charts</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="#starter-kit" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                    <span>Starter Kit</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled" id="starter-kit" data-parent="#accordionExample">
                <li>
                    <a href="starter_kit_blank_page.html"> Blank Page </a>
                </li>
                <li>
                    <a href="starter_kit_breadcrumbs.html"> Breadcrumbs </a>
                </li>
                <li>
                    <a href="starter_kit_boxed.html"> Boxed </a>
                </li>
                <li>
                    <a href="starter_kit_alt_menu.html"> Alternate Menu </a>
                </li>
            </ul>
        </li>

        <li class="menu">
            <a href="../../documentation/index.html" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <span>Documentation</span>
                </div>
            </a>
        </li> -->

    </ul>
    <!-- <div class="shadow-bottom"></div> -->

</nav>

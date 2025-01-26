<div class="header">
    <button type="button" class="hambi" data-toggle="menu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="brand" href="{{route('throne.dashboard')}}">{{env('ADMIN_NAME')}} <small>Admin by Hinora</small></a>
    @if(false)
        <div class="lang">
            <div class="helpItem" data-help="adminLang">
                <a href="{{route('throne.selectlanguage',['lang'=>'hu'])}}" class="default-link choose-language {{app()->getLocale()=='hu' ? 'active' : ''}}">HU</a>
                <a href="{{route('throne.selectlanguage',['lang'=>'en'])}}" class="default-link choose-language {{app()->getLocale()=='en' ? 'active' : ''}}">EN</a>
            </div>
        </div>
    @endif

    <ul class="nav navbar-top">
        <li>{{auth()->guard('admin')->user()->name}}</li>
        <li class="dropdown custom-dropdown helpItem" data-help="welcome|userSetting" data-position="right">
            <span class="dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>  <i class="fas fa-caret-down"></i>
            </span>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{ route('throne.profil') }}" data-remove-menu="true"><i class="fas fa-user-circle fa-fw"></i> @lang('admin.profile.title')</a></li>
                <li><a href="{{ route('throne.logout') }}" data-remove-menu="true" class="default-link"><i class="fas fa-sign-out-alt fa-fw"></i> @lang('admin.logout')</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="menu">
    <ul>
        <li class="{{ activeMenu('dashboard') ? 'active' : '' }}">
            <a href="{{ route('throne.dashboard') }}"><i class="fas fa-tachometer-alt fa-fw"></i> @lang('admin.dashboard.title')</a>
        </li>
        @if(can('languages.read'))
            <li class="{{ activeMenu(['languages','language_text']) ? 'active' : '' }}">
                <a href="{{ route('throne.languages') }}"><i class="fas fa-language fa-fw"></i> @lang('admin.languages.title')</a>
            </li>
        @endif
        @include('throne.partials._menu', ['icon' => 'far fa-image', 'items' => ['slider']])
        @include('throne.partials._menu', ['icon' => 'far fa-file-alt', 'items' => ['pages']])
        @include('throne.partials._menu', ['icon' => 'fas fa-file-alt', 'items' => ['fixedcontent']])
        @if(can('menu.read'))
            <li class="dropdown {{ activeMenu('menu') ? 'active' : '' }}">
                <span class="dropdown-li"><i class="fas fa-list fa-fw"></i> @lang('admin.menu.title')<span class="fas arrow"></span></span>
                <ul class="dropdownBox clearfix">
                    <li><a href="{{ route('throne.menu', 'main') }}">@lang('admin.menu.main')</a></li>
                    @if(env('MULTI_TEMPLATE'))
                        <li><a href="{{ route('throne.menu', 'side') }}">@lang('admin.menu.side')</a></li>
                    @endif
                    <li><a href="{{ route('throne.menu', 'footer') }}">@lang('admin.menu.footer')</a></li>
                </ul>
            </li>
        @endif
        @include('throne.partials._menu', ['icon' => 'fas fa-newspaper', 'items' => ['feed_items', 'feed_categories', 'feed_labels']])
        @include('throne.partials._menu', ['icon' => 'fas fa-user-secret', 'items' => ['partner_items','partner_categories']])
        @include('throne.partials._menu', ['icon' => 'fas fa-calendar-alt', 'items' => ['events','event_categories']])
        @include('throne.partials._menu', ['icon' => 'far fa-address-card', 'items' => ['popup']])

        @if(can('documentcategory.read') || can('gallery.read') || can('videogallery.read'))
            <li class="dropdown {{ activeMenu(['documentcategory','documentitem','gallery','galleryimages','videogallery','videoitem']) ? 'active' : '' }}">
                <span class="dropdown-li"><i class="far fa-hdd fa-fw"></i> @lang('admin.mediatar.title')<span class="fas arrow"></span></span>
                <ul class="dropdownBox clearfix">
                    @if(can('documentcategory.read'))
                        <li><a href="{{ route('throne.documentcategory') }}">@lang('admin.documents.manager')</a></li>
                    @endif
                    @if(can('gallery.read'))
                        <li><a href="{{ route('throne.gallery') }}">@lang('admin.gallery.title')</a></li>
                    @endif
                    @if(can('videogallery.read'))
                        <li><a href="{{ route('throne.videogallery') }}">@lang('admin.videoitem.title')</a></li>
                    @endif
                </ul>
            </li>
        @endif
        @include('throne.partials._menu', ['icon' => 'fas fa-th', 'items' => ['widget']])
        @if(can('forms.read'))
            <li class="{{ activeMenu(['forms','form_content','form_users'])  ? 'active' : '' }}">
                <a href="{{ route('throne.forms') }}"><i class="far fa-comments fa-fw"></i> @lang('admin.forms.title')</a>
            </li>
        @endif
        @include('throne.partials._menu', ['icon' => 'fas fa-user', 'items' => ['users']])
        @if(can('settings.edit') || can('search.read') || can('emails.read') || can('redirects.read') || can('logs.read'))
            <li class="dropdown {{ activeMenu(['settings','search','emails','redirects','logs']) ? 'active' : '' }}">
                <span class="dropdown-li"><i class="fas fa-cogs fa-fw"></i> @lang('admin.system.title')<span class="fas arrow"></span></span>
                <ul class="dropdownBox clearfix">
                    @if(can('settings.edit'))
                        <li><a href="{{ route('throne.settings.edit') }}">@lang('admin.settings.title')</a></li>
                    @endif
                    @if(can('search.read'))
                        <li><a href="{{ route('throne.search') }}">@lang('admin.search.title')</a></li>
                    @endif
                    @if(can('emails.read'))
                        <li><a href="{{ route('throne.emails') }}">@lang('admin.emails.title')</a></li>
                    @endif
                    @if(can('redirects.read'))
                        <li><a href="{{ route('throne.redirects') }}">@lang('admin.redirects.title')</a></li>
                    @endif
                    @if(can('logs.read'))
                        <li><a href="{{ route('throne.logs') }}">@lang('admin.logs.title')</a></li>
                    @endif
                </ul>
            </li>
        @endif
        @include('throne.partials._menu', ['icon' => 'fas fa-users', 'items' => ['admins','permissions']])
    </ul>
</div>

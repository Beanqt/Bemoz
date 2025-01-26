<header>
    <div class="container">
        <div class="row inline-row">
            <div class="col-md-2 inline-col">
                <a href="{{route('index')}}" title="XY" class="logo"></a>
            </div>
            <div class="col-md-10 col-xs-12 inline-col text-right main-top-bar">
                <div class="menu">
                    <div class="relative">
                        <nav>
                            <span class="menu-close">X</span>
                            {!! app("MenuService")->main() !!}
                        </nav>
                    </div>
                </div>
                <div class="top-bar inline-col">
                    <form class="ajax-search" method="post" action="{{route('search')}}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <span class="search-btn" data-toggle="tooltip" data-placement="bottom" title="@lang('public.search.submit')"><i class="fas fa-search"></i></span>
                        <div class="inside">
                            <div class="searchBox">
                                <span class="search-close"><i class="fas fa-times"></i></span>
                                <div class="input-group">
                                    <input type="text" class="form-control searchInput" name="search" id="main_search" placeholder="@lang('public.search.placeholder')" data-error="@lang('public.ajax.error')">
                                    <span class="input-group-addon"><button type="submit"><i class="fas fa-search"></i></button></span>
                                </div>
                            </div>
                            <div class="resultSearch">
                                <div class="loader">
                                    <div class="loading"></div>
                                </div>
                                <ul class="hidden">
                                </ul>
                            </div>
                        </div>
                    </form>
                    <div class="user-box inline-col">
                        <a href="{{route('login')}}" class="fas fa-user"></a>
                    </div>
                    <div class="social inline-col">
                        @if($socials = setting('social'))
                            @foreach($socials as $key => $social)
                                @if(!empty($social))
                                    <a href="{{$social}}" target="_blank" tabindex="8">
                                        <span class="icon icon-{{$key}}"></span>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    @if(count(app('LanguageService')->getLanguages()) > 1)
                        <div class="lang-box inline-col dropdown custom-dropdown">
                            <button type="button" data-toggle="dropdown">
                                @foreach(app('LanguageService')->getLanguages() as $item)
                                    @if(App::getLocale() == $item['locale'])
                                        <span class="lang-title hidden-xs">{{$item['name']}}</span>
                                        @break
                                    @endif
                                @endforeach
                                <span class="lang-arrow icon icon-arrow-down hidden-xs"></span>
                                <span class="fas fa-globe visible-xs"></span>
                            </button>
                            <div class="dropdown-menu lang-menu">
                                <ul class="lang">
                                    @foreach(app('LanguageService')->getLanguages() as $item)
                                        @if(App::getLocale() != $item['locale'])
                                            <li><a href="/{{$item['locale'] == env('DEFAULT_LANG') ? '' : $item['locale']}}">{{$item['name']}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="clearfix hambibox">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


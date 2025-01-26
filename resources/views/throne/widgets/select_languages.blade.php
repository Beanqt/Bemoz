@if($all && $languages = \App\Models\Languages::get())
    <div class="dropdown selectLanguage">
        <button type="button" data-toggle="dropdown">
            <i class="fas fa-globe"></i> {{session('moduleLang')}}
            {!! count($languages) > 1 ? '<span class="caret"></span>' : '' !!}
        </button>
        @if(count($languages) > 1)
            <ul class="dropdown-menu">
                @foreach($languages as $lang)
                    @if($lang['locale'] != session('moduleLang'))
                        <li><a href="?moduleLang={{$lang['locale']}}" class="no-follow">{{$lang['locale']}}</a></li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
@else
    <div class="currentLanguage">
        <i class="fas fa-globe"></i> {{session('moduleLang')}}
    </div>
@endif
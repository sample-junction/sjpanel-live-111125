<div class="forum-item header">
    <div class="row">
        <div class="col-md-9">
            {{__('inpanel.profile.index.general_profile.details')}}
        </div>
        <div class="col-md-1 forum-info">
            {{__('inpanel.profile.index.general_profile.status')}}
        </div>
        <div class="col-md-1 forum-info">
            {{__('inpanel.profile.index.general_profile.expected_time')}}
        </div>
        <div class="col-md-1 forum-info">
            {{__('inpanel.profile.index.general_profile.expected_points')}}
        </div>
    </div>
</div>
@if( !empty($profile_sections) )
    @foreach($profile_sections as $sections)
        @php
            $translated = $sections->doTranslate();
            $isFilled = ( !empty($filledProfilesIds) && $filledProfilesIds->contains($sections->id))?true:false;
        @endphp
        <div class="forum-item @if(!$isFilled) active @endif">
            <div class="row">
                <div class="col-md-9">
                    <div class="forum-icon">
                        <i class="@if($isFilled) far fa-check-square @else far fa-square @endif" style="font-size:40px;"></i>
                    </div>
                    <a href="@if( Route::has('inpanel.profiler.update.show') ){{route('inpanel.profiler.update.show', $sections->_id)}}@endif" class="forum-item-title">{{ $translated['text'] }}</a>
                    <div class="forum-sub-title">{{ $translated['description'] }}</div>
                </div>
                <div class="col-md-1 forum-info">
                    @if($isFilled)
                        <span class="label label-success pull-right profile_status_label">{{__('inpanel.profile.index.label.complete')}}</span>
                    @else
                        <span class="label label-danger pull-right profile_status_label">{{__('inpanel.profile.index.label.pending')}}</span>
                    @endif
                </div>
                <div class="col-md-1 forum-info">
                    @unless($isFilled)
                        <span class="views-number">
                            {{$sections->completion_time}}
                        </span>
                        <div>
                            <small>{{__('inpanel.profile.index.minute')}}</small>
                        </div>
                    @endunless
                </div>
                <div class="col-md-1 forum-info">
                    @unless($isFilled)
                        <span class="views-number">
                            {{$sections->points}}
                        </span>
                        <div>
                            <small>{{__('inpanel.profile.index.points')}}</small>
                        </div>
                    @endunless
                </div>
            </div>
        </div>

    @endforeach
    {{ $profile_sections->links() }}
@endif

@push('after-styles')
    <style>
        .forum-item:hover {
            background-color: whitesmoke;
        }
        .profile_status_label{
            font-size: 14px;
        }
        .forum-title.header{
            margin: 0px 0 15px 0;
        }
        .forum-item.header {
            padding: 1px 0 0px;
        }
        .forum-item{
            margin: 0px 0;
        }
    </style>
@endpush

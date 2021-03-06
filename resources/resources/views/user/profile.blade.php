@extends('user.layout')

@section('profile-title') {{ $user->name }}'s Profile @endsection

@section('meta-img') {{ asset('/images/avatars/'.$user->avatar) }} @endsection

@section('profile-content')
{!! breadcrumbs(['Users' => 'users', $user->name => $user->url]) !!}

@if($user->is_banned)
    <div class="alert alert-danger">This user has been banned.</div>
@endif
<h1>
<img src="/images/avatars/{{ $user->avatar }}" style="width:125px; height:125px; float:left; border-radius:50%; margin-right:25px;">
    {!! $user->displayName !!}

    <small><small><a href="{{ url('reports/new?url=') . $user->url }}"><i class="fas fa-exclamation-triangle fa-xs" data-toggle="tooltip" title="Click here to report this user." style="opacity: 50%;"></i></a></small></small>

 <h1>

   <!-- If you install the user icon extension: the icon goes here:

  <img src="/images/avatars/{{ $user->avatar }}" style="width:125px; height:125px; float:left; border-radius:50%; margin-right:25px;">

  -->


 @if($user->settings->is_fto)
         <span class="badge badge-success float-right" data-toggle="tooltip" title="This user has not owned any characters from this world before.">FTO</span>
 @endif

 <div class="row">
   <div style="padding-right: 10px;">{!! $user->displayName !!}</div>

   <div class="ulinks" style="padding-top:7px">

   @if($user->profile->disc)
     <span class="float-left" style="font-size: 1.1rem; padding-left: 10px; opacity: 0.4;" data-toggle="tooltip" title=" {!! $user->profile->disc !!} "><i class="fab fa-discord"></i></span>
   @endif
   @if($user->profile->house)
     <span class="float-left" style="font-size: 1.1rem; padding-left: 10px; opacity: 0.4;" data-toggle="tooltip" title=" {!! $user->profile->house !!}&#64;toyhou.se "><a href="https://toyhou.se/{!! $user->profile->house !!}"><i class="fas fa-home"></i></a></span>
   @endif
   @if($user->profile->arch)
     <span class="float-left" style="font-size: 1.1rem; padding-left: 10px; opacity: 0.4;" data-toggle="tooltip" title=" {!! $user->profile->arch !!}&#64;twitter"><a href="https://archiveofourown.org/users/{!! $user->profile->arch !!}"><i class="fas fa-file-alt"></i></a></span>
   @endif
   @if($user->profile->insta)
     <span class="float-left" style="font-size: 1.1rem; padding-left: 10px; opacity: 0.4;" data-toggle="tooltip" title=" {!! $user->profile->insta !!}&#64;instagram "><a href="https://www.instagram.com/{!! $user->profile->insta !!}"><i class="fab fa-instagram"></i></a></span>
   @endif

 </div>
 </div>

 </h1>
    
    <small><small><a href="{{ url('reports/new?url=') . $user->url }}"><i class="fas fa-exclamation-triangle fa-xs" data-toggle="tooltip" title="Click here to report this user." style="opacity: 50%;"></i></a></small></small>
    <span class="badge badge-info float-right text-white mx-1" data-toggle="tooltip" title="Current user level. Checkout the level area for more info.">Lvl: {{ $user->level->current_level }}</span>
    @if($user->settings->is_fto)
        <span class="badge badge-success float-right" data-toggle="tooltip" title="This user has not owned any characters from this world before.">FTO</span>
    @endif
</h1>
<div class="mb-1">
    <div class="row">
        <div class="col-md-2 col-4"><h5>Alias</h5></div>
        <div class="col-md-10 col-8">{!! $user->displayAlias !!}</div>
    </div>
    <div class="row">
        <div class="col-md-2 col-4"><h5>Rank</h5></div>
        <div class="col-md-10 col-8">{!! $user->rank->displayName !!} {!! add_help($user->rank->parsed_description) !!}</div>
    </div>
    <div class="row">
        <div class="col-md-2 col-4"><h5>Joined</h5></div>
        <div class="col-md-10 col-8">{!! format_date($user->created_at, false) !!} ({{ $user->created_at->diffForHumans() }})</div>
    </div>

    @if($user_enabled && isset($user->home_id))
    <div class="row">
        <div class="col-md-2 col-4"><h5>Home</h5></div>
        <div class="col-md-10 col-8">{!! $user->home ? $user->home->fullDisplayName : '-Deleted Location-' !!}</div>
    </div>
    @endif
    @if($user_enabled && isset($user->faction_id))
    <div class="row">
        <div class="col-md-2 col-4"><h5>Faction</h5></div>
        <div class="col-md-10 col-8">{!! $user->faction ? $user->faction->fullDisplayName : '-Deleted Faction-' !!}</div>
    </div>
    @endif
</div>

<div class="card mb-3">
    <div class="card-body">
        {!! $user->profile->parsed_text !!}
    </div>
</div>

<div class="card-deck mb-4 profile-assets">
    <div class="card profile-currencies profile-assets-card">
        <div class="card-body text-center">
            <h5 class="card-title">Bank</h5>
            <div class="profile-assets-content">
                @foreach($user->getCurrencies(false) as $currency)
                    <div>{!! $currency->display($currency->quantity) !!}</div>
                @endforeach
            </div>
            <div class="text-right"><a href="{{ $user->url.'/bank' }}">View all...</a></div>
        </div>
    </div>
    <div class="card profile-inventory profile-assets-card">
        <div class="card-body text-center">
            <h5 class="card-title">Inventory</h5>
            <div class="profile-assets-content">
                @if(count($items))
                    <div class="row">
                        @foreach($items as $item)
                            <div class="col-md-3 col-6 profile-inventory-item">
                                @if($item->imageUrl)
                                    <img src="{{ $item->imageUrl }}" data-toggle="tooltip" title="{{ $item->name }}" />
                                @else
                                    <p>{{ $item->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>No items owned.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url.'/inventory' }}">View all...</a></div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body text-center">
        <h5 class="card-title">Pets</h5>
        <div class="card-body">
            @if(count($pets))
                <div class="row">
                    @foreach($pets as $pet)
                        <div class="col profile-inventory-item">
                            <img src="{{ $pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->name }}" />
                        </div>
                    @endforeach
                </div>
            @else 
                <div>No pets owned.</div>
            @endif
        </div>
        <div class="text-right"><a href="{{ $user->url.'/pets' }}">View all...</a></div>
    </div>
</div>

<h2>
    <a href="{{ $user->url.'/characters' }}">Characters</a>
    @if(isset($sublists) && $sublists->count() > 0)
        @foreach($sublists as $sublist)
        / <a href="{{ $user->url.'/sublist/'.$sublist->key }}">{{ $sublist->name }}</a>
        @endforeach
    @endif
</h2>

@foreach($characters->take(4)->get()->chunk(4) as $chunk)
    <div class="row mb-4">
        @foreach($chunk as $character)
            <div class="col-md-3 col-6 text-center">
                <div>
                    <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="text-right"><a href="{{ $user->url.'/characters' }}">View all...</a></div>
<hr>
<br><br>

@comments(['model' => $user->profile,
        'perPage' => 5
    ])
@endsection

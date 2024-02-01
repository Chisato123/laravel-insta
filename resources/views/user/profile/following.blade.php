@extends('layouts.app')

@section('title',$user->name.' Following')

@section('content')
@include('user.profile.header')

@if($user->follows->count()>0)
{{-- follows is from User model --}}
<div class="row justify-content-center">
    <div class="col-4">
        <h4 class="h4 text-muted text-center mb-3">Following</h4>
        @foreach ($user->follows as $follow)
        <div class="row mb-2 align-items-center">
            <div class="col-auto">
                <a href="{{route('profile.show', $follow->followed->id)}}">
                    @if($follow->followed->avatar)
                    <img src="{{ $follow->followed->avatar }}" alt="" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0 text-truncate">
                <a href="{{route('profile.show', $follow->followed->id)}}" class="text-decoration-none fw-bold text-dark">
                    {{$follow->followed->name}}
                    {{-- Model:followのfunctionがUserに繋がっているため、user->followed->nameでnameのデータが取れる。 --}}
                </a>
            </div>
            <div class="col-auto">
                @if($follow->followed->id !== Auth::user()->id)
                    @if ($follow->followed->isFollowed())
                    {{-- unfollow --}}
                    <form action="{{route('follow.destroy', $follow->followed->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn p-0 shaadow-none text-muted">Following</button>
                    </form>
                    @else
                    {{-- follow --}}
                    <form action="{{route('follow.store', $follow->followed->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn p-0 shadow-none text-primary">Follow</button>
                    </form>
                    @endif
                @endif

            </div>
        </div>

        @endforeach
    </div>
</div>

@else
<p class="h4 text-muted text-center">No following anyone yet</p>

@endif

@endsection

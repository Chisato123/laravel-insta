@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="row gx-5">
    <div class="col-8">
        @if($search)
        <p class="h5 text-muted mb-4">Search results for posts with "<strong>{{$search}}</strong>"</p>
        @endif
        {{-- posts --}}
        @forelse ($all_posts as $post)
        {{-- HomeControllerにあるindex functionを呼び出す --}}
        <div class="card mb-4">
            {{-- title → contentsフォルダ作成の上、title.blade作成--}}
        @include('user.posts.contents.title')

        {{-- body --}}
        {{-- 1,写真 --}}
            <div class="container p-0">
                <a href="{{route('post.show', $post->id)}}">
            <img src="{{ $post->image }}" alt="" class="w-100">
                </a>
            </div>
            {{-- ２、♡の行 --}}
            <div class="card-body">

        @include('user.posts.contents.body')

        {{-- comments --}}
        @if ($post->comments->count()>0)
            <hr>
        @endif

        @foreach ($post->comments->take(3) as $comment)
        {{-- take(3) = get 3 items(comments) --}}

            @include('user.posts.contents.comments.list-item')
        @endforeach

        @if ($post->comments->count()>3)
        <a href="{{route('post.show', $post->id)}}" class="text-decoration-none small mb-3">View all {{$post->comments->count()}} comments</a>
        @endif

        @include('user.posts.contents.comments.create')

            </div>
        </div>

        @empty
        {{-- no posts --}}
        <div class="text-center">
            <h2>Share Photos</h2>
            <p class="text-muted">When you share photos, they will appear on your profile.</p>
            <a href="{{route('post.create')}}" class="twxt-decoration-none ">Share your first phpto</a>
        </div>

        @endforelse

    </div>
    <div class="col-4">
        {{-- user info --}}
        <div class="row mb-5 py-3 align-items-center bg-white shadow-sm rounded-3">
            <div class="col-auto">
                <a href="{{route('profile.show', Auth::user()->id)}}">
                @if(Auth::user()->avatar)
                <img src="{{Auth::user()->avatar}}" alt="" class="rounded-circle avatar-md">
                @else
                <i class="fa-solid fa-circle-user icon-md text-secondary"></i>
                @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{route('profile.show', Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold">{{Auth::user()->name}}</a>
                <p class="text-muted">{{Auth::user()->email}}</p>
            </div>
        </div>

        {{-- suggested users --}}
        @if (count($suggested_users)>0)
        <div class="row mb-3">
            <div class="col">
                <span class="text-secondary fw-bold">
                    Suggestions For You
                </span>
            </div>
            <div class="col-auto">
                <a href="" class="text-decoration-none fw-bold text-dark">See All</a>
            </div>
        </div>
            @foreach($suggested_users as $user)
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <a href="{{route('profile.show', $user->id)}}">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    @endif
                    </a>
                </div>
                <div class="col text-truncate ps-0">
                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                    {{ $user->name }}
                    </a>
                </div>
                <div class="col-auto">
                    <form action="{{route('follow.store', $user->id)}}" method="post">
                    @csrf
                    <button type="submit" class="btn p-0 text-primary shadow-none">Follow</button>
                    </form>

                </div>
            </div>

            @endforeach
        @endif
    </div>
</div>


@endsection

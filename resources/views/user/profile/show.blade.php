@extends('layouts.app')

@section('title',$user->name)

@section('content')
{{-- header --}}
@include('user.profile.header')
{{-- list of posts --}}
<div class="mt-5">
    <div class="row">
        @forelse ($user->posts as $post)
        <div class="col-lg-4 col-md-6 mb-4">
            <a href="{{route('post.show',$post->id)}}">
                <img src="{{ $post->image }}" alt="" class="grid-img">
            </a>

        </div>


        @empty
        <h3 class="text-muted text-center">No posts yet.</h3>
        @endforelse
    </div>
</div>
@endSection

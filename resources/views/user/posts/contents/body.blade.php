<div class="row align-items-center">
    {{-- heart button --}}
    <div class="col-auto">
        @if($post->isLikedBy())
        {{-- red heart --}}
        <form action="{{route('like.destroy', $post->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="border-0 shadow-none bg-transparent p-0">
                <i class="fa-solid fa-heart text-danger"></i>
            </button>
        </form>
        @else
        <form action="{{route('like.store', $post->id)}}" method="post">
        @csrf
        <button type="submit" class="border-0 shadow-none bg-transparent p-0">
            <i class="fa-regular fa-heart"></i>
        </button>
        </form>
    @endif
    </div>

    {{-- no. of likes --}}
    <div class="col-auto px-0">
        <button class="btn text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#likesmodal{{$post->id}}">{{ $post->likes->count() }}</button>
        @include('user.posts.contents.modals.likes')
    </div>

    {{-- categories --}}
    <div class="col text-end">
        @forelse ($post->categoryPosts as $category_post)
        {{-- categoryPosts is from Model Post , has categ_id and post_id--}}
        <div class="badge bg-secondary bg-opacity-50">
            {{ $category_post->category->name }}
        {{-- CategoryPost model relationshionship and has function category--}}
        </div>

        @empty
        <div class="badge bg-dark">Uncategorized</div>

        @endforelse
    </div>
</div>

{{-- ------------------------------------ --}}
{{-- post owner and description --}}

<a href ="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
&nbsp;
    {{-- &nbsp; = space --}}
<span class="fw-light">{{ $post->description }}</span>
<p class="text-uppercase text-muted xsmall">{{date('M d,Y',strtotime($post->created_at))}}</p>

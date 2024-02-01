<div class="card-header bg-white py-3">
{{-- ヘッダーを、一行３つに分けて表示 --}}
<div class="row align-items-center">
    {{-- 1.icon/avatar --}}
    <div class="col-auto">
        <a href="{{route('profile.show', $post->user->id)}}">
            @if($post->user->avatar)
            <img src="{{ $post->user->avatar }}" alt="" class="rounded-circle avatar-sm">
            @else
            <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
            @endif
        </a>

    </div>
    {{-- 2.username --}}
    <div class="col ps-0">
        <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">
            {{ $post->user->name }}
            {{-- post brlong to user and get name from user --}}
            {{-- index.bladeの@forelse ($all_posts as $post)の$postから来た --}}
        </a>

    </div>
    {{-- 3.buttons --}}
    <div class="col-auto">
        <div class="dropdown">
            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                <i class="fa-solid fa-ellipsis"></i>
            </button>

            @if ($post->user_id == Auth::user()->id)
            {{-- edit/delete --}}
            <div class="dropdown-menu">
                <a href="{{route('post.edit', $post->id)}}" class="dropdown-item">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                </a>
                <button class="text-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                    {{-- data-bs-targetでdeleteページのidに繋がる。 --}}
                    <i class="fa-regular fa-trash-can"></i> Delete
                </button>
            </div>

            @include('user.posts.contents.modals.delete')
            {{-- hidden modal --}}

            @else
            {{-- unfollow button = 自分以外のユーザーがログインしてる時 --}}
            @if ($post->user->isFollowed())

            <div class="dropdown-menu">
                <form action="{{route('follow.destroy', $post->user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">
                        Unfollow
                    </button>
                </form>
            </div>
            @else
            {{-- following --}}
            <div class="dropdown-menu">
                <form action="{{route('follow.store', $post->user->id)}}" method="post">
                @csrf
                <button type="submit" class="dropdown-item text-primary">Follow</button>
                </form>
            </div>

            @endif
            @endif
        </div>

    </div>
</div>
</div>

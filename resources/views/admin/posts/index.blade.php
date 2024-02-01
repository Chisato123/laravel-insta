@extends('layouts.app')

@section('title','Admin: Posts')

@section('content')
<ul class="navbar-nav ms-auto my-3 col-2">
    @auth
        @if(request()->is('admin/*'))
                <form action="{{route('admin.posts')}}" method="get">
                    <input type="text" name="search" placeholder="Search posts..." class="form-control form-control-sm" value="{{ $search }}">
                </form>
        @endif
    @endauth
</ul>

<table class="table table-hover bg-white align-middle text-secondary border">
    <thead class="text-secondary table-primary text-uppercase small">
        <tr>
        <th></th>
        <th></th>
        <th>Category</th>
        <th>Owner</th>
        <th>Created At</th>
        <th>Status</th>
        <th></th>
       </tr>
    </thead>
    <tbody>
        @forelse($all_posts as $post)
        <tr>
            <td class="text-center">
               {{ $post->id }}
            </td>
            <td>
                <a href="{{route('post.show', $post->id)}}"><img src="{{ $post->image }}" alt="" class="img-lg mx-auto d-block"></a>
            </td>
            <td>
             @forelse ($post->categoryPosts as $category_post)
            <div class="badge bg-secondary bg-opacity-50">
             {{ $category_post->category->name }}
            </div>

             @empty
             Uncategorized
             @endforelse

            </td>
            <td>
                <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">
                {{ $post->user->name }}
                </a>
            </td>
            <td>
                {{ $post->created_at }}
            </td>
            <td>
                @if($post->trashed())
                <i class="fa-solid fa-circle-minus text-secondary"></i> Hidden
                @else
                <i class="fa-solid fa-circle text-primary"></i> Visible
                @endif

            </td>
            <td>
                @if(!$post->trashed())
                <div class="dropdown">
                    <button class="btn shadow-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>

                    <div class="dropdown-menu">
                        <button class="dropdown-item btn shadow-none text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-post{{$post->id}}">
                            <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                        </button>
                    </div>
                </div>
                @else
                <div class="dropdown">
                    <button class="btn shadow-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>

                    <div class="dropdown-menu">
                        <button class="dropdown-item btn shadow-none text-dark" data-bs-toggle="modal" data-bs-target="#activate-post{{$post->id}}">
                            <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                        </button>
                    </div>
                </div>

                @endif
                @include('admin.posts.status')

            </td>
            {{-- <td>
                @if ($user->trashed())
                <i class="fa-regular fa-circle"></i> Inactiva
                @else
                <i class="fa-solid fa-circle text-success"></i> Active
                @endif
            </td> --}}
            {{-- <td>
                @if($user->id != Auth::user()->id)
                <div class="dropdown">
                    <button class="btn shadow-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>

                    <div class="dropdown-menu">
                        @if(!$user->trashed())
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user{{$user->id}}">
                            <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                        </button>
                        @else
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user{{$user->id}}">
                            <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                        </button>
                        @endif
                    </div>
                </div>
                @include('admin.users.status')
                @endif
            </td> --}}
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No posts found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $all_posts->links() }}
{{-- ↑array name  / paginateのために追加 --}}

@endsection

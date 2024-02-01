@extends('layouts.app')

@section('title','Admin: Users')

@section('content')
<ul class="navbar-nav ms-auto my-3 col-2">
    @auth
        @if(request()->is('admin/*'))
                <form action="{{route('admin.users')}}" method="get">
                    <input type="text" name="search" placeholder="Search names..." class="form-control form-control-sm" value="{{ $search }}">
                </form>

        @endif
    @endauth
</ul>

<table class="table table-hover bg-white align-middle text-secondary border">
    <thead class="text-secondary table-success text-uppercase small">
        <tr>
        <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Status</th>
        <th></th>
       </tr>
    </thead>
    <tbody>
        @forelse($all_users as $user)
        <tr>
            <td>
                @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md mx-auto d-block">
                @else
                <i class="fa-solid fa-circle-user text-secondary icon-md d-block text-center"></i>
                @endif
            </td>
            <td>
                <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                {{ $user->name }}
                </a>
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->created_at }}
            </td>
            <td>
                @if ($user->trashed())
                {{-- trashed() - true if user is soft -delete --}}
                <i class="fa-regular fa-circle"></i> Inactiva
                @else
                <i class="fa-solid fa-circle text-success"></i> Active
                @endif
            </td>
            <td>
                {{-- deactivate or activate --}}
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
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $all_users->links() }}
{{-- ↑array name  / paginateのために追加 --}}

@endsection

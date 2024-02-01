@extends('layouts.app')

@section('title','Admin: Posts')

@section('content')
<form action="{{route('admin.categories.store')}}" method="post" class="row mb-4 gx-2">
    @csrf
      <div class="col-4">
        <input type="text" name="name" class="form-control" placeholder="Add a category" value="{{old('name')}}">
        @error('name')
        <div class="text-danger small">{{$message}}</div>
        @enderror
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add
        </button>
      </div>
  </form>
<table class="table table-sm table-hover bg-white align-middle text-secondary border text-center">
  <thead class="text-secondary table-danger text-uppercase small">
        <tr>
        <th>#</th>
        <th>name</th>
        <th>count</th>
        <th>last updated</th>
        <th></th>
        <th></th>
       </tr>
  </thead>
    <tbody>

        @forelse($all_categories as $category)
        <tr>
            <td class="text-center">
              {{ $category->id }}
            </td>
            <td>
              {{ $category->name }}
            </td>
            <td>
              {{ $category->categoryPosts->count() }}

              {{-- @foreach ($all_categories as $category)
    {{ $categoryCounts[$category->id] }}
@endforeach --}}


            </td>
            <td>
              {{ $category->created_at }}
            </td>
            <td>
              {{-- <form action="" method="post">
                @csrf
                @method('patch') --}}
                <button class="btn btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#edit-category{{ $category->id }}"><i class="fa-solid fa-pen"></i>
                </button>
              {{-- </form> --}}
              {{-- <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
                @csrf
                @method('delete') --}}
                <button class="btn btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#delete-category{{ $category->id }}"><i class="fa-solid fa-trash"></i>
                </button>
            @include('admin.categories.actions')
                {{-- modalの時にinclude忘れないように注意！！ --}}
              {{-- </form> --}}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No Categories found.</td>
        </tr>
        @endforelse
        <tr>
          <td>0</td>
          <td>
            Uncategorized
            <p class="xsmall mb-0">Does not include hidden posts</p>
          </td>
          <td>
            {{$uncategorized_count}}
          </td>
        </tr>
    </tbody>
</table>

{{ $all_categories->links() }}
@endsection

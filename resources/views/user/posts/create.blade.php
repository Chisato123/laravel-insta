@extends('layouts.app')

@section('title','Create Post')

@section('content')

<form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
<p class="fw-bold">Category <span class="fw-light">(up to 3)</span></p>

{{-- List of category check boxes --}}
<div>
    @foreach ($all_categories as $category)
    {{-- from PostController --}}
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="category_id[]" id="{{ $category->name }}" value="{{ $category->id }}">
            {{-- name="category_id[]"のように[]を使うことで、複数のカテゴリを選べるようになっています。 --}}
            <label class="form-check-label" for="{{ $category->name }}">
                {{ $category->name }}
            </label>
        </div>

    @endforeach
</div>
@error('category_id')
<div class="text-danger small">
{{ $message }}
</div>
@enderror

<label for="description" class="form-label fw-bold mt-3">Description</label>
<textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description') }}</textarea>
{{-- {{ old('description') }}入力したないようが、これで残る。 --}}
@error('description')
<div class="text-danger small">
{{ $message }}
</div>
@enderror

<label for="image" class="form-label fw-bold mt-3">Image</label>
<input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
<p class="form-text" id="image-info">
    Acceptable formats: jpeg, jpg, png, gif only <br>
    Max size is 1048 KB
</p>
@error('image')
<div class="text-danger small">
{{ $message }}
</div>
@enderror


<button type="submit" class="btn btn-primary mt-4 px-4">Post</button>

</form>




@endsection

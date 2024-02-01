@extends('layouts.app')

@section('title','Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <form action="{{route('profile.update')}}" method="post" class="shadow rounded-3 bg-white p-5 mb-5" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
          <h3 class="h3 fw-light text-muted mb-3">Update Profile</h3>

            <div class="row mb-3">
                <div class="col-4">
                    {{-- icon/avatar --}}
                    @if(Auth::user()->avatar)
                    <img src="{{Auth::user()->avatar}}" alt="" class="img-thumbnail rounded-circle img-lg d-block mx-auto">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-lg d-block text-center"></i>
                    @endif
                </div>
                <div class="col-auto align-self-end">
                    <input type="file" name="avatar" id="" class="form-control form-control-sm" aria-describedby="avatar-info">
                    <div class="form-text" id="avatar-info">
                        Acceptable formats: jpeg, jpg, png, gif<br>
                        Max file size is 1048 KB
                    </div>
                    @error('avatar')
                        <div class="text-danger small">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" name="name" id="name" value="{{old('name',Auth::user()->name)}}" class="form-control">
                    @error('name')
                        <div class="text-danger small">{{$message}}</div>
                    @enderror


            <label for="email" class="form-label fw-bold mt-3">Email</label>
            <input type="email" name="email" id="email" value="{{old('email',Auth::user()->email)}}" class="form-control">
                    @error('email')
                        <div class="text-danger small">{{$message}}</div>
                    @enderror


            <label for="introduction" class="form-label fw-bold mt-3">Introduction</label>
            <textarea name="introduction" id="introduction" rows="3" class="form-control">{{old('introduction',Auth::user()->introduction)}}</textarea>
                    @error('introduction')
                        <div class="text-danger small">{{$message}}</div>
                    @enderror


            <button type="submit" class="btn btn-warning px-5 mt-4">Save</button>

        </form>

		{{-- update password --}}
		<form action="{{route('profile.updatePassword')}}" method="post" class="shadow rounded-3 bg-white p-5">
			@csrf
			@method('PATCH')
            @if(session('password_change_success'))
            <p class="fw-bold text-success">{{session('password_change_success')}}</p>
            @endif

			<h3 class="h3 fw-light text-muted mb-3">Update Password</h3>
           {{-- {{$incorrect_password_error}} //withの左側を持ってきてる。 --}}

			<label for="old-password" class="form-label fw-bold mt-2">Old Password</label>
			<input type="password" name="old_password" id="old-password" class="form-control">
            @if(session('incorrect_password_error'))
                <div class="text-danger small">{{session('incorrect_password_error')}}</div>
            @endif

			<label for="new-password" class="form-label fw-bold mt-2">New Password</label>
			<input type="password" name="new_password" id="new-password" class="form-control">
            @if(session('same_password_error'))
                <div class="text-danger small">{{session('same_password_error')}}</div>
            @endif
            @error('new_password')
                <div class="text-danger small">{{$message}}</div>
            @enderror


			<label for="new-password-confirmation" class="form-label mt-2">Confirm New Password</label>
			<input type="password" name="new_password_confirmation" id="new-password-confirmation" class="form-control">

            <button type="submit" class="btn btn-warning px-5 mt-4">Update Password</button>


		</form>
    </div>
</div>
@endSection

@if(!$post->trashed())
<div class="modal fade" id="deactivate-post{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="h4 text-danger modal-title">
                <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                </h4>
            </div>
            <div class="modal-body">
                Are you sure you want to hide this post?
                <div>
                    <img src="{{ $post->image }}" alt="" class="img-lg
                    "></div>
                    <div>
                        {{$post->description}}
                    </div>
                </div>
            <div class="modal-footer border-0">
                <form action="{{route('admin.posts.hide', $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>

@else
<div class="modal fade" id="activate-post{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h4 class="h4 text-primary modal-title">
                    <i class="fa-solid fa-eye"></i>  Unhide Post
                </h4>
            </div>
            <div class="modal-body">
                Are you sure you want to display?
                    <div>
                    <img src="{{ $post->image }}" alt="" class="img-lg
                    "></div>
                    <div>
                        {{$post->description}}
                    </div>
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.posts.restore', $post->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Unhide</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

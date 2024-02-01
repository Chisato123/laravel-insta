@if(count($post->likes) > 0)
    <div class="modal fade" id="likesmodal{{$post->id}}">
        <div class="modal-dialog">
            <div class="modal-content border-secondary">
                <div class="modal-header border-0 text-end justify-content-end">
                <button type="button" data-bs-dismiss="modal" class="btn shadow-none text-primary">
                    <i class="fa-solid fa-xmark text-primary"></i>
                </button>
                </div>
                <div class="modal-body mx-auto mb-3 justify-content-between">
                    @foreach($post->likes as $like)
                        <div class="col-auto my-2 mx-2 d-flex">
                            <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm mx-2 mb-2">
                            {{ $like->user->name }}
                            <div>
                                @if($like->user->id !== Auth::user()->id)
                                    @if ($like->user->isFollowed($like->user))
                                        <form action="{{ route('follow.destroy', $like->user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 text-secondary shadow-none mx-2">Unfollow</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $like->user->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn p-0 text-primary mx-2 shadow-none">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif


{{-- <div class="modal fade" id="likesmodal{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-body text-center">
 @foreach($post->likes as $like)
    <div class="col-auto my-2 mx-2 d-flex">
        <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm mx-2 mb-2">
        {{ $like->user->name }}

                @if($like->user->id !== Auth::user()->id)
                    @if ($like->user->isFollowed($like->user))
                        <form action="{{ route('follow.destroy', $like->user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn p-0 text-secondary shadow-none mx-2">Unfollow</button>
                        </form>
                    @else
                            <form action="{{route('follow.store', $like->user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn p-0 text-primary mx-2 shadow-none">Follow</button>
                            </form>
                    @endif
                @endif
    </div>
@endforeach
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="modal fade" id="likesmodal{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-body text-center">
                <div class="row">
                    @foreach($post->likes as $like)
                        <div class="col-6 my-2 mx-2 d-flex">
                            <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm mx-2 mb-2">
                            <div>
                                {{ $like->user->name }}
                                @if($like->user->id !== Auth::user()->id)
                                    @if ($like->user->isFollowed($like->user))
                                        <form action="{{ route('follow.destroy', $like->user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 text-primary shadow-none">Unfollow</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $like->user->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn p-0 text-primary shadow-none">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}

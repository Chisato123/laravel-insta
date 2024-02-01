<div class="mb-2">
    <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>
    &nbsp;
    {{$comment->body}}
    <div>
        <span class="fw-light text-muted xsmall">{{date('D,M d,Y',strtotime($comment->created_at))}}</span>
        @if ($comment->user_id==Auth::user()->id)
        {{-- if comment user = login user --}}
        &middot;
        <form action="{{route('comment.destroy', $comment->id)}}" class="d-inline" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn shadow-none p-0 xsmall text-danger">Delete</button>
        </form>
        @endif
    </div>

</div>

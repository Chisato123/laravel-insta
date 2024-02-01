@if(!$user->trashed())
<div class="modal fade" id="deactivate-user{{$user->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="h4 text-danger modal-title">
                    <i class="fa-solid fa-user-slash"></i> Deactivate User
                </h4>
            </div>
            <div class="modal-body">
                Are you sure you want to deactivate {{$user->name}}?
            </div>
            <div class="modal-footer border-0">
                <form action="{{route('admin.users.deactivate', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>

@else
<div class="modal fade" id="activate-user{{$user->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h4 class="h4 text-success modal-title">
                    <i class="fa-solid fa-user-check"></i> Activate User
                </h4>
            </div>
            <div class="modal-body">
                Are you sure you want to activate {{$user->name}}?
            </div>
            <div class="modal-footer border-0">
                <form action="{{route('admin.users.activate', $user->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-success">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

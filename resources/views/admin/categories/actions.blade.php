<div class="modal fade" id="delete-category{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="h4 text-dark modal-title">
                <i class="fa-solid fa-trash"></i> Delete Category
                </h4>
            </div>
            <div class="modal-body text-start">
                Are you sure you want to delete {{$category->name}} category?
                <br>
                This action will affect all the posts under this category. Posts without a category fall under Uncategorized.
            </div>
            <div class="modal-footer border-0">
                <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-category{{ $category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h4 class="h4 text-dark modal-title">
                    <i class="fa-regular fa-pen-to-square"></i>  Edit Category
                </h4>
            </div>
            <form action="{{route('admin.categories.update', $category->id)}}" method="post">
                @csrf
                @method('PATCH')
            <div class="modal-body">
                    <input type="text" name="categ_name" value="{{ $category->name }}" class="form-control">
            </div>

            <div class="modal-footer border-1">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-warning">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

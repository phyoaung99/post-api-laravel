<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Create Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value=""
                            placeholder="Enter Title">
                            <span class="text-danger">
                                <strong id="title-error"></strong>
                            </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value=""
                            placeholder="Enter description">
                            <span class="text-danger">
                                <strong id="description-error"></strong>
                            </span>
                    </div>
                    <button class="btn btn-primary float-end" id="formModalButton">Add Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

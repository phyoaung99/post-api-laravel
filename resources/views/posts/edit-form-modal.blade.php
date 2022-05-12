<div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><Title></Title></label>
                        <input type="text" name="title" id="edit-title" class="form-control" value=""
                            placeholder="Enter Title">
                        <small class="text-danger form-error fade" data-error="name"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="edit-description" class="form-control" value=""
                            placeholder="Enter description">
                        <small class="text-danger form-error fade" data-error="description"></small>
                    </div>
                    <button class="btn btn-primary float-end" id="editFormModalButton">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

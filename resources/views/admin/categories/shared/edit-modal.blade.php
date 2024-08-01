<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <form action="" id="updateCategoryForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="update_id" id="update_id">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="updateCategoryModalLabel">Edit Category/Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="update_category_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="update_category_name"
                            name="update_category_name">
                        <p></p>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mx-3" id="btnUpdateCategory">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

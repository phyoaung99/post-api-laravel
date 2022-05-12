<div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="formModalLabel">Import Post Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <form id="import-form">
                  @csrf
                  <input type="file" name="file" id="file" accept=".csv" class="form-control" required>
                  <br>
                  <button class="btn btn-success">Import Data</button>
              </form>
          </div>
          </div>
      </div>
  </div>
</div>
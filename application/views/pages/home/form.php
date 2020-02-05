<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title"><?=$title?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
      <form role="form" action="<?=$action?>" id="dokumen-form">
        <div class="card-body">
          <input type="hidden" id="id" class="form-control" placeholder="ID"  value="<?= isset($data->id) ? $data->id : '' ?>" readonly>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input  autocomplete="off" type="text" name="nama" id="nama" class="form-control" placeholder="Nama"  
              value="<?= isset($data->nama) ? $data->nama : '' ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Buy</label>
            <div class="col-sm-10">
              <input autocomplete="off" type="number" name="buy" id="buy" class="form-control" placeholder="Buy" 
              value="<?= isset($data->buy) ? $data->buy : '' ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Sale</label>
            <div class="col-sm-10">
              <input autocomplete="off" type="number" name="sale" id="sale" class="form-control" placeholder="Sale" 
              value="<?= isset($data->sale) ? $data->sale : '' ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Qty</label>
            <div class="col-sm-10">
              <input autocomplete="off" type="number" name="qty" id="qty" class="form-control" placeholder="Qty" 
              value="<?= isset($data->qty) ? $data->qty : '' ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="submit-dokumen" class="btn btn-success">Simpan</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

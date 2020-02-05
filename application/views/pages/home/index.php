<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h3><?=$breadcrumb?></h3>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <button type="button" onclick="showModal('home/form', '', 'add')" class="btn btn-primary">
          <i class="fa fa-plus"></i> <span>Tambah Data</span></button>
        </div>
        <div class="card-body">
          <table id="table" class="table table-bordered table-striped"  cellspacing="0">
            <thead>
            <tr style="text-align: center;">
              <th>No</th>
              <th>Nama</th>
              <th>Buy</th>
              <th>Sale</th>
              <th>Qty</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
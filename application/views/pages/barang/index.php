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
          <button type="button" onclick="showModal('barang/form', '', 'add')" class="btn btn-primary">
          <i class="fa fa-plus"></i> <span>Tambah Data</span></button>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
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
                <?php
                    if (!empty($data)) {
                        $no = 0;
                        foreach ($data as $key) {
                        $no++;
				?>
                <tr>
                    <td align="center"><?=$no?></td>
                    <td><?=$key->nama?></td>
                    <td><?=$key->buy?></td>
                    <td><?=$key->sale?></td>
                    <td><?=$key->qty?></td>
                    <td align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" 
                                onclick="showModal('barang/form', '<?=$key->id?>', 'edit')"> 
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="dropdown-item" 
                                    onclick="confirms('Delete','Barang `<?= $key->nama ?>`?','<?= base_url('barang/delete') ?>','<?= $key->id ?>')"> 
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
						}
					}
				?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
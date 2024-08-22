<!-- Bagian Resep Obat -->
	<div class="col-md-12">
		<div id="resepFormContainer" style="display:none;">
            <form id="dynamicResepForm">
                <div id="resepInputs">
                    <div class="form-row resep-item">
                        <div class="form-group col-md-2">
                            <label for="kode_brng">Obat/Alkes/BHP</label>
                            <input type="text" class="form-control form-control-sm kode_brng" name="kode_brng[]">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nama_brng">Nama Obat</label>
                            <input type="text" class="form-control form-control-sm nama_brng" name="nama_brng[]" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="stok">Stok</label>
                            <input type="text" class="form-control form-control-sm stok" name="stok[]" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control form-control-sm harga" name="harga[]" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="jml">Jumlah</label>
                            <input type="text" class="form-control form-control-sm jml" name="jml[]">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="aturan_pakai">Aturan Pakai</label>
                            <input type="text" class="form-control form-control-sm aturan_pakai" name="aturan_pakai[]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="addResepInput">Tambah Obat</button>
                <button type="button" class="btn btn-primary btn-sm" id="saveResep">Save</button>
                <button type="button" class="btn btn-danger btn-sm" id="closeResepForm">Close</button>
            </form>
        </div>
        <br>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Resep Obat</h6>
                <button type="button" class="btn btn-primary btn-md" id="toggleResepForm">
                    Tambah Resep
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="resepTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Jumlah</th>
                                <th>Signa</th>
                                <th>Satuan</th>
                                <th>Total Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data resep akan dimuat di sini oleh JavaScript -->
                        </tbody>
                        <tfoot>
                            <!-- Footer untuk total biaya akan dimuat di sini oleh JavaScript -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
	</div>
        

        <script src="<?php echo base_url('assets/js/resep.js'); ?>"></script>
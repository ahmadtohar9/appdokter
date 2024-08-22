<div class="col-md-12">
    <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tindakan Rawat Jalan Dokter</h6>
            </div>
            <div class="card-body">
                <div class="form-row mb-3">
                    <div class="form-group col-md-5">
                        <label for="nm_perawatan">Nama Tindakan</label>
                        <input type="text" class="form-control form-control-sm" id="nm_perawatan" placeholder="Cari Tindakan...">
                        <input type="hidden" class="form-control form-control-sm kd_jenis_prw" id="kd_jenis_prw" name="kd_jenis_prw[]">
                        <input type="hidden" class="form-control form-control-sm" id="material" name="material[]">
                        <input type="hidden" class="form-control form-control-sm" id="bhp" name="bhp[]">
                        <input type="hidden" class="form-control form-control-sm" id="tarif_tindakandr" name="tarif_tindakandr[]">
                        <input type="hidden" class="form-control form-control-sm" id="kso" name="kso[]">
                        <input type="hidden" class="form-control form-control-sm" id="menejemen" name="menejemen[]">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="total_byrdr">Total Biaya</label>
                        <input type="text" class="form-control form-control-sm" id="total_byrdr" placeholder="Biaya..." readonly>
                    </div>
                    <div class="form-group col-md-2 align-self-end">
                        <button type="button" class="btn btn-secondary btn-sm" id="addTindakan">Tambah Tindakan</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tindakanTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Tindakan</th>
                                <th>Nama Tindakan</th>
                                <th>Jam</th>
                                <th>Total Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data tindakan akan dimuat di sini oleh JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"><strong>Total Keseluruhan:</strong></td>
                                <td colspan="2"><strong>Rp. 0,00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="<?php echo base_url('assets/js/tindakan.js'); ?>"></script>
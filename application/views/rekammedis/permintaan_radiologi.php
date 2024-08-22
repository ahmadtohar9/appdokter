    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Radiologi</h6>
        </div>
        <div class="card-body">
            <div class="form-row mb-3">
                <div class="form-group col-md-2">
                    <label for="tgl_sampel">Tanggal Sampel</label>
                    <input type="date" class="form-control form-control-sm" id="tgl_permintaan" name="tgl_permintaan" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="jam_sampel">Jam Sampel</label>
                    <input type="time" class="form-control form-control-sm" id="jam_permintaan" name="jam_permintaan" value="<?php echo date('H:i:s'); ?>">
                    <input type="hidden" id="original_jam" name="original_jam" value="<?php echo date('H:i:s'); ?>">
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="form-group col-md-6">
                    <label for="informasi_tambahan">Informasi Tambahan</label>
                    <input type="text" class="form-control form-control-sm" id="informasi_tambahan" name="informasi_tambahan" placeholder="Informasi Tambahan...">
                </div>
                <div class="form-group col-md-6">
                    <label for="diagnosa_klinis">Diagnosa Klinis</label>
                    <input type="text" class="form-control form-control-sm" id="diagnosa_klinis" name="diagnosa_klinis" placeholder="Diagnosa Klinis...">
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="form-group col-md-6">
                    <label for="nm_perawatan_radiologi">Nama Tindakan</label>
                    <input type="text" class="form-control form-control-sm" id="nm_perawatan_radiologi" name="nm_perawatan">
                    <input type="hidden" class="form-control form-control-sm" id="kd_jenis_prw" name="kd_jenis_prw">
                </div>
                <div class="form-group col-md-3">
                    <label for="total_byr_radiologi">Total Biaya</label>
                    <input type="text" class="form-control form-control-sm" id="total_byr_radiologi" name="total_byr" readonly>
                </div>
                <div class="form-group col-md-3 align-self-end">
                    <button type="button" class="btn btn-secondary btn-sm" id="addTindakanRadiologi">Tambah Tindakan</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="tindakanRadiologiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Order</th>
                            <th>Tgl. Order</th>
                            <th>Indikasi</th>
                            <th>Diagnosa</th>
                            <th>Tindakan</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data tindakan akan dimuat di sini oleh JavaScript -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"><strong>Total Keseluruhan:</strong></td>
                            <td colspan="2"><strong>Rp. 0,00</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

<script src="<?php echo base_url('assets/js/radiologi.js'); ?>"></script>
    
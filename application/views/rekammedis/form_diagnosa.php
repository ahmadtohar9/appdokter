
<div class="row">
            <!-- Kolom Diagnosa -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Diagnosa</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="kd_penyakit">Kode Diagnosa</label>
                                <input type="text" class="form-control form-control-sm" id="kd_penyakit" placeholder="Cari Diagnosa...">
                                <input type="hidden" name="no_rawat" value="<?php echo $no_rawat; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="prioritas">Prioritas</label>
                                <select class="form-control form-control-sm" id="prioritas" name="prioritas">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 align-self-end">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="submitDiagnosa()">Tambah Diagnosa</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="diagnosaTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Diagnosa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data diagnosa akan dimuat di sini oleh JavaScript -->
                                </tbody>
                                <tfoot>
                                    <!-- Opsional jika ada perhitungan total keseluruhan -->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Prosedur Penyakit -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Prosedur Penyakit</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="kode">Kode Prosedur</label>
                                <input type="text" class="form-control form-control-sm" id="kode" placeholder="Cari Prosedur...">
                                <input type="hidden" name="no_rawat" value="<?php echo $no_rawat; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="prioritas">Prioritas</label>
                                <select class="form-control form-control-sm" id="prioritas" name="prioritas">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 align-self-end">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="submitProsedur()">Tambah Prosedur</button>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="prosedurTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Prosedur</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data prosedur akan dimuat di sini oleh JavaScript -->
                                </tbody>
                                <tfoot>
                                    <!-- Opsional jika ada perhitungan total keseluruhan -->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script src="<?php echo base_url('assets/js/diagnosa.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/prosedur.js'); ?>"></script>
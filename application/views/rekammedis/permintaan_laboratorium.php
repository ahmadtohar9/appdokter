<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Permintaan Laboratorium</h6>
            </div>
            <div class="card-body">
                <!-- Form permintaan laboratorium -->
                <div class="row">
                    <!-- Pencarian Tindakan Laboratorium -->
                    <div class="col-md-6">
                        <h4>Pencarian Tindakan Laboratorium</h4>
                        <input type="text" id="searchLab" class="form-control" placeholder="Cari Pemeriksaan...">
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Kode Periksa</th>
                                    <th>Nama Pemeriksaan</th>
                                </tr>
                            </thead>
                            <tbody id="labList">
                                <!-- Data akan dimuat di sini melalui AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Daftar Pemeriksaan yang Dipilih -->
                    <div class="col-md-6">
                        <h4>Daftar Pemeriksaan yang Dipilih</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Kode Periksa</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="selectedLabList">
                                <!-- Pemeriksaan yang dipilih akan muncul di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <!-- Detail Pemeriksaan -->
                    <div class="col-md-12">
                        <h4>Detail Pemeriksaan</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Pemeriksaan</th>
                                    <th>Satuan</th>
                                    <th>Nilai Rujukan</th>
                                </tr>
                            </thead>
                            <tbody id="labDetailList">
                                <!-- Detail pemeriksaan akan muncul di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tambahkan informasi tambahan, indikasi klinis, dan lainnya -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_permintaan">Tanggal Permintaan</label>
                            <input type="date" class="form-control" id="tgl_permintaan" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_permintaan">Jam Permintaan</label>
                            <input type="time" class="form-control" id="jam_permintaan" value="<?php echo date('H:i:s'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="informasi_tambahan">Informasi Tambahan</label>
                            <input type="text" class="form-control" id="informasi_tambahan" placeholder="Masukkan informasi tambahan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="diagnosa_klinis">Diagnosa Klinis</label>
                            <input type="text" class="form-control" id="diagnosa_klinis" placeholder="Masukkan diagnosa klinis">
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" id="saveLabOrder" class="btn btn-success">Simpan Permintaan Laboratorium</button>
                    </div>
                </div>
            </div>
        </div>

         <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Permintaan Laboratorium</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="hasilLabTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Order</th>
                                <th>Tgl. Permintaan</th>
                                <th>Jam Permintaan</th>
                                <th>Nama Perawatan</th>
                                <th>Pemeriksaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data hasil lab akan dimuat di sini oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<script src="<?php echo base_url('assets/js/laboratorium.js'); ?>"></script>
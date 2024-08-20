<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                Informasi Pasien
            </div>
            <div class="card-body">
                <!-- Informasi Pasien -->
                <div class="form-group">
                    <label>No Rawat</label>
                    <input type="text" class="form-control" value="<?php echo $detail_pasien->no_rawat; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>No Rekam Medis</label>
                    <input type="text" class="form-control" value="<?php echo $detail_pasien->no_rkm_medis; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" class="form-control" value="<?php echo $detail_pasien->nm_pasien; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Dokter</label>
                    <input type="text" class="form-control" value="<?php echo $detail_pasien->nm_dokter; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Poliklinik</label>
                    <input type="text" class="form-control" value="<?php echo $detail_pasien->nm_poli; ?>" disabled>
                </div>
                <a href="<?php echo base_url('DokterController/index');?>" class="btn btn-sm btn-danger">MENU UTAMA</a>
            </div>
        </div>
    </div>

    <div class="col-9">
        <div class="card">
            <div class="card-header">
                Form SOAP
            </div>
            <div class="card-body">
                <!-- Flash Messages -->
                <div id="flash-message"></div>
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <!-- Form SOAP -->
                <form id="soapForm" action="<?php echo site_url('SoapController/save_soap'); ?>" method="post">
                    <?php if (isset($detail_pasien)): ?>
                    <input type="hidden" name="no_rawat" id="no_rawat" value="<?php echo $detail_pasien->no_rawat; ?>">
                    <input type="hidden" name="kd_dokter" id="kd_dokter" value="<?php echo $detail_pasien->kd_dokter; ?>">
                    <?php else: ?>
                    <div class="alert alert-danger">Detail pasien tidak ditemukan.</div>
                    <?php endif; ?>

                    <!-- Tanggal dan Jam -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="jam">Jam</label>
                            <input type="text" class="form-control form-control-sm" id="jam" name="jam" value="<?php echo isset($jam_rawat) ? $jam_rawat : date('H:i:s'); ?>">
                            <input type="hidden" id="original_jam" name="original_jam" value="<?php echo isset($jam_rawat) ? $jam_rawat : ''; ?>">
                        </div>
                    </div>

                    <!-- Pemeriksaan Fisik -->
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="tensi">Tensi (mmHg)</label>
                            <input type="text" class="form-control form-control-sm" id="tensi" name="tensi" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="suhu_tubuh">Suhu (C)</label>
                            <input type="text" class="form-control form-control-sm" id="suhu_tubuh" name="suhu_tubuh" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nadi">Nadi (mnt)</label>
                            <input type="text" class="form-control form-control-sm" id="nadi" name="nadi" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="respirasi">RR (mnt)</label>
                            <input type="text" class="form-control form-control-sm" id="respirasi" name="respirasi" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tinggi">Tinggi (cm)</label>
                            <input type="text" class="form-control form-control-sm" id="tinggi" name="tinggi" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="berat">Berat (kg)</label>
                            <input type="text" class="form-control form-control-sm" id="berat" name="berat" value="">
                        </div>
                    </div>

                    <!-- Kesadaran, SPO2, GCS, Alergi, Lingkar Perut -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="kesadaran">Kesadaran</label>
                            <select class="form-control form-control-sm" id="kesadaran" name="kesadaran">
                                <option value="Compos Mentis">Compos Mentis</option>
                                <option value="Somnolence">Somnolence</option>
                                <option value="Sopor">Sopor</option>
                                <option value="Coma">Coma</option>
                                <option value="Alert">Alert</option>
                                <option value="Confusion">Confusion</option>
                                <option value="Voice">Voice</option>
                                <option value="Pain">Pain</option>
                                <option value="Unresponsive">Unresponsive</option>
                                <option value="Apatis">Apatis</option>
                                <option value="Delirium">Delirium</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="spo2">SPO2</label>
                            <input type="text" class="form-control form-control-sm" id="spo2" name="spo2" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="gcs">GCS</label>
                            <input type="text" class="form-control form-control-sm" id="gcs" name="gcs" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="alergi">Alergi</label>
                            <input type="text" class="form-control form-control-sm" id="alergi" name="alergi" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="lingkar_perut">Lingkar Perut</label>
                            <input type="text" class="form-control form-control-sm" id="lingkar_perut" name="lingkar_perut" value="">
                        </div>
                    </div>

                    <!-- Bagian SOAP -->
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keluhan">Subjektif</label>
                                <textarea class="form-control form-control-sm" id="keluhan" name="keluhan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pemeriksaan">Objektif</label>
                                <textarea class="form-control form-control-sm" id="pemeriksaan" name="pemeriksaan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penilaian">Assesment</label>
                                <textarea class="form-control form-control-sm" id="rtl" name="rtl" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rtl">Plan</label>
                                <textarea class="form-control form-control-sm" id="penilaian" name="penilaian" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instruksi">Instruksi</label>
                                <textarea class="form-control form-control-sm" id="instruksi" name="instruksi" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="evaluasi">Evaluasi</label>
                                <textarea class="form-control form-control-sm" id="evaluasi" name="evaluasi" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary btn-md" id="saveButton">Simpan</button>
                        <button type="submit" class="btn btn-warning btn-md" id="updateButton" style="display:none;">Update</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" style="display:none;">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>
<br><br>

<!-- Bagian Rincian Riwayat -->

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Riwayat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th width="150px">Tanggal</th>
                                <th>SOAP</th>
                            </tr>
                        </thead>
                        <tbody id="soapDataList">
                            <!-- Data SOAP akan dimuat di sini melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bagian Diagnosa dan Prosedur Penyakit -->
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
    </div>


        <!-- Bagian Resep Obat -->
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


        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tindakan Dokter</h6>
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


    </div>
</div>

<script>
$(document).ready(function(){
    // Set tanggal default ke tanggal hari ini
    var today = new Date().toISOString().split('T')[0];
    $('#tanggal').val(today);
});
</script>

<script>
    const base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url('assets/js/soap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/prosedur.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/diagnosa.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/resep.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tindakan.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/radiologi.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/laboratorium.js'); ?>"></script>

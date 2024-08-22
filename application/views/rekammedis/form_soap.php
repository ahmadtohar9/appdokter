<div class="row">
        <?php $this->load->view('rekammedis/informasi_pasien'); ?>
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

<br/>
<br/>

<script src="<?php echo base_url('assets/js/soap.js'); ?>"></script>


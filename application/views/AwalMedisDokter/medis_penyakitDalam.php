<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Form Assemen Awal Medis Penyakit Dalam
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
                <form id="asesmenForm" onsubmit="submitAsesmen(event);">
                    
                    <!-- Dokter, Tanggal, Anamnesis -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="no_rawat">No.Rawat</label>
                            <input type="text" class="form-control form-control-sm" name="no_rawat" id="no_rawat" value="<?php echo $detail_pasien->no_rawat;?>" readonly>
                            <input type="hidden" name="kd_dokter" id="kd_dokter" value="<?php echo $detail_pasien->kd_dokter; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nm_pasien">Pasien</label>
                            <input type="text" class="form-control form-control-sm" name="nm_pasien" id="nm_pasien" value="<?php echo $detail_pasien->nm_pasien;?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tgl_lahir">Tgl.Lahir</label>
                            <input type="date" class="form-control form-control-sm" name="tgl_lahir" id="tgl_lahir" value="<?php echo $detail_pasien->tgl_lahir;?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="jk">Jenis Kelamin</label>
                            <input type="text" class="form-control form-control-sm" name="jk" id="jk" 
                                   value="<?php echo ($detail_pasien->jk == 'L') ? 'Laki-Laki' : 'Perempuan'; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dokter">Dokter:</label>
                            <input type="text" class="form-control form-control-sm" id="dokter" name="dokter" value="<?php echo $detail_pasien->nm_dokter; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_jam">Tanggal dan Jam</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="tanggal_jam" name="tanggal_jam" 
                                   value="<?php echo isset($tanggal_jam) ? date('Y-m-d\TH:i', strtotime($tanggal_jam)) : date('Y-m-d\TH:i:s'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="anamnesis">Anamnesis:</label>
                            <select class="form-control form-control-sm" id="anamnesis" name="anamnesis">
                                <option value="autoanamnesis">Autoanamnesis</option>
                                <option value="alloanamnesis">Alloanamnesis</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- I. RIWAYAT KESEHATAN -->
                    <h5>I. RIWAYAT KESEHATAN</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="keluhan_utama">Keluhan Utama:</label>
                            <textarea class="form-control form-control-sm" id="keluhan_utama" name="keluhan_utama" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="riwayat_penggunaan_obat">Riwayat Penggunaan Obat:</label>
                            <textarea class="form-control form-control-sm" id="riwayat_penggunaan_obat" name="riwayat_penggunaan_obat" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="riwayat_penyakit_sekarang">Riwayat Penyakit Sekarang:</label>
                            <textarea class="form-control form-control-sm" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="riwayat_penyakit_dahulu">Riwayat Penyakit Dahulu:</label>
                            <textarea class="form-control form-control-sm" id="riwayat_penyakit_dahulu" name="riwayat_penyakit_dahulu" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="riwayat_alergi">Riwayat Alergi:</label>
                            <input type="text" class="form-control form-control-sm" id="riwayat_alergi" name="riwayat_alergi">
                        </div>
                    </div>

                    <!-- II. PEMERIKSAAN FISIK -->
                    <h5>II. PEMERIKSAAN FISIK</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="status_nutrisi">Status Nutrisi:</label>
                                    <input type="text" class="form-control form-control-sm" id="status_nutrisi" name="status_nutrisi">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="td">TD (mmHg):</label>
                                    <input type="text" class="form-control form-control-sm" id="td" name="td">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nadi">Nadi (x/menit):</label>
                                    <input type="text" class="form-control form-control-sm" id="nadi" name="nadi">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suhu">Suhu (°C):</label>
                                    <input type="text" class="form-control form-control-sm" id="suhu" name="suhu">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rr">RR (x/menit):</label>
                                    <input type="text" class="form-control form-control-sm" id="rr" name="rr">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bb">BB (Kg):</label>
                                    <input type="text" class="form-control form-control-sm" id="bb" name="bb">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nyeri">Nyeri:</label>
                                    <input type="text" class="form-control form-control-sm" id="nyeri" name="nyeri">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gcs">GCS(E,V,M):</label>
                                    <input type="text" class="form-control form-control-sm" id="gcs" name="gcs">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="kondisi_umum">Kondisi Umum:</label>
                                <textarea class="form-control form-control-sm" id="kondisi_umum" name="kondisi_umum" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- III. STATUS KELAINAN -->
                    <h5>III. STATUS KELAINAN</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="kepala">Kepala:</label>
                                    <select class="form-control form-control-sm" id="kepala" name="kepala">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Keterangan :</label>
                                    <input type="text" id="keterangan_kepala" name="keterangan_kepala" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="thoraks">Thoraks:</label>
                                    <select class="form-control form-control-sm" id="thoraks" name="thoraks">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Keterangan :</label>
                                    <input type="text" id="keterangan_thorak" name="keterangan_thorak" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="abdomen">Abdomen:</label>
                                    <select class="form-control form-control-sm" id="abdomen" name="abdomen">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Keterangan :</label>
                                    <input type="text" id="keterangan_abdomen" name="keterangan_abdomen" class="form-control form-control-sm">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ekstremitas">Ekstremitas:</label>
                                    <select class="form-control form-control-sm" id="ekstremitas" name="ekstremitas">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Keterangan :</label>
                                    <input type="text" id="keterangan_ekstremitas" name="keterangan_ekstremitas" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="lainnya">Lainnya:</label>
                                <textarea class="form-control form-control-sm" id="lainnya" name="lainnya" rows="12"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- IV. PEMERIKSAAN PENUNJANG -->
                    <h5>IV. PEMERIKSAAN PENUNJANG</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="laboratorium">Laboratorium:</label>
                            <textarea class="form-control form-control-sm" id="laboratorium" name="laboratorium" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="radiologi">Radiologi:</label>
                            <textarea class="form-control form-control-sm" id="radiologi" name="radiologi" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="penunjang_lainnya">Penunjang Lainnya:</label>
                            <textarea class="form-control form-control-sm" id="penunjang_lainnya" name="penunjang_lainnya" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- V. DIAGNOSIS/ASESMEN -->
                    <h5>V. DIAGNOSIS/ASESMEN</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="diagnosis">Asesmen Kerja:</label>
                            <textarea class="form-control form-control-sm" id="diagnosis" name="diagnosis" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="diagnosis2">Asesmen Banding:</label>
                            <textarea class="form-control form-control-sm" id="diagnosis2" name="diagnosis2" rows="4"></textarea>
                        </div>
                    </div>

                    <!-- VI. PERMASALAHAN & TATALAKSANA -->
                    <h5>VI. PERMASALAHAN & TATALAKSANA</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="permasalahan">Permasalahan:</label>
                            <textarea class="form-control form-control-sm" id="permasalahan" name="permasalahan" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="terapi">Terapi/Pengobatan:</label>
                            <textarea class="form-control form-control-sm" id="terapi" name="terapi" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tindakan">Tindakan/Rencana Tindakan:</label>
                            <textarea class="form-control form-control-sm" id="tindakan" name="tindakan" rows="4"></textarea>
                        </div>
                    </div>

                    <!-- VII. EDUKASI -->
                    <h5>VII. EDUKASI</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="edukasi">Edukasi:</label>
                            <textarea class="form-control form-control-sm" id="edukasi" name="edukasi" rows="4"></textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-row">
                       <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                        <button type="submit" class="btn btn-warning btn-md" id="updateButton" style="display:none;" onclick="updateAsesmen(event);">Update</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" style="display:none;" onclick="cancelEdit();">Batal</button>

                    </div>
                </form>
            </div>
        </div>
    </div>  
</div>

<br/>
<br/>



<script src="<?php echo base_url('assets/js/medisDokter/medisDalam.js'); ?>"></script>

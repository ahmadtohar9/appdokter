<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Form Penilaian Medis Orthopedi
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

                <!-- Form -->
                <form id="asesmenMedisOrthopediForm" onsubmit="submitAsesmenMedisOrthopedi(event);">
                    
                    <!-- Dokter, Tanggal, Anamnesis -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="no_rawat">No.Rawat</label>
                            <input type="text" class="form-control form-control-sm" name="no_rawat" id="no_rawat" value="<?php echo $detail_pasien->no_rawat;?>" readonly>
                            <input type="hidden" name="kd_dokter" id="kd_dokter" value="<?php echo $detail_pasien->kd_dokter; ?>">
                             <input type="hidden" name="no_rawat" id="no_rawat" value="<?php echo $detail_pasien->no_rawat; ?>">
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
                        <div class="form-group col-md-2">
                            <label for="dokter">Dokter:</label>
                            <input type="text" class="form-control form-control-sm" id="dokter" name="dokter" value="<?php echo $detail_pasien->nm_dokter; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_jam">Tanggal dan Jam</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="tanggal_jam" name="tanggal_jam" 
                                   value="<?php echo isset($tanggal_jam) ? date('Y-m-d\TH:i', strtotime($tanggal_jam)) : date('Y-m-d\TH:i:s'); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="anamnesis">Anamnesis:</label>
                            <select class="form-control form-control-sm" id="anamnesis" name="anamnesis">
                                <option value="autoanamnesis">Autoanamnesis</option>
                                <option value="alloanamnesis">Alloanamnesis</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="hubungan">Hubungan :</label>
                            <input type="text" name="hubungan" id="hubungan" class="form-control form-control-sm">
                        </div>
                    </div>
                    
                    <!-- I. RIWAYAT KESEHATAN -->
                    <h5>I. RIWAYAT KESEHATAN</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="keluhan_utama">Keluhan Utama:</label>
                            <textarea class="form-control form-control-sm" id="keluhan_utama" name="keluhan_utama" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rps">Riwayat Penyakit Sekarang:</label>
                            <textarea class="form-control form-control-sm" id="rps" name="rps" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="rpd">Riwayat Penyakit Dahulu:</label>
                            <textarea class="form-control form-control-sm" id="rpd" name="rpd" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rpo">Riwayat Penggunaan Obat:</label>
                            <textarea class="form-control form-control-sm" id="rpo" name="rpo" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="alergi">Riwayat Alergi:</label>
                            <input type="text" class="form-control form-control-sm" id="alergi" name="alergi">
                        </div>
                    </div>

                    <!-- II. PEMERIKSAAN FISIK -->
                    <h5>II. PEMERIKSAAN FISIK</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                 <div class="form-group col-md-4">
                                    <label for="kesadaran">Kesadaran:</label>
                                    <select class="form-control form-control-sm" id="kesadaran" name="kesadaran">
                                        <option value="Compos Mentis">Compos Mentis</option>
                                        <option value="Apatis">Apatis</option>
                                        <option value="Delirium">Delirium</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="td">TD (mmHg):</label>
                                    <input type="text" class="form-control form-control-sm" id="td" name="td">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nadi">Nadi (x/menit):</label>
                                    <input type="text" class="form-control form-control-sm" id="nadi" name="nadi">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rr">RR (x/menit):</label>
                                    <input type="text" class="form-control form-control-sm" id="rr" name="rr">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suhu">Suhu (°C):</label>
                                    <input type="text" class="form-control form-control-sm" id="suhu" name="suhu">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status Nutrisi</label>
                                    <input type="text" class="form-control form-control-sm" id="status" name="status">
                                </div>
                            </div>
                            <div class="form-row">
                                
                                <div class="form-group col-md-3">
                                    <label for="bb">BB (Kg):</label>
                                    <input type="text" class="form-control form-control-sm" id="bb" name="bb">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nyeri">Nyeri:</label>
                                    <input type="text" class="form-control form-control-sm" id="nyeri" name="nyeri">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gcs">GCS(E,V,M):</label>
                                    <input type="text" class="form-control form-control-sm" id="gcs" name="gcs">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="kepala">Kepala:</label>
                                    <select class="form-control form-control-sm" id="kepala" name="kepala">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="thoraks">Thoraks:</label>
                                    <select class="form-control form-control-sm" id="thoraks" name="thoraks">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="abdomen">Abdomen:</label>
                                    <select class="form-control form-control-sm" id="abdomen" name="abdomen">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ekstremitas">Ekstremitas:</label>
                                    <select class="form-control form-control-sm" id="ekstremitas" name="ekstremitas">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="columna">Columna Vertebralis:</label>
                                    <select class="form-control form-control-sm" id="columna" name="columna">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="muskulos">Muskuloskeletal:</label>
                                    <select class="form-control form-control-sm" id="muskulos" name="muskulos">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="genetalia">Genetalia Os Pubis:</label>
                                    <select class="form-control form-control-sm" id="genetalia" name="genetalia">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="lainnya">Keterangan Lainnya:</label>
                                    <textarea class="form-control form-control-sm" id="lainnya" name="lainnya" rows="16"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- III. GAMBAR LOKALIS -->
                    <h5>III. GAMBAR LOKALIS</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <canvas id="lokalisCanvas" width="500" height="400"></canvas>
                            <img id="lokalisImage" src="<?php echo base_url('assets/gambar/medisdokter/gambarmedisorthopedi.PNG'); ?>" style="display: none;" />
                            <!-- Tambahkan tombol Simpan dan Batal di bawah canvas -->
                            <button type="button" class="btn btn-success mt-2" onclick="saveLokalis()">Simpan Lokalis</button>
                            <button type="button" class="btn btn-danger mt-2" onclick="resetLokalis()">Batal Lokalis</button>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="ket_lokalis">Keterangan Lokalis:</label>
                                    <textarea class="form-control form-control-sm" id="ket_lokalis" name="ket_lokalis" rows="12"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- IV. PEMERIKSAAN PENUNJANG -->
                    <h5>IV. PEMERIKSAAN PENUNJANG</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="lab">Laboratorium:</label>
                            <textarea class="form-control form-control-sm" id="lab" name="lab" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rad">Radiologi:</label>
                            <textarea class="form-control form-control-sm" id="rad" name="rad" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pemeriksaan">Penunjang Lainnya:</label>
                            <textarea class="form-control form-control-sm" id="pemeriksaan" name="pemeriksaan" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- V. DIAGNOSIS -->
                    <h5>V. DIAGNOSIS/ASSESMEN</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="diagnosis">Diagnosis Utama:</label>
                            <textarea class="form-control form-control-sm" id="diagnosis" name="diagnosis" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="diagnosis2">Diagnosis Sekunder:</label>
                            <textarea class="form-control form-control-sm" id="diagnosis2" name="diagnosis2" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- VI. TATALAKSANA -->
                    <h5>VI. PERMASALAHAN & TATALAKSANA</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="permasalahan">Permasalahan:</label>
                            <textarea class="form-control form-control-sm" id="permasalahan" name="permasalahan" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="terapi">Terapi:</label>
                            <textarea class="form-control form-control-sm" id="terapi" name="terapi" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tindakan">Tindakan:</label>
                            <textarea class="form-control form-control-sm" id="tindakan" name="tindakan" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- VII. EDUKASI -->
                    <h5>VII. EDUKASI</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="edukasi">Edukasi:</label>
                            <textarea class="form-control form-control-sm" id="edukasi" name="edukasi" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                        <button type="submit" class="btn btn-warning btn-md" id="updateButton" style="display:none;" onclick="updateAsesmenMedisOrthopedi(event);">Update</button>
                        <button type="button" class="btn btn-secondary btn-md" id="cancelButton" style="display:none;" onclick="cancelEdit();">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
</div>

<br/>
<br/>
<script>
    var uploadUrl = '<?php echo $this->config->item('upload_url'); ?>';
    console.log('Upload URL:', uploadUrl); // Debugging untuk melihat nilai uploadUrl
</script>

<script src="<?php echo base_url('assets/js/medisDokter/medisOrthopedi.js'); ?>"></script>

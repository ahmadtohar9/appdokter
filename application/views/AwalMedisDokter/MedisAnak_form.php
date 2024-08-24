<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Form Penilaian Medis Anak
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
                <form id="asesmenMedisAnakForm" onsubmit="submitAsesmenMedisAnak(event);">
                    
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
                            <label for="rpk">Riwayat Penyakit Keluarga:</label>
                            <textarea class="form-control form-control-sm" id="rpk" name="rpk" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
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
                                <div class="form-group col-md-3">
                                    <label for="keadaan">Keadaan Umum:</label>
                                    <select class="form-control form-control-sm" id="keadaan" name="keadaan">
                                        <option value="Sehat">Sehat</option>
                                        <option value="Sakit Ringan">Sakit Ringan</option>
                                        <option value="Sakit Sedang">Sakit Sedang</option>
                                        <option value="Sakit Berat">Sakit Berat</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="kesadaran">Kesadaran:</label>
                                    <select class="form-control form-control-sm" id="kesadaran" name="kesadaran">
                                        <option value="Compos Mentis">Compos Mentis</option>
                                        <option value="Apatis">Apatis</option>
                                        <option value="Somnolen">Somnolen</option>
                                        <option value="Sopor">Sopor</option>
                                        <option value="Koma">Koma</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gcs">GCS(E,V,M):</label>
                                    <input type="text" class="form-control form-control-sm" id="gcs" name="gcs">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="td">TD (mmHg):</label>
                                    <input type="text" class="form-control form-control-sm" id="td" name="td">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-3">
                                    <label for="spo">SpO2 (%):</label>
                                    <input type="text" class="form-control form-control-sm" id="spo" name="spo">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="bb">BB (Kg):</label>
                                    <input type="text" class="form-control form-control-sm" id="bb" name="bb">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tb">TB (cm):</label>
                                    <input type="text" class="form-control form-control-sm" id="tb" name="tb">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="kepala">Kepala:</label>
                                    <select class="form-control form-control-sm" id="kepala" name="kepala">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="mata">Mata:</label>
                                    <select class="form-control form-control-sm" id="mata" name="mata">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="gigi">Gigi & Mulut:</label>
                                    <select class="form-control form-control-sm" id="gigi" name="gigi">
                                        <option value="Normal">Normal</option>
                                        <option value="Abnormal">Abnormal</option>
                                        <option value="Tidak Diperiksa">Tidak Diperiksa</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tht">THT:</label>
                                    <select class="form-control form-control-sm" id="tht" name="tht">
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
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="genital">Genital & Anus:</label>
                                    <select class="form-control form-control-sm" id="genital" name="genital">
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
                                <div class="form-group col-md-3">
                                    <label for="kulit">Kulit:</label>
                                    <select class="form-control form-control-sm" id="kulit" name="kulit">
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
                                    <label for="ket_fisik">Keterangan Fisik:</label>
                                    <textarea class="form-control form-control-sm" id="ket_fisik" name="ket_fisik" rows="12"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5>III. STATUS LOKALIS</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <canvas id="lokalisCanvas" width="500" height="400"></canvas>
                            <img id="lokalisImage" src="<?php echo base_url('assets/gambar/medisdokter/gambarmedisanak.PNG'); ?>" style="display: none;" />
                            <!-- Tambahkan tombol Simpan dan Batal di bawah canvas -->
                            <button type="button" class="btn btn-success mt-2" onclick="saveLokalis()">Simpan Lokalis</button>
                            <button type="button" class="btn btn-danger mt-2" onclick="resetLokalis()">Batal Lokalis</button>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ket_lokalis">Keterangan:</label>
                            <textarea class="form-control form-control-sm" id="ket_lokalis" name="ket_lokalis" rows="8"></textarea>
                        </div>
                    </div>



                    <h5>IV. PEMERIKSAAN PENUNJANG</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea class="form-control form-control-sm" id="penunjang" name="penunjang" rows="3"></textarea>
                        </div>
                    </div>

                    <h5>V. DIAGNOSIS/ASESMEN</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea class="form-control form-control-sm" id="diagnosis" name="diagnosis" rows="3"></textarea>
                        </div>
                    </div>

                    <h5>VI. TATALAKSANA</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea class="form-control form-control-sm" id="tata" name="tata" rows="3"></textarea>
                        </div>
                    </div>

                    <h5>VII. KONSUL/RUJUK</h5>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea class="form-control form-control-sm" id="konsul" name="konsul" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                        <button type="submit" class="btn btn-warning btn-md" id="updateButton" style="display:none;" onclick="updateAsesmenMedisAnak(event);">Update</button>
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

<script src="<?php echo base_url('assets/js/medisDokter/medisAnak.js'); ?>"></script>

<!-- Form untuk input asesmen medis mata -->
<form id="asesmenMedisMataForm">
    <input type="hidden" name="no_rawat" value="<?= $no_rawat; ?>">
    
    <!-- Bagian Informasi Pasien -->
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="no_rawat">No. Rawat:</label>
            <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="<?= $no_rawat; ?>" readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="kd_dokter">Dokter:</label>
            <input type="text" class="form-control" id="kd_dokter" name="kd_dokter" required>
        </div>
        <div class="form-group col-md-3">
            <label for="tanggal_jam">Tanggal:</label>
            <input type="datetime-local" class="form-control" id="tanggal_jam" name="tanggal_jam" required>
        </div>
        <div class="form-group col-md-3">
            <label for="anamnesis">Anamnesis:</label>
            <select class="form-control" id="anamnesis" name="anamnesis">
                <option value="Autoanamnesis">Autoanamnesis</option>
                <option value="Alloanamnesis">Alloanamnesis</option>
            </select>
        </div>
    </div>

    <!-- Bagian I: Riwayat Kesehatan -->
    <h5>I. Riwayat Kesehatan</h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="keluhan_utama">Keluhan Utama:</label>
            <textarea class="form-control" id="keluhan_utama" name="keluhan_utama"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="riwayat_penyakit_sekarang">Riwayat Penyakit Sekarang:</label>
            <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="riwayat_penyakit_dahulu">Riwayat Penyakit Dahulu:</label>
            <textarea class="form-control" id="riwayat_penyakit_dahulu" name="riwayat_penyakit_dahulu"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="riwayat_alergi">Riwayat Alergi:</label>
            <textarea class="form-control" id="riwayat_alergi" name="riwayat_alergi"></textarea>
        </div>
    </div>

    <!-- Bagian II: Pemeriksaan Fisik -->
    <h5>II. Pemeriksaan Fisik</h5>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="td">TD:</label>
            <input type="text" class="form-control" id="td" name="td">
        </div>
        <div class="form-group col-md-3">
            <label for="bb">BB:</label>
            <input type="text" class="form-control" id="bb" name="bb">
        </div>
        <div class="form-group col-md-3">
            <label for="tb">TB:</label>
            <input type="text" class="form-control" id="tb" name="tb">
        </div>
        <div class="form-group col-md-3">
            <label for="suhu">Suhu:</label>
            <input type="text" class="form-control" id="suhu" name="suhu">
        </div>
        <div class="form-group col-md-3">
            <label for="nadi">Nadi:</label>
            <input type="text" class="form-control" id="nadi" name="nadi">
        </div>
        <div class="form-group col-md-3">
            <label for="rr">RR:</label>
            <input type="text" class="form-control" id="rr" name="rr">
        </div>
        <div class="form-group col-md-3">
            <label for="status_nutrisi">Status Nutrisi:</label>
            <input type="text" class="form-control" id="status_nutrisi" name="status_nutrisi">
        </div>
        <div class="form-group col-md-3">
            <label for="nyeri">Nyeri:</label>
            <input type="text" class="form-control" id="nyeri" name="nyeri">
        </div>
    </div>

    <!-- Bagian III: Status Oftamologis -->
    <h5>III. Status Oftamologis</h5>
    <div class="row">
        <div class="col-md-6">
            <label>OD: Mata Kanan</label>
            <div class="form-group">
                <img src="<?= base_url('assets/gambar/medisdokter/gambarmedismatakanan.PNG'); ?>" alt="Mata Kanan" class="img-fluid">
            </div>
        </div>
        <div class="col-md-6">
            <label>OS: Mata Kiri</label>
            <div class="form-group">
                <img src="<?= base_url('assets/gambar/medisdokter/gambarmedismatakiri.PNG'); ?>" alt="Mata Kiri" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="visuskanan">Visus SC OD:</label>
            <input type="text" class="form-control" id="visuskanan" name="visuskanan">
        </div>
        <div class="form-group col-md-6">
            <label for="visuskiri">Visus SC OS:</label>
            <input type="text" class="form-control" id="visuskiri" name="visuskiri">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="coa">COA:</label>
            <input type="text" class="form-control" id="coa" name="coa">
        </div>
        <div class="form-group col-md-6">
            <label for="pupil">Pupil:</label>
            <input type="text" class="form-control" id="pupil" name="pupil">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="lensa">Lensa:</label>
            <input type="text" class="form-control" id="lensa" name="lensa">
        </div>
        <div class="form-group col-md-6">
            <label for="fundus_media">Fundus Media:</label>
            <input type="text" class="form-control" id="fundus_media" name="fundus_media">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="papil">Papil:</label>
            <input type="text" class="form-control" id="papil" name="papil">
        </div>
        <div class="form-group col-md-6">
            <label for="retina">Retina:</label>
            <input type="text" class="form-control" id="retina" name="retina">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="makula">Makula:</label>
            <input type="text" class="form-control" id="makula" name="makula">
        </div>
        <div class="form-group col-md-6">
            <label for="tio">TIO:</label>
            <input type="text" class="form-control" id="tio" name="tio">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="mbo">MBO:</label>
            <input type="text" class="form-control" id="mbo" name="mbo">
        </div>
    </div>

    <!-- Bagian IV: Pemeriksaan Penunjang -->
    <h5>IV. Pemeriksaan Penunjang</h5>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="laboratorium">Laboratorium:</label>
            <textarea class="form-control" id="laboratorium" name="laboratorium"></textarea>
        </div>
        <div class="form-group col-md-4">
            <label for="radiologi">Radiologi:</label>
            <textarea class="form-control" id="radiologi" name="radiologi"></textarea>
        </div>
        <div class="form-group col-md-4">
            <label for="penunjang_lainnya">Penunjang Lainnya:</label>
            <textarea class="form-control" id="penunjang_lainnya" name="penunjang_lainnya"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="tes_penglihatan">Tes Penglihatan:</label>
        <textarea class="form-control" id="tes_penglihatan" name="tes_penglihatan"></textarea>
    </div>

    <!-- Bagian V: Diagnosis/Asesmen -->
    <h5>V. Diagnosis/Asesmen</h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="asesmen_kerja">Asesmen Kerja:</label>
            <textarea class="form-control" id="asesmen_kerja" name="asesmen_kerja"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="asesmen_banding">Asesmen Banding:</label>
            <textarea class="form-control" id="asesmen_banding" name="asesmen_banding"></textarea>
        </div>
    </div>

    <!-- Bagian VI: Permasalahan & Tatalaksana -->
    <h5>VI. Permasalahan & Tatalaksana</h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="permasalahan">Permasalahan:</label>
            <textarea class="form-control" id="permasalahan" name="permasalahan"></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="terapi">Terapi/Pengobatan:</label>
            <textarea class="form-control" id="terapi" name="terapi"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="tindakan_rencana">Tindakan/Rencana Tindakan:</label>
        <textarea class="form-control" id="tindakan_rencana" name="tindakan_rencana"></textarea>
    </div>

    <!-- Bagian VII: Edukasi -->
    <h5>VII. Edukasi</h5>
    <div class="form-group">
        <label for="edukasi">Edukasi:</label>
        <textarea class="form-control" id="edukasi" name="edukasi"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

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

    <script>
$(document).ready(function(){
    // Set tanggal default ke tanggal hari ini
    var today = new Date().toISOString().split('T')[0];
    $('#tanggal').val(today);
});
</script>

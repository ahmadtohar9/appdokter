<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                Informasi Pasien
            </div>
            <div class="card-body">
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
                    <form id="soapForm" action="<?php echo site_url('DokterController/save_soap'); ?>" method="post">
                        <input type="hidden" name="no_rawat" value="<?php echo $detail_pasien->no_rawat; ?>">
                        <input type="hidden" name="kd_dokter" value="<?php echo $detail_pasien->kd_dokter; ?>">
                        <input type="hidden" name="mode" value="<?php echo isset($soap_detail) ? 'edit' : 'new'; ?>">
                        <input type="hidden" name="no_rawat" value="<?php echo isset($soap_detail->no_rawat) ? $soap_detail->no_rawat : $detail_pasien->no_rawat; ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal" value="<?php echo isset($soap_data->tgl_perawatan) ? $soap_data->tgl_perawatan : date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jam">Jam</label>
                                <input type="time" class="form-control form-control-sm" id="jam" name="jam" value="<?php echo isset($soap_data->jam_rawat) ? date('H:i:s', strtotime($soap_data->jam_rawat)) : date('H:i:s'); ?>" step="1">

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="suhu_tubuh">Suhu Tubuh</label>
                                <input type="text" class="form-control form-control-sm" id="suhu_tubuh" name="suhu_tubuh" value="<?php echo isset($soap_detail->suhu_tubuh) ? $soap_detail->suhu_tubuh : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="tensi">Tensi</label>
                                <input type="text" class="form-control form-control-sm" id="tensi" name="tensi" value="<?php echo isset($soap_detail->tensi) ? $soap_detail->tensi : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="nadi">Nadi</label>
                                <input type="text" class="form-control form-control-sm" id="nadi" name="nadi" value="<?php echo isset($soap_detail->nadi) ? $soap_detail->nadi : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="respirasi">Respirasi</label>
                                <input type="text" class="form-control form-control-sm" id="respirasi" name="respirasi" value="<?php echo isset($soap_detail->respirasi) ? $soap_detail->respirasi : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="tinggi">Tinggi</label>
                                <input type="text" class="form-control form-control-sm" id="tinggi" name="tinggi" value="<?php echo isset($soap_detail->tinggi) ? $soap_detail->tinggi : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="berat">Berat</label>
                                <input type="text" class="form-control form-control-sm" id="berat" name="berat" value="<?php echo isset($soap_detail->berat) ? $soap_detail->berat : ''; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="spo2">SPO2</label>
                                <input type="text" class="form-control form-control-sm" id="spo2" name="spo2" value="<?php echo isset($soap_detail->spo2) ? $soap_detail->spo2 : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="gcs">GCS</label>
                                <input type="text" class="form-control form-control-sm" id="gcs" name="gcs" value="<?php echo isset($soap_detail->gcs) ? $soap_detail->gcs : ''; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                 <div class="form-group">
                                    <label for="lingkar_perut">Lingkar Perut</label>
                                    <input type="text" class="form-control form-control-sm" id="lingkar_perut" name="lingkar_perut" value="<?php echo isset($soap_detail->lingkar_perut) ? $soap_detail->lingkar_perut : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-group">
                                    <label for="alergi">Alergi</label>
                                    <input type="text" class="form-control form-control-sm" id="alergi" name="alergi" value="<?php echo isset($soap_detail->alergi) ? $soap_detail->alergi : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="kesadaran">Kesadaran</label>
                                <select class="form-control form-control-sm" id="kesadaran" name="kesadaran">
                                    <option value="Compos Mentis" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Compos Mentis' ? 'selected' : ''; ?>>Compos Mentis</option>
                                    <option value="Somnolence" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Somnolence' ? 'selected' : ''; ?>>Somnolence</option>
                                    <option value="Sopor" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Sopor' ? 'selected' : ''; ?>>Sopor</option>
                                    <option value="Coma" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Coma' ? 'selected' : ''; ?>>Coma</option>
                                    <option value="Alert" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Alert' ? 'selected' : ''; ?>>Alert</option>
                                    <option value="Confusion" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Confusion' ? 'selected' : ''; ?>>Confusion</option>
                                    <option value="Voice" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Voice' ? 'selected' : ''; ?>>Voice</option>
                                    <option value="Pain" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Pain' ? 'selected' : ''; ?>>Pain</option>
                                    <option value="Unresponsive" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Unresponsive' ? 'selected' : ''; ?>>Unresponsive</option>
                                    <option value="Apatis" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Apatis' ? 'selected' : ''; ?>>Apatis</option>
                                    <option value="Delirium" <?php echo isset($soap_detail->kesadaran) && $soap_detail->kesadaran == 'Delirium' ? 'selected' : ''; ?>>Delirium</option>
                                </select>
                            </div>
                        </div>
                       <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keluhan">Subjek</label>
                                    <textarea class="form-control form-control-sm" id="keluhan" name="keluhan" rows="4" cols="50"><?php echo isset($soap_detail->keluhan) ? $soap_detail->keluhan : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pemeriksaan">Objek</label>
                                    <textarea class="form-control form-control-sm" id="pemeriksaan" name="pemeriksaan" rows="4" cols="50"><?php echo isset($soap_detail->pemeriksaan) ? $soap_detail->pemeriksaan : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penilaian">Penilaian</label>
                                    <textarea class="form-control form-control-sm" id="penilaian" name="penilaian" rows="4" cols="50"><?php echo isset($soap_detail->penilaian) ? $soap_detail->penilaian : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rtl">RTL</label>
                                    <textarea class="form-control form-control-sm" id="rtl" name="rtl" rows="4" cols="50"><?php echo isset($soap_detail->rtl) ? $soap_detail->rtl : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instruksi">Instruksi</label>
                                    <textarea class="form-control form-control-sm" id="instruksi" name="instruksi" rows="4" cols="50"><?php echo isset($soap_detail->instruksi) ? $soap_detail->instruksi : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="evaluasi">Evaluasi</label>
                                    <textarea class="form-control form-control-sm" id="evaluasi" name="evaluasi" rows="4" cols="50"><?php echo isset($soap_detail->evaluasi) ? $soap_detail->evaluasi : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Add the rest of the form fields here -->
                        <button type="submit" class="btn btn-primary btn-md">Save</button>
                    </form>
            </div>
        </div>
    </div>
            
        
</div>
</br>
</br>

 <div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Perawatan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="small-col">No</th>
                                <th width="100px">Tanggal</th>
                                <th>SOAP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($soap_data_list)): ?>
                                <tr><td colspan="3">Data belum ada.</td></tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($soap_data_list as $data): ?>
                                    <tr>
                                        <td class="small-col"><?php echo $no++; ?></td>
                                        <td>
                                            <b>Rawat Jalan</b><br>
                                            <?php echo isset($data->tgl_perawatan) ? $data->tgl_perawatan . ' ' . $data->jam_rawat : 'N/A'; ?><br>
                                            <b>PEMERIKSA</b><br>
                                            <?php echo isset($data->nik) ? $data->nik . ' ' . $data->nama : 'N/A'; ?><br>
                                            <span>RAWAT JALAN</span><br>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteSOAP('<?php echo $data->no_rawat; ?>', '<?php echo $data->nik; ?>')">Hapus</button>
                                            <!-- <a href="<?php echo site_url('DokterController/delete_soap/' . str_replace('/', '/', $data->no_rawat)); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a> -->
                                        </td>
                                        <td>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <td>Suhu: <?php echo isset($data->suhu_tubuh) ? $data->suhu_tubuh : 'N/A'; ?></td>
                                                    <td>Tensi: <?php echo isset($data->tensi) ? $data->tensi : 'N/A'; ?></td>
                                                    <td>Nadi: <?php echo isset($data->nadi) ? $data->nadi : 'N/A'; ?></td>
                                                    <td>Respirasi: <?php echo isset($data->respirasi) ? $data->respirasi : 'N/A'; ?></td>
                                                    <td>Tinggi: <?php echo isset($data->tinggi) ? $data->tinggi . ' Cm' : 'N/A'; ?></td>
                                                    <td>Berat: <?php echo isset($data->berat) ? $data->berat . ' Kg' : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>SpO2: <?php echo isset($data->spo2) ? $data->spo2 : 'N/A'; ?></td>
                                                    <td>Gcs: <?php echo isset($data->gcs) ? $data->gcs : 'N/A'; ?></td>
                                                    <td>Kesadaran: <?php echo isset($data->kesadaran) ? $data->kesadaran : 'N/A'; ?></td>
                                                    <td>Alergi: <?php echo isset($data->alergi) ? $data->alergi : 'N/A'; ?></td>
                                                    <td>Lingkar Perut: <?php echo isset($data->lingkar_perut) ? $data->lingkar_perut : 'N/A'; ?></td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <td width="150px"><b>Subyektif:</b></td>
                                                    <td><?php echo isset($data->keluhan) ? $data->keluhan : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Obyektif:</b></td>
                                                    <td><?php echo isset($data->pemeriksaan) ? $data->pemeriksaan : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Assesment:</b></td>
                                                    <td><?php echo isset($data->rtl) ? $data->rtl : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Plan:</b></td>
                                                    <td><?php echo isset($data->penilaian) ? $data->penilaian : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Instruksi:</b></td>
                                                    <td><?php echo isset($data->instruksi) ? $data->instruksi : 'N/A'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Evaluasi:</b></td>
                                                    <td><?php echo isset($data->evaluasi) ? $data->evaluasi : 'N/A'; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <style>
                    .table-responsive {
                        overflow-x: auto;
                    }
                    .table thead th {
                        text-align: center;
                    }
                    .table tbody td {
                        vertical-align: middle;
                    }
                    .small-col {
                        width: 50px;
                    }
                    .table td table {
                        width: 100%;
                    }
                    .table td table td {
                        border: none;
                        padding: 0.5rem;
                    }
                </style>
            </div>
        </div>


        <div class="card shadow mb-4">
             <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Diagnosa</h6>
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#diagnosaModal">
                    Tambah Diagnosa
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="diagnosaTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Penyakit</th>
                                <th>Nama Penyakit</th>
                                <th>Status Penyakit</th>
                                <th>Prioritas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Diagnosa -->
<div class="modal fade" id="diagnosaModal" tabindex="-1" role="dialog" aria-labelledby="diagnosaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="diagnosaModalLabel">Tambah Diagnosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form id="diagnosaForm" class="user">
                    <div class="form-group">
                        <label for="kd_penyakit">Penyakit</label>
                        <input type="text" class="form-control form-control-sm" id="kd_penyakit" name="kd_penyakit">
                    </div>
                    <div class="form-group">
                         <label for="prioritas">Prioritas</label>
                        <select class="form-control form-control-sm" id="prioritas" name="prioritas">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitDiagnosa()">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Resep -->
<div class="modal fade" id="resumeModal" tabindex="-1" role="dialog" aria-labelledby="resumeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resumeModalLabel">Resume Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                placeholder="First Name">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="exampleLastName"
                                placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                            placeholder="Email Address">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Password">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user"
                                id="exampleRepeatPassword" placeholder="Repeat Password">
                        </div>
                    </div>
                </form>
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
<script src="<?php echo base_url('assets/js/resep.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/diagnosa.js'); ?>"></script>


<script>
    // Submit SOAP Form
    $('#soapForm').submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        var formData = $(this).serialize(); // Mengambil data dari form

        $.ajax({
            url: "<?php echo site_url('DokterController/save_soap'); ?>",
            method: "POST",
            data: formData,
            success: function(response) {
                console.log("SOAP form submitted successfully:", response);  // Debugging log
                try {
                    var res = JSON.parse(response);
                    var messageHtml = '';

                    if (res.status === 'success') {
                        messageHtml = '<div class="alert alert-success" role="alert">' + res.message + '</div>';
                        updateRiwayatPerawatan(); // Perbarui tampilan riwayat perawatan
                    } else {
                        messageHtml = '<div class="alert alert-danger" role="alert">' + res.message + '</div>';
                    }

                    $('#flash-message').html(messageHtml);

                    setTimeout(function() {
                        $('#flash-message').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000);
                } catch (error) {
                    console.error('Error parsing response JSON:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error during SOAP form submission:', textStatus, errorThrown);  // Debugging log
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    });

    function updateRiwayatPerawatan() {
        var noRawat = $('[name="no_rawat"]').val();
        $.ajax({
            url: "<?php echo site_url('DokterController/get_soap_data'); ?>",
            method: "GET",
            data: { no_rawat: noRawat },
            success: function(data) {
                console.log("SOAP data fetched successfully:", data);  // Debugging log
                try {
                    var soapDataList = JSON.parse(data);
                    var tableBody = '';
                    soapDataList.forEach(function(item, index) {
                        tableBody += '<tr>';
                        tableBody += '<td class="small-col">' + (index + 1) + '</td>';
                        tableBody += '<td><b>Rawat Jalan</b><br>' + (item.tgl_perawatan || 'N/A') + ' ' + (item.jam_rawat || 'N/A') + '<br><b>PEMERIKSA</b><br>' + (item.nik || 'N/A') + ' ' + (item.nama || 'N/A') + '<br><span>RAWAT JALAN</span><br>';
                        tableBody += '<button type="button" class="btn btn-danger btn-sm" onclick="deleteSOAP(\'' + item.no_rawat + '\', \'' + item.nik + '\')">Hapus</button></td>';
                        tableBody += '<td><table class="table table-bordered" width="100%" cellspacing="0"><tr>';
                        tableBody += '<td>Suhu: ' + (item.suhu_tubuh || 'N/A') + '</td>';
                        tableBody += '<td>Tensi: ' + (item.tensi || 'N/A') + '</td>';
                        tableBody += '<td>Nadi: ' + (item.nadi || 'N/A') + '</td>';
                        tableBody += '<td>Respirasi: ' + (item.respirasi || 'N/A') + '</td>';
                        tableBody += '<td>Tinggi: ' + (item.tinggi ? item.tinggi + ' Cm' : 'N/A') + '</td>';
                        tableBody += '<td>Berat: ' + (item.berat ? item.berat + ' Kg' : 'N/A') + '</td>';
                        tableBody += '</tr><tr>';
                        tableBody += '<td>SpO2: ' + (item.spo2 || 'N/A') + '</td>';
                        tableBody += '<td>Gcs: ' + (item.gcs || 'N/A') + '</td>';
                        tableBody += '<td>Kesadaran: ' + (item.kesadaran || 'N/A') + '</td>';
                        tableBody += '<td>Alergi: ' + (item.alergi || 'N/A') + '</td>';
                        tableBody += '<td>Lingkar Perut: ' + (item.lingkar_perut || 'N/A') + '</td>';
                        tableBody += '</tr></table><table class="table table-bordered" width="100%" cellspacing="0"><tr>';
                        tableBody += '<td width="150px"><b>Subyektif:</b></td>';
                        tableBody += '<td>' + (item.keluhan || 'N/A') + '</td></tr><tr>';
                        tableBody += '<td><b>Obyektif:</b></td>';
                        tableBody += '<td>' + (item.pemeriksaan || 'N/A') + '</td></tr><tr>';
                        tableBody += '<td><b>Assesment:</b></td>';
                        tableBody += '<td>' + (item.rtl || 'N/A') + '</td></tr><tr>';
                        tableBody += '<td><b>Plan:</b></td>';
                        tableBody += '<td>' + (item.penilaian || 'N/A') + '</td></tr><tr>';
                        tableBody += '<td><b>Instruksi:</b></td>';
                        tableBody += '<td>' + (item.instruksi || 'N/A') + '</td></tr><tr>';
                        tableBody += '<td><b>Evaluasi:</b></td>';
                        tableBody += '<td>' + (item.evaluasi || 'N/A') + '</td></tr></table></td>';
                        tableBody += '</tr>';
                    });
                    $('#dataTable tbody').html(tableBody);
                } catch (error) {
                    console.error('Error parsing SOAP data:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching SOAP data:', textStatus, errorThrown);  // Debugging log
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }

    function deleteSOAP(no_rawat, nik) {
        if (confirm('Apakah Anda yakin ingin menghapus SOAP ini?')) {
            $.ajax({
                url: "<?php echo site_url('DokterController/delete_soap'); ?>",
                method: "POST",
                data: {
                    no_rawat: no_rawat,
                    nip: nik
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('SOAP berhasil dihapus');
                        updateRiwayatPerawatan();  // Memperbarui data SOAP setelah penghapusan
                        clearSOAPForm();  // Mengosongkan form SOAP setelah penghapusan
                    } else {
                        alert('Gagal menghapus SOAP: ' + res.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error deleting SOAP:', textStatus, errorThrown);  // Debugging log
                    alert('Terjadi kesalahan: ' + textStatus);
                }
            });
        }
    }

    function clearSOAPForm() {
    $('#soapForm').find('input:text, input[type=date], input[type=time], textarea').val('');
    $('#soapForm').find('select').prop('selectedIndex', 0);
    // Tambahkan kembali nilai `no_rawat` dan `mode`
    $('#soapForm').find('input[name="no_rawat"]').val('<?php echo isset($detail_pasien->no_rawat) ? $detail_pasien->no_rawat : ""; ?>');
    $('#soapForm').find('input[name="mode"]').val('new'); // Atur mode menjadi 'new' jika SOAP dihapus
    $('#soapForm').find('#jam').val('<?php echo date('H:i:s'); ?>'); // Set default value for time
    $('#soapForm').find('#tanggal').val('<?php echo date('Y-m-d'); ?>'); // Set default value for date

}



    $(document).ready(function() {
        loadDiagnosaData();
        $('#diagnosaModal').on('hidden.bs.modal', function () {
            loadDiagnosaData();
        });
    });
</script>





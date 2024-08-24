<div class="row">
    <!-- Content Row -->
    <div class="card bg-success text-white mb-2" style="padding: 2px;">
        <div class="card-body p-2">
            <p class="mb-4">
                HALO...SELAMAT DATANG DI APLIKASI ELEKTRONIK MEDICAL RECORD 
                <a target="_blank" href="https://datatables.net" style="font-size: 16px; color: white; font-weight: bold;">
                    <?php echo strtoupper($this->session->userdata('nama_dokter')); ?>
                </a>.
            </p>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-12">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pasien Rawat Jalan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No Rawat</th>
                            <th>No Rekam Medis</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>NoReg</th>
                            <th>Poliklinik</th>
                            <th>Asuransi</th>
                            <th>Status</th>
                            <th>Usia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reg_periksa as $row) : ?>
                            <tr>
                                <td><?php echo $row->no_rawat; ?></td>
                                <td><?php echo $row->no_rkm_medis; ?></td>
                                <td><?php echo $row->nm_pasien; ?></td>
                                <td><?php echo $row->nm_dokter; ?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo htmlspecialchars($row->no_reg, ENT_QUOTES, 'UTF-8'); ?></span>
                                </td>
                                <td><?php echo $row->nm_poli; ?></td>
                                <td><?php echo $row->png_jawab; ?></td>
                                <td>
                                    <span class="badge <?php echo $row->stts == 'Sudah' ? 'badge-success' : 'badge-secondary'; ?>">
                                        <?php echo $row->stts; ?>
                                    </span>
                                </td>
                                <td><?php echo $row->umurdaftar . ' ' . $row->sttsumur; ?></td>
                                <td>
                                    <select class="form-control" onchange="navigateToForm(this.value, '<?php echo $row->no_rawat; ?>')">
                                        <option value="">Pilih</option>
                                        <?php foreach ($dropdown_options as $option) : ?>
                                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function navigateToForm(option, noRawat) 
    {
        var baseUrlDokter = "<?php echo site_url('DokterController/'); ?>";
        var baseUrlMedisDalam = "<?php echo site_url('MedisDalamController/'); ?>";
        var baseUrlMedisKandungan = "<?php echo site_url('MedisKandunganController/'); ?>";
        var baseUrlMedisAnak = "<?php echo site_url('MedisAnakController/'); ?>";
        
        switch(option) {
            case 'Assesment Penyakit Dalam':
                window.location.href = baseUrlMedisDalam + "AsesmentDokter_form/" + noRawat;
                break;
            case 'Assesment Kebidanan':
                window.location.href = baseUrlMedisKandungan + "MedisKandungan_form/" + noRawat;
                break;
            case 'Assesment Anak':
                window.location.href = baseUrlMedisAnak + "MedisAnak_form/" + noRawat;
                break;
            case 'Pelayanan Rawat Jalan':
                window.location.href = baseUrlDokter + "dokterRajal_form/" + noRawat;
                break;
            case 'Diagnosa & Prosedur':
                window.location.href = baseUrlDokter + "diagnosaProsedur_form/" + noRawat;
                break;
            case 'Permintaan Laboratorium':
                window.location.href = baseUrlDokter + "permintaanLaboratorium_form/" + noRawat;
                break;
            case 'Permintaan Radiologi':
                window.location.href = baseUrlDokter + "permintaanRadiologi_form/" + noRawat;
                break;
            default:
                alert("Maaf, Menu Belum Tersedia.");
        }
    }


    $(document).ready(function(){
        function fetchNewData() {
            $.ajax({
                url: "<?php echo site_url('DokterController/get_new_data'); ?>",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = '';
                    data.forEach(function(row) {
                        rows += '<tr>';
                        rows += '<td>' + row.no_rawat + '</td>';
                        rows += '<td>' + row.no_rkm_medis + '</td>';
                        rows += '<td>' + row.nm_pasien + '</td>';
                        rows += '<td>' + row.nm_dokter + '</td>';
                        rows += '<td><span class="badge badge-primary">' + row.no_reg + '</span></td>';
                        rows += '<td>' + row.nm_poli + '</td>';
                        rows += '<td>' + row.png_jawab + '</td>';
                        rows += '<td><span class="badge ' + (row.stts == 'Sudah' ? 'badge-success' : 'badge-secondary') + '">' + row.stts + '</span></td>';
                        rows += '<td>' + row.umurdaftar + ' ' + row.sttsumur + '</td>';
                        rows += '<td>';
                        rows += '<select class="form-control" onchange="navigateToForm(this.value, \'' + row.no_rawat + '\')">';
                        rows += '<option value="">Pilih</option>';
                        <?php foreach ($dropdown_options as $option) : ?>
                            rows += '<option value="<?php echo $option; ?>"><?php echo $option; ?></option>';
                        <?php endforeach; ?>
                        rows += '</select>';
                        rows += '</td>';
                        rows += '</tr>';
                    });
                    $('#dataTable tbody').html(rows);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching new data: ' + textStatus);
                }
            });
        }

        // Panggil fetchNewData setiap 5 detik
        setInterval(fetchNewData, 5000);
    });
</script>

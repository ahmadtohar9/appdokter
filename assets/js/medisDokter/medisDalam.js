$(document).ready(function(){
    loadAsesmenData();
});

// Fungsi untuk menambahkan atau memperbarui asesmen
function submitAsesmen(event) {
    event.preventDefault(); // Mencegah default form submit behavior

    var formData = $('#asesmenForm').serialize();

    $.ajax({
        url: base_url + "MedisDalamController/save_asesmen",
        method: "POST",
        data: formData,
        success: function(response) {
            try {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#asesmenForm')[0].reset(); // Reset form setelah berhasil menyimpan data
                    loadAsesmenData(); // Muat ulang data asesmen
                    resetForm(); // Kembali ke mode tambah data setelah update atau tambah
                } else {
                    // Tampilkan pesan error
                    $('#error_message').text('Gagal menyimpan asesmen: ' + res.message).show();
                }
            } catch (error) {
                console.error('Error parsing response:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Terjadi kesalahan: ' + textStatus);
        }
    });
}

// Objek global untuk menyimpan data asesmen
var asesmenData = {};

function loadAsesmenData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + "MedisDalamController/get_asesmen_data",
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var asesmenList = JSON.parse(data);
                var tableBody = '';

                // Reset asesmenData setiap kali data baru dimuat
                asesmenData = {};

                if (Array.isArray(asesmenList) && asesmenList.length > 0) {
                    asesmenList.forEach(function(asesmen, index) {
                        // Simpan data asesmen di asesmenData
                        asesmenData[asesmen.no_rawat] = asesmen;

                        tableBody += '<tr>';
                        tableBody += '<td style="width: 30px; text-align: center;">' + (index + 1) + '</td>';
                        tableBody += '<td style="width: 200px; vertical-align: top;">';
                        if (asesmen.no_rawat) tableBody += '<b style="color: maroon;">No. Rawat:</b><br> <span style="color: black;">' + asesmen.no_rawat + '</span><br>';
                        if (asesmen.nm_dokter) tableBody += '<b style="color: maroon;">Dokter:</b><br> <span style="color: black;">' + asesmen.nm_dokter + '</span><br>';
                        if (asesmen.tanggal) tableBody += '<b style="color: maroon;">Tanggal Perawatan:</b><br> <span style="color: black;">' + asesmen.tanggal + '</span><br>';
                        tableBody += '</td>';

                        tableBody += '<td>';
                        tableBody += '<table class="table table-sm table-bordered" width="100%" cellspacing="0">';

                        if (asesmen.keluhan_utama) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Keluhan Utama :</b><br/> <span style="color: black;">' + asesmen.keluhan_utama + '</span></td></tr>';
                        if (asesmen.rpo) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Riwayat Penggunaan Obat :</b><br/> <span style="color: black;">' + asesmen.rpo + '</span></td></tr>';
                        if (asesmen.rps) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Riwayat Penyakit Sekarang :</b><br/> <span style="color: black;">' + asesmen.rps + '</span></td></tr>';
                        if (asesmen.rpd) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Riwayat Penyakit Dahulu :</b><br/> <span style="color: black;">' + asesmen.rpd + '</span></td></tr>';
                        if (asesmen.alergi) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Alergi :</b><br/> <span style="color: black;">' + asesmen.alergi + '</span></td></tr>';

                        tableBody += '<tr>';
                        if (asesmen.status) tableBody += '<td colspan="3"><b style="color: maroon;">Status Nutrisi:</b> <span style="color: black;">' + asesmen.status + '</span></td>';
                        if (asesmen.td) tableBody += '<td colspan="3"><b style="color: maroon;">TD:</b> <span style="color: black;">' + asesmen.td + '</span></td>';
                        if (asesmen.nadi) tableBody += '<td colspan="3"><b style="color: maroon;">Nadi:</b> <span style="color: black;">' + asesmen.nadi + '</span></td>';
                        if (asesmen.suhu) tableBody += '<td colspan="3"><b style="color: maroon;">Suhu:</b> <span style="color: black;">' + asesmen.suhu + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.rr) tableBody += '<td colspan="3"><b style="color: maroon;">RR:</b> <span style="color: black;">' + asesmen.rr + '</span></td>';
                        if (asesmen.bb) tableBody += '<td colspan="3"><b style="color: maroon;">BB:</b> <span style="color: black;">' + asesmen.bb + '</span></td>';
                        if (asesmen.nyeri) tableBody += '<td colspan="3"><b style="color: maroon;">Nyeri:</b> <span style="color: black;">' + asesmen.nyeri + '</span></td>';
                        if (asesmen.gcs) tableBody += '<td colspan="3"><b style="color: maroon;">GCS:</b> <span style="color: black;">' + asesmen.gcs + '</span></td>';
                        tableBody += '</tr>';
                        
                        if (asesmen.kondisi) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Kondisi Umum:</b><br/> <span style="color: black;">' + asesmen.kondisi + '</span></td></tr>';

                        tableBody += '<tr>';
                        if (asesmen.kepala) tableBody += '<td colspan="3"><b style="color: maroon;">Kepala:</b><br/> <span style="color: black;">' + asesmen.kepala + '</span></td>';
                        if (asesmen.keterangan_kepala) tableBody += '<td colspan="3"><b style="color: maroon;">Keterangan Kepala:</b><br/> <span style="color: black;">' + asesmen.keterangan_kepala + '</span></td>';
                        if (asesmen.thoraks) tableBody += '<td colspan="3"><b style="color: maroon;">Thoraks:</b><br/> <span style="color: black;">' + asesmen.thoraks + '</span></td>';
                        if (asesmen.keterangan_thorak) tableBody += '<td colspan="3"><b style="color: maroon;">Keterangan Thorak:</b><br/> <span style="color: black;">' + asesmen.keterangan_thorak + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.abdomen) tableBody += '<td colspan="3"><b style="color: maroon;">Abdomen:</b><br/> <span style="color: black;">' + asesmen.abdomen + '</span></td>';
                        if (asesmen.keterangan_abdomen) tableBody += '<td colspan="3"><b style="color: maroon;">Keterangan Abdomen:</b><br/> <span style="color: black;">' + asesmen.keterangan_abdomen + '</span></td>';
                        if (asesmen.ekstremitas) tableBody += '<td colspan="3"><b style="color: maroon;">Ekstremitas:</b><br/> <span style="color: black;">' + asesmen.ekstremitas + '</span></td>';
                        if (asesmen.keterangan_ekstremitas) tableBody += '<td colspan="3"><b style="color: maroon;">Keterangan Ekstremitas:</b><br/> <span style="color: black;">' + asesmen.keterangan_ekstremitas + '</span></td>';
                        tableBody += '</tr>';

                        if (asesmen.lainnya) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Lainnya:</b><br/> <span style="color: black;">' + asesmen.lainnya + '</span></td></tr>';

                        tableBody += '<tr>';
                        if (asesmen.lab) tableBody += '<td colspan="4"><b style="color: maroon;">Laboratorium:</b><br> <span style="color: black;">' + asesmen.lab + '</span></td>';
                        if (asesmen.rad) tableBody += '<td colspan="4"><b style="color: maroon;">Radiologi:</b><br>  <span style="color: black;">' + asesmen.rad + '</span></td>';
                        if (asesmen.penunjanglain) tableBody += '<td colspan="4"><b style="color: maroon;">Penunjang Lainnya:</b><br>  <span style="color: black;">' + asesmen.penunjanglain + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.diagnosis) tableBody += '<td colspan="12"><b style="color: maroon;">Asesmen Kerja:</b><br/> <span style="color: black;">' + asesmen.diagnosis + '</span></td>';
                        if (asesmen.diagnosis2) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Asesmen Banding:</b><br/> <span style="color: black;">' + asesmen.diagnosis2 + '</span></td></tr>';

                        tableBody += '<tr>';
                        if (asesmen.permasalahan) tableBody += '<td colspan="6"><b style="color: maroon;">Permasalahan:</b><br/> <span style="color: black;">' + asesmen.permasalahan + '</span></td>';
                        if (asesmen.terapi) tableBody += '<td colspan="6"><b style="color: maroon;">Terapi/Pengobatan:</b><br/> <span style="color: black;">' + asesmen.terapi + '</span></td>';
                        tableBody += '</tr>';

                        if (asesmen.tindakan) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Tindakan/Rencana Tindakan:</b><br/> <span style="color: black;">' + asesmen.tindakan + '</span></td></tr>';
                        if (asesmen.edukasi) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Edukasi:</b><br/> <span style="color: black;">' + asesmen.edukasi + '</span></td></tr>';

                        // Tambah tombol Edit dan Hapus
                        tableBody += '<tr><td colspan="12">';
                        tableBody += '<button type="button" class="btn btn-warning btn-sm" onclick="editAsesmen(\'' + asesmen.no_rawat + '\')">Edit</button> ';
                        tableBody += '<button type="button" class="btn btn-danger btn-sm" onclick="deleteAsesmen(\'' + asesmen.no_rawat + '\')">Hapus</button>';
                        tableBody += '</td></tr>';

                        tableBody += '</table>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    });
                } else {
                    tableBody += '<tr><td colspan="3" class="text-center">Data masih kosong</td></tr>';
                }

                $('#asesmenTable tbody').html(tableBody);
            } catch (error) {
                console.error('Error parsing asesmen data:', error);
                $('#asesmenTable tbody').html('<tr><td colspan="3" class="text-center">Terjadi kesalahan dalam memuat data</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching asesmen data:', textStatus, errorThrown);
            $('#asesmenTable tbody').html('<tr><td colspan="3" class="text-center">Terjadi kesalahan dalam memuat data</td></tr>');
        }
    });
}

// Fungsi untuk menghapus asesmen
function deleteAsesmen(no_rawat) {
    if (confirm('Apakah Anda yakin ingin menghapus asesmen ini?')) {
        $.ajax({
            url: base_url + "MedisDalamController/delete_asesmen",
            method: "POST",
            data: { no_rawat: no_rawat },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    loadAsesmenData(); // Muat ulang data asesmen setelah penghapusan
                } else {
                    alert('Gagal menghapus asesmen: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting asesmen:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }
}

// Fungsi untuk mengedit asesmen
function editAsesmen(no_rawat) {
    // Dapatkan data asesmen berdasarkan no_rawat dari asesmenData
    var asesmen = asesmenData[no_rawat];

    if (asesmen) {
        // Isi form dengan data asesmen
        $('#no_rawat').val(asesmen.no_rawat);
        $('#kd_dokter').val(asesmen.kd_dokter);
        $('#tanggal_jam').val(asesmen.tanggal.replace(' ', 'T'));
        $('#anamnesis').val(asesmen.anamnesis);
        $('#keluhan_utama').val(asesmen.keluhan_utama);
        $('#riwayat_penggunaan_obat').val(asesmen.rpo);
        $('#riwayat_penyakit_sekarang').val(asesmen.rps);
        $('#riwayat_penyakit_dahulu').val(asesmen.rpd);
        $('#riwayat_alergi').val(asesmen.alergi);
        $('#status_nutrisi').val(asesmen.status);
        $('#td').val(asesmen.td);
        $('#nadi').val(asesmen.nadi);
        $('#suhu').val(asesmen.suhu);
        $('#rr').val(asesmen.rr);
        $('#bb').val(asesmen.bb);
        $('#nyeri').val(asesmen.nyeri);
        $('#gcs').val(asesmen.gcs);
        $('#kondisi_umum').val(asesmen.kondisi);
        $('#kepala').val(asesmen.kepala);
        $('#keterangan_kepala').val(asesmen.keterangan_kepala);
        $('#thoraks').val(asesmen.thoraks);
        $('#keterangan_thorak').val(asesmen.keterangan_thorak);
        $('#abdomen').val(asesmen.abdomen);
        $('#keterangan_abdomen').val(asesmen.keterangan_abdomen);
        $('#ekstremitas').val(asesmen.ekstremitas);
        $('#keterangan_ekstremitas').val(asesmen.keterangan_ekstremitas);
        $('#lainnya').val(asesmen.lainnya);
        $('#laboratorium').val(asesmen.lab);
        $('#radiologi').val(asesmen.rad);
        $('#penunjang_lainnya').val(asesmen.penunjanglain);
        $('#diagnosis').val(asesmen.diagnosis);
        $('#diagnosis2').val(asesmen.diagnosis2);
        $('#permasalahan').val(asesmen.permasalahan);
        $('#terapi').val(asesmen.terapi);
        $('#tindakan').val(asesmen.tindakan);
        $('#edukasi').val(asesmen.edukasi);

        // Pindahkan scroll ke form setelah data diisi
        $('#asesmenForm')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Fokus pada elemen pertama dalam form
        $('#anamnesis').focus();

        // Tampilkan tombol update dan cancel, sembunyikan tombol submit
        $('#submitBtn').hide();
        $('#updateButton').show();
        $('#cancelButton').show();
    } else {
        console.error('Data asesmen tidak ditemukan untuk no_rawat: ' + no_rawat);
    }
}

// Fungsi untuk memperbarui data asesmen
function updateAsesmen(event) {
    event.preventDefault(); // Mencegah default form submit behavior

    var formData = $('#asesmenForm').serialize();

    $.ajax({
        url: base_url + "MedisDalamController/update_asesmen",
        method: "POST",
        data: formData,
        success: function(response) {
            try {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#asesmenForm')[0].reset(); 
                    loadAsesmenData(); 
                    resetForm(); // Kembali ke mode tambah data setelah update
                } else {
                    $('#error_message').text('Gagal mengupdate asesmen: ' + res.message).show();
                }
            } catch (error) {
                console.error('Error parsing response:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Terjadi kesalahan: ' + textStatus);
        }
    });
}

function cancelEdit() {
    resetForm();
}

function resetForm() {
    $('#asesmenForm')[0].reset(); 
    $('#submitBtn').show();
    $('#updateButton').hide();
    $('#cancelButton').hide();
}

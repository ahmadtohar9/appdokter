$(document).ready(function() {
    // Panggil loadDiagnosaData saat dokumen siap
    loadDiagnosaData();

    // Panggil loadDiagnosaData setiap kali modal ditutup
    $('#diagnosaModal').on('hidden.bs.modal', function () {
        loadDiagnosaData();
    });
});

function submitDiagnosa() {
    var kd_penyakit = $('#kd_penyakit').val();
    var prioritas = $('#prioritas').val();
    var no_rawat = $('[name="no_rawat"]').val();

    $.ajax({
        url: base_url + "DokterController/save_diagnosa",
        method: "POST",
        data: {
            no_rawat: no_rawat,
            kd_penyakit: kd_penyakit,
            prioritas: prioritas
        },
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                alert('Diagnosa berhasil ditambahkan');
                $('#diagnosaModal').modal('hide');
                $('#diagnosaForm')[0].reset();
            } else {
                alert('Gagal menambahkan diagnosa: ' + res.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Terjadi kesalahan: ' + textStatus);
        }
    });
}

function loadDiagnosaData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + "DokterController/get_diagnosa_data",
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            console.log("Diagnosa data fetched successfully:", data);
            try {
                var diagnosaList = JSON.parse(data);
                var tableBody = '';
                diagnosaList.forEach(function(diagnosa, index) {
                    tableBody += '<tr>';
                    tableBody += '<td>' + (index + 1) + '</td>';
                    tableBody += '<td>' + diagnosa.kd_penyakit + '</td>';
                    tableBody += '<td>' + diagnosa.nm_penyakit + '</td>';
                    tableBody += '<td>' + diagnosa.status_penyakit + '</td>';
                    tableBody += '<td>' + diagnosa.prioritas + '</td>';
                    tableBody += '<td><button type="button" class="btn btn-danger btn-sm" onclick="deleteDiagnosa(\'' + diagnosa.no_rawat + '\', \'' + diagnosa.kd_penyakit + '\')">Hapus</button></td>';
                    tableBody += '</tr>';
                });
                $('#diagnosaTable tbody').html(tableBody);
            } catch (error) {
                console.error('Error parsing diagnosa data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching diagnosa data:', textStatus, errorThrown);
        }
    });
}

function deleteDiagnosa(no_rawat, kd_penyakit) {
    if (confirm('Apakah Anda yakin ingin menghapus diagnosa ini?')) {
        $.ajax({
            url: base_url + "DokterController/delete_diagnosa",
            method: "POST",
            data: {
                no_rawat: no_rawat,
                kd_penyakit: kd_penyakit
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Diagnosa berhasil dihapus');
                    loadDiagnosaData();
                } else {
                    alert('Gagal menghapus diagnosa: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting diagnosa:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }
}

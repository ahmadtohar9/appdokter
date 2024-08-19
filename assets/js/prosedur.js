$(document).ready(function() {
    // Inisialisasi autocomplete untuk input kode penyakit
    applyAutocompletePenyakit($('#kode'));

    // Panggil loadProsedurData saat dokumen siap
    loadProsedurData();

    // Panggil loadProsedurData setiap kali modal ditutup
    $('#prosedurModal').on('hidden.bs.modal', function () {
        loadProsedurData();
    });

    // Simpan data prosedur ketika tombol simpan diklik
    $('#saveProsedur').click(function() {
        submitProsedur();
    });
});

function applyAutocompletePenyakit(element) {
    element.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'ProsedurController/get_penyakit_prosedur', // Pastikan URL ini benar
                method: "GET",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.kode + ' - ' + item.deskripsi_panjang,
                            value: item.kode
                        };
                    }));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching penyakit data:', textStatus, errorThrown);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#kode').val(ui.item.value);
        }
    });
}



function submitProsedur() {
    var kode = $('#kode').val();
    var prioritas = $('#prioritas').val();
    var no_rawat = $('[name="no_rawat"]').val();

    $.ajax({
        url: base_url + "ProsedurController/save_prosedur",
        method: "POST",
        data: {
            no_rawat: no_rawat,
            kode: kode,
            prioritas: prioritas
        },
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                alert('Prosedur berhasil ditambahkan');
                $('#prosedurModal').modal('hide');
                $('#prosedurForm')[0].reset();
                loadProsedurData(); // Muat ulang data prosedur setelah menambah
            } else {
                alert('Gagal menambahkan prosedur: ' + res.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Terjadi kesalahan: ' + textStatus);
        }
    });
}

function loadProsedurData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + "ProsedurController/get_prosedur_data",
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var prosedurList = JSON.parse(data);
                var tableBody = '';
                prosedurList.forEach(function(prosedur, index) {
                    tableBody += '<tr>';
                    tableBody += '<td>' + (index + 1) + '</td>';
                    tableBody += '<td>' + prosedur.kode + '</td>';
                    tableBody += '<td>' + prosedur.deskripsi_panjang + '</td>';
                    // tableBody += '<td>' + prosedur.status + '</td>'; // Pastikan ini sesuai dengan kolom di database
                    // tableBody += '<td>' + prosedur.prioritas + '</td>';
                    tableBody += '<td><button type="button" class="btn btn-danger btn-sm" onclick="deleteProsedur(\'' + prosedur.no_rawat + '\', \'' + prosedur.kode + '\')">Hapus</button></td>';
                    tableBody += '</tr>';
                });
                $('#prosedurTable tbody').html(tableBody);
            } catch (error) {
                console.error('Error parsing prosedur data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching prosedur data:', textStatus, errorThrown);
        }
    });
}

function deleteProsedur(no_rawat, kode) {
    if (confirm('Apakah Anda yakin ingin menghapus prosedur ini?')) {
        $.ajax({
            url: base_url + "ProsedurController/delete_prosedur",
            method: "POST",
            data: {
                no_rawat: no_rawat,
                kode: kode
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Prosedur berhasil dihapus');
                    loadProsedurData();
                } else {
                    alert('Gagal menghapus prosedur: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting prosedur:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }
}

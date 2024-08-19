$(document).ready(function() {
    applyAutocompletePenyakit($('#kode'));
    loadProsedurData();
});

function applyAutocompletePenyakit(element) {
    element.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'ProsedurController/get_penyakit_prosedur',
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
                    console.error('Error fetching data:', textStatus, errorThrown);
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
                $('#prosedurForm')[0].reset();      // Mengosongkan form
                loadProsedurData();                 // Memuat ulang data prosedur
                // Jika ingin tanpa notifikasi
            } else {
                // Cukup tampilkan error message jika ada masalah
                console.error('Gagal menambahkan prosedur: ' + res.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Log error di console untuk debugging
            console.error('Terjadi kesalahan: ' + textStatus);
        }
    });

    // Prevent form submission and page reload
    return false;
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
                    tableBody += '<td><button type="button" class="btn btn-danger btn-sm" onclick="deleteProsedur(\'' + prosedur.no_rawat + '\', \'' + prosedur.kode + '\')">Hapus</button></td>';
                    tableBody += '</tr>';
                });
                $('#prosedurTable tbody').html(tableBody);
            } catch (error) {
                console.error('Error parsing data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
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
                    loadProsedurData();
                } else {
                    alert('Gagal menghapus prosedur: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }
}

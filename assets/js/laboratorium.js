$(document).ready(function() {
    loadLabTests();  // Panggil fungsi untuk memuat 15 data pemeriksaan laboratorium pertama

    // Ketika tombol pilih pada daftar pemeriksaan laboratorium diklik
    $('#labList').on('click', '.selectLab', function() {
        var kd_jenis_prw = $(this).data('kd_jenis_prw');
        var nm_perawatan = $(this).data('nm_perawatan');
        
        // Tambahkan ke daftar yang dipilih
        var selectedLabHTML = `
            <tr data-kd_jenis_prw="${kd_jenis_prw}">
                <td><input type="checkbox" class="selectedLabCheck" data-kd_jenis_prw="${kd_jenis_prw}"></td>
                <td>${kd_jenis_prw}</td>
                <td>${nm_perawatan}</td>
                <td><button type="button" class="btn btn-danger btn-sm removeLab">Hapus</button></td>
            </tr>
        `;
        $('#selectedLabList').append(selectedLabHTML);
    });

    // Ketika checkbox pada daftar yang dipilih diubah
    $('#selectedLabList').on('change', '.selectedLabCheck', function() {
        var kd_jenis_prw = $(this).data('kd_jenis_prw');
        if ($(this).is(':checked')) {
            getLabDetails(kd_jenis_prw);  // Ambil detail pemeriksaan ketika checkbox dipilih
        } else {
            // Jika checkbox tidak dipilih, hapus detail terkait dari tabel detail
            $('#labDetailList').find('tr[data-kd_jenis_prw="' + kd_jenis_prw + '"]').remove();
        }
    });

    // Ketika tombol hapus pada daftar yang dipilih diklik
    $('#selectedLabList').on('click', '.removeLab', function() {
        var kd_jenis_prw = $(this).closest('tr').data('kd_jenis_prw');
        // Hapus dari daftar yang dipilih
        $(this).closest('tr').remove();
        // Hapus detail terkait
        $('#labDetailList').find('tr[data-kd_jenis_prw="' + kd_jenis_prw + '"]').remove();
    });

    // Event handler untuk pencarian
    $('#searchLab').on('input', function() {
        var query = $(this).val().trim();
        if (query === '') {
            loadLabTests();  // Jika pencarian dikosongkan, kembali ke tampilan default
        } else {
            searchLabTests(query);
        }
    });

    // Ketika tombol simpan diklik
    $('#saveLabOrder').on('click', function() {
        var no_rawat = $('#no_rawat').val();
        var kd_dokter = $('#kd_dokter').val();
        var tgl_permintaan = $('#tgl_permintaan').val();
        var jam_permintaan = $('#jam_permintaan').val();
        var informasi_tambahan = $('#informasi_tambahan').val();
        var diagnosa_klinis = $('#diagnosa_klinis').val();
        var lab_orders = [];
        var lab_details = [];

        // Kumpulkan data lab yang dipilih
        $('#selectedLabList tr').each(function() {
            var kd_jenis_prw = $(this).data('kd_jenis_prw');
            lab_orders.push(kd_jenis_prw);
        });

        // Kumpulkan detail pemeriksaan yang dipilih
        $('#labDetailList .detailCheck:checked').each(function() {
            var kd_jenis_prw = $(this).closest('tr').data('kd_jenis_prw');
            var id_template = $(this).data('id_template'); // Pastikan data-id_template ada di checkbox
            lab_details.push({
                kd_jenis_prw: kd_jenis_prw,
                id_template: id_template
            });
        });

        $.ajax({
            url: base_url + 'LaboratoriumController/save_lab_order',
            method: 'POST',
            dataType: 'json',
            data: {
                no_rawat: no_rawat,
                kd_dokter: kd_dokter,
                tgl_permintaan: tgl_permintaan,
                jam_permintaan: jam_permintaan,
                informasi_tambahan: informasi_tambahan,
                diagnosa_klinis: diagnosa_klinis,
                lab_orders: lab_orders,
                lab_details: lab_details
            },
            success: function(response) {
                if (response.status == 'success') {
                    alert('Permintaan laboratorium berhasil disimpan.');
                    // Lakukan refresh atau tindakan lain yang diperlukan
                } else {
                    alert('Gagal menyimpan permintaan laboratorium.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error saving lab order:', textStatus, errorThrown);
            }
        });
    });
});

// Fungsi untuk memuat data pemeriksaan laboratorium
function loadLabTests(limit = 15) {
    $.ajax({
        url: base_url + 'LaboratoriumController/get_lab_tests',
        method: 'GET',
        dataType: 'json',
        data: { limit: limit },  // Kirim limit sebagai parameter
        success: function(data) {
            var labListHTML = '';
            data.forEach(function(item) {
                labListHTML += `
                    <tr>
                        <td><button type="button" class="btn btn-primary btn-sm selectLab" data-kd_jenis_prw="${item.kd_jenis_prw}" data-nm_perawatan="${item.nm_perawatan}">Pilih</button></td>
                        <td>${item.kd_jenis_prw}</td>
                        <td>${item.nm_perawatan}</td>
                    </tr>
                `;
            });
            $('#labList').html(labListHTML);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching lab data:', textStatus, errorThrown);
        }
    });
}

// Fungsi untuk mencari tindakan laboratorium
function searchLabTests(query) {
    $.ajax({
        url: base_url + 'LaboratoriumController/search_lab_tests',
        method: 'GET',
        dataType: 'json',
        data: { query: query },
        success: function(data) {
            var labListHTML = '';
            data.forEach(function(item) {
                labListHTML += `
                    <tr>
                        <td><button type="button" class="btn btn-primary btn-sm selectLab" data-kd_jenis_prw="${item.kd_jenis_prw}" data-nm_perawatan="${item.nm_perawatan}">Pilih</button></td>
                        <td>${item.kd_jenis_prw}</td>
                        <td>${item.nm_perawatan}</td>
                    </tr>
                `;
            });
            $('#labList').html(labListHTML);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error searching lab data:', textStatus, errorThrown);
        }
    });
}

// Fungsi untuk mendapatkan detail pemeriksaan laboratorium
function getLabDetails(kd_jenis_prw) {
    $.ajax({
        url: base_url + 'LaboratoriumController/get_lab_details',
        method: 'GET',
        data: { kd_jenis_prw: kd_jenis_prw },
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var detailHTML = '';
                data.forEach(function(item) {
                    detailHTML += `
                        <tr data-kd_jenis_prw="${kd_jenis_prw}">
                            <td><input type="checkbox" class="detailCheck" data-id_template="${item.id_template}"></td>
                            <td>${item.Pemeriksaan}</td>
                            <td>${item.satuan}</td>
                            <td>${item.nilai_rujukan_ld || '-'} ${item.nilai_rujukan_la || ''} ${item.nilai_rujukan_pd || ''} ${item.nilai_rujukan_pa || ''}</td>
                        </tr>
                    `;
                });
                $('#labDetailList').append(detailHTML);
            } else {
                $('#labDetailList').html('<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching lab details:', textStatus, errorThrown);
        }
    });
}

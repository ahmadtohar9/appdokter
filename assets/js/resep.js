$(document).ready(function() {
    // Inisialisasi autocomplete untuk input pertama
    applyAutocomplete($('.search_nama_brng').first());

    // Toggle tampilan form input resep
    $('#toggleResepForm').click(function() {
        $('#resepFormContainer').toggle();

        // Tambahkan satu baris input secara otomatis jika form baru saja ditampilkan
        if ($('#resepFormContainer').is(':visible')) {
            $('#dynamicResepForm')[0].reset(); // Reset form input resep
            $('#resepInputs').html(''); // Bersihkan semua baris input
            addResepInputRow(); // Tambahkan satu baris input baru
        }
    });

    // Tambah baris input resep
    $('#addResepInput').click(function() {
        addResepInputRow();
    });

    // Tutup form input resep
    $('#closeResepForm').click(function() {
        $('#resepFormContainer').hide();
        $('#dynamicResepForm')[0].reset();
        $('#resepInputs').html(''); // Bersihkan semua baris input
    });

    // Simpan data resep dan tampilkan di tabel
    $('#saveResep').click(function() {
        var kode_brng = $('.kode_brng').map(function(){ return $(this).val(); }).get();
        var jml = $('.jml').map(function(){ return $(this).val(); }).get();
        var nama_brng = $('.search_nama_brng').map(function(){ return $(this).val(); }).get();
        var stok = $('.stok').map(function(){ return $(this).val(); }).get();
        var aturan_pakai = $('.aturan_pakai').map(function(){ return $(this).val(); }).get();
        var no_rawat = $('[name="no_rawat"]').val();
        var kd_dokter = $('[name="kd_dokter"]').val();

        // Validasi untuk cek apakah ada obat yang sama
        if (hasDuplicate(kode_brng)) {
            alert('Tidak boleh memasukkan obat yang sama lebih dari sekali.'); // Tampilkan notifikasi
            return false;
        }

        // Validasi untuk memastikan jumlah obat tidak melebihi stok
        var overstockMessages = [];
        for (var i = 0; i < jml.length; i++) {
            if (parseInt(jml[i]) > parseInt(stok[i])) {
                overstockMessages.push(nama_brng[i] + ' (Stok: ' + stok[i] + ')');
            }
        }

        if (overstockMessages.length > 0) {
            alert('Jumlah untuk obat berikut melebihi stok yang tersedia:\n' + overstockMessages.join('\n'));
            return false;
        }

        $.ajax({
            url: base_url + 'DokterController/save_resep_batch',
            method: "POST",
            data: {
                no_rawat: no_rawat,
                kd_dokter: kd_dokter,
                kode_brng: kode_brng,
                jml: jml,
                aturan_pakai: aturan_pakai
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#resepFormContainer').hide();
                    loadResepData(); // Muat ulang data tabel resep
                    $('#dynamicResepForm')[0].reset();
                    $('#resepInputs').html(''); // Bersihkan semua baris input kecuali yang pertama
                } else {
                    alert(res.message); // Tampilkan pesan error atau warning dari server
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    });

    // Muat data resep ke tabel saat halaman pertama kali dibuka
    loadResepData();
});

// Fungsi untuk memuat data resep ke tabel
function loadResepData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + 'DokterController/get_resep_data',
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var resepList = JSON.parse(data);
                var tableBody = '';
                var totalKeseluruhan = 0;

                resepList.forEach(function(resep, index) {
                    var totalRalan = resep.jml * resep.ralan;
                    totalKeseluruhan += totalRalan;

                    tableBody += '<tr>';
                    tableBody += '<td>' + (index + 1) + '</td>';
                    tableBody += '<td>' + resep.nama_brng + '</td>';
                    tableBody += '<td>' + resep.jml + '</td>';
                    tableBody += '<td>' + resep.aturan_pakai + '</td>';
                    tableBody += '<td>Rp. ' + formatRupiah(resep.ralan) + '</td>';
                    tableBody += '<td>Rp. ' + formatRupiah(totalRalan) + '</td>';
                    tableBody += '<td><button type="button" class="btn btn-danger btn-sm" onclick="deleteResep(\'' + resep.no_resep + '\', \'' + resep.kode_brng + '\')">Hapus</button></td>';
                    tableBody += '</tr>';
                });

                var tableFooter = '<tr>';
                tableFooter += '<td colspan="5"><strong>Total Keseluruhan:</strong></td>';
                tableFooter += '<td colspan="2"><strong>Rp. ' + formatRupiah(totalKeseluruhan) + '</strong></td>';
                tableFooter += '</tr>';

                $('#resepTable tbody').html(tableBody);
                $('#resepTable tfoot').html(tableFooter); // Tampilkan footer di bagian bawah tabel

            } catch (error) {
                console.error('Error parsing resep data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching resep data:', textStatus, errorThrown);
        }
    });
}


// Fungsi untuk menghapus resep
function deleteResep(no_resep, kode_brng) {
    if (confirm('Apakah Anda yakin ingin menghapus resep ini?')) {
        $.ajax({
            url: base_url + 'DokterController/delete_resep',
            method: "POST",
            data: {
                no_resep: no_resep,
                kode_brng: kode_brng
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    loadResepData();  // Memperbarui data resep setelah penghapusan
                } else {
                    alert('Gagal menghapus resep: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting resep:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }
}

// Fungsi untuk menambahkan baris input resep
function addResepInputRow() {
    var newResepInput = `
        <div class="form-row resep-item">
            <div class="form-group col-md-2">
                <label for="nama_brng">Nama Obat</label>
                <input type="text" class="form-control form-control-sm search_nama_brng" placeholder="Cari obat...">
                <input type="hidden" class="form-control form-control-sm kode_brng" name="kode_brng[]">
            </div>
            <div class="form-group col-md-2">
                <label for="jml">Jumlah</label>
                <input type="text" class="form-control form-control-sm jml" name="jml[]">
            </div>
            <div class="form-group col-md-2">
                <label for="aturan_pakai">Aturan Pakai</label>
                <input type="text" class="form-control form-control-sm aturan_pakai" name="aturan_pakai[]">
            </div>
            <div class="form-group col-md-2">
                <label for="stok">Stok</label>
                <input type="text" class="form-control form-control-sm stok" name="stok[]" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="harga">Harga</label>
                <input type="text" class="form-control form-control-sm harga" name="harga[]" readonly>
            </div>
        </div>`;
    $('#resepInputs').append(newResepInput);
    
    // Terapkan autocomplete pada input baru
    applyAutocomplete($('.search_nama_brng').last());
}

// Fungsi untuk mengecek duplikasi dalam array
function hasDuplicate(arr) {
    return new Set(arr).size !== arr.length;
}

function applyAutocomplete(element) {
    element.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'DokterController/get_DataBarang',
                method: "GET",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nama_brng + ' - Stok: ' + item.stok + ' - Harga: ' + item.harga_obat,
                            value: item.nama_brng,
                            kode_brng: item.kode_brng,
                            stok: item.stok,
                            harga: item.harga_obat
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            var parentRow = $(this).closest('.form-row');
            parentRow.find('.search_nama_brng').val(ui.item.value);
            parentRow.find('.kode_brng').val(ui.item.kode_brng);
            parentRow.find('.stok').val(ui.item.stok);
            parentRow.find('.harga').val(ui.item.harga);
            $(this).val(ui.item.value);
        }
    });
}

function formatRupiah(number) {
    return parseInt(number).toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).replace('Rp', '');
}

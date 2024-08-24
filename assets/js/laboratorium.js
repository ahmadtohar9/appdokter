$(document).ready(function() {
    // Inisialisasi default tanggal dan jam permintaan ke saat ini
    var today = new Date().toISOString().split('T')[0];
    $('#tgl_permintaan').val(today);

    var currentTime = new Date().toLocaleTimeString('it-IT');
    $('#jam_permintaan').val(currentTime);

    // Muat data pemeriksaan laboratorium saat halaman pertama kali dibuka
    loadLabTests();  
    loadLabResults();  // Panggil fungsi untuk memuat hasil laboratorium yang telah diinput

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

    $('#saveLabOrder').on('click', function() {
    var no_rawat = $('#no_rawat').val();
    var kd_dokter = $('#kd_dokter').val();
    var tgl_permintaan = $('#tgl_permintaan').val();
    var jam_permintaan = $('#jam_permintaan').val();
    var informasi_tambahan = $('#informasi_tambahan').val() || 'Tidak ada informasi tambahan';
    var diagnosa_klinis = $('#diagnosa_klinis').val() || 'Tidak ada diagnosa klinis';
    var lab_orders = [];
    var lab_details = [];

    $('#selectedLabList tr').each(function() {
        var kd_jenis_prw = $(this).data('kd_jenis_prw');
        lab_orders.push(kd_jenis_prw);
    });

    $('#labDetailList .detailCheck:checked').each(function() {
        var kd_jenis_prw = $(this).closest('tr').data('kd_jenis_prw');
        var id_template = $(this).data('id_template');
        lab_details.push({
            kd_jenis_prw: kd_jenis_prw,
            id_template: id_template
        });
    });

    if (no_rawat && kd_dokter && tgl_permintaan && jam_permintaan && lab_orders.length > 0) {
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
                    loadLabResults(); 
                    clearLabForm(); 
                } else {
                    alert('Gagal menyimpan permintaan laboratorium.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error saving lab order:', textStatus, errorThrown);
            }
        });
    } else {
        alert('Harap isi semua kolom yang diperlukan dan pilih setidaknya satu tindakan laboratorium!');
    }
});


    function loadPermintaanLabData() 
    {
            var noRawat = $('[name="no_rawat"]').val();
            $.ajax({
                url: base_url + 'LaboratoriumController/get_permintaan_lab',
                method: "GET",
                data: { no_rawat: noRawat },
                success: function(data) {
                    try {
                        var permintaanList = JSON.parse(data);
                        var tableBody = '';
                        var totalKeseluruhan = 0;

                        permintaanList.forEach(function(permintaan, index) {
                            var totalBiaya = parseInt(permintaan.total_byr);
                            if (!isNaN(totalBiaya)) {
                                totalKeseluruhan += totalBiaya;
                            }

                            tableBody += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${permintaan.noorder || ''}</td>
                                    <td>${permintaan.tgl_permintaan || ''}</td>
                                    <td>${permintaan.informasi_tambahan || ''}</td>
                                    <td>${permintaan.diagnosa_klinis || ''}</td>
                                    <td>${permintaan.nm_perawatan || ''}</td>
                                    <td>Rp. ${formatRupiah(totalBiaya) || '0'}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deletePermintaanLab('${permintaan.no_rawat}', '${permintaan.noorder}')">Hapus</button>
                                    </td>
                                </tr>
                            `;
                        });

                        var tableFooter = `
                            <tr>
                                <td colspan="6"><strong>Total Keseluruhan:</strong></td>
                                <td colspan="2"><strong>Rp. ${formatRupiah(totalKeseluruhan)}</strong></td>
                            </tr>
                        `;

                        $('#permintaanLabTable tbody').html(tableBody);
                        $('#permintaanLabTable tfoot').html(tableFooter);

                    } catch (error) {
                        console.error('Error parsing permintaan data:', error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching permintaan data:', textStatus, errorThrown);
                }
            });
        }

    // Fungsi untuk membersihkan form setelah menyimpan
    function clearLabForm() {
        $('#selectedLabList').empty();
        $('#labDetailList').empty();
        $('#informasi_tambahan').val('');
        $('#diagnosa_klinis').val('');
    }

    function loadLabResults() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + 'LaboratoriumController/get_hasil_lab',
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var hasilLabList = JSON.parse(data);
                var tableBody = '';
                var indexCounter = 1; // Inisialisasi counter untuk nomor

                hasilLabList.forEach(function(hasil, index) {
                    var currentOrder = hasil.noorder;
                    var groupedResults = hasilLabList.filter(item => item.noorder === currentOrder);
                    var rowspan = groupedResults.length;

                    if (index === 0 || hasilLabList[index - 1].noorder !== currentOrder) {
                        // Tampilkan baris pertama untuk setiap order dengan rowspan untuk menggabungkan baris yang sama
                        tableBody += `
                            <tr>
                                <td rowspan="${rowspan}">${indexCounter++}</td>
                                <td rowspan="${rowspan}">${hasil.noorder || ''}</td>
                                <td rowspan="${rowspan}">${hasil.tgl_permintaan || ''}</td>
                                <td rowspan="${rowspan}">${hasil.jam_permintaan || ''}</td>
                                <td rowspan="${rowspan}">${hasil.nm_perawatan || ''}</td>
                                <td><input type="radio" name="detailLab_${hasil.noorder}" value="${hasil.Pemeriksaan}" checked> ${hasil.Pemeriksaan}</td>
                                <td rowspan="${rowspan}">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteHasilLab('${hasil.no_rawat}', '${hasil.noorder}')">Hapus</button>
                                </td>
                            </tr>
                        `;
                    } else {
                        // Tampilkan baris tambahan untuk pemeriksaan yang sama dalam order yang sama
                        tableBody += `
                            <tr>
                                <td><input type="radio" name="detailLab_${hasil.noorder}" value="${hasil.Pemeriksaan}"> ${hasil.Pemeriksaan}</td>
                            </tr>
                        `;
                    }
                });

                $('#hasilLabTable tbody').html(tableBody);

            } catch (error) {
                console.error('Error parsing hasil lab data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching hasil lab data:', textStatus, errorThrown);
        }
    });
}

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

    window.deleteHasilLab = function (noRawat, noOrder) {
    if (confirm('Apakah Anda yakin ingin menghapus hasil lab ini?')) {
        $.ajax({
            url: base_url + 'LaboratoriumController/delete_hasil_lab',
            method: "POST",
            data: {
                no_rawat: noRawat,
                no_order: noOrder
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Hasil lab berhasil dihapus.');
                    loadLabResults();  // Muat ulang data setelah penghapusan berhasil
                } else {
                    alert('Gagal menghapus hasil lab: ' + res.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error deleting hasil lab:', textStatus, errorThrown);
                alert('Terjadi kesalahan saat menghapus hasil lab.');
            }
        });
    }
}

});

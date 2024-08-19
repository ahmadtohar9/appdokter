$(document).ready(function() {
    // Inisialisasi autocomplete untuk input tindakan
    applyAutocompleteTindakan($('#nm_perawatan'));

    // Muat data tindakan ke tabel saat halaman pertama kali dibuka
    loadTindakanData();

    // Tambah tindakan baru dan simpan ke database
    $('#addTindakan').on('click', function() {
        var nm_perawatan = $('#nm_perawatan').val();
        var kd_jenis_prw = $('#kd_jenis_prw').val();
        var total_byrdr = $('#total_byrdr').val();
        var material = $('#material').val();
        var bhp = $('#bhp').val();
        var tarif_tindakandr = $('#tarif_tindakandr').val();
        var kso = $('#kso').val();
        var menejemen = $('#menejemen').val();
        var no_rawat = $('[name="no_rawat"]').val();
        var kd_dokter = $('[name="kd_dokter"]').val();

        if (nm_perawatan && total_byrdr && kd_jenis_prw && no_rawat && kd_dokter) {
            $.ajax({
                url: base_url + 'TindakanController/save_tindakan_ralan',
                method: "POST",
                data: {
                    no_rawat: no_rawat,
                    kd_dokter: kd_dokter,
                    kd_jenis_prw: kd_jenis_prw,
                    material: material,
                    bhp: bhp,
                    tarif_tindakandr: tarif_tindakandr,
                    kso: kso,
                    menejemen: menejemen,
                    total_byrdr: total_byrdr
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        // Tindakan berhasil disimpan, muat ulang data tindakan
                        loadTindakanData();
                        $('#nm_perawatan').val('');
                        $('#total_byrdr').val('');
                        $('#kd_jenis_prw').val('');
                        $('#material').val('');
                        $('#bhp').val('');
                        $('#tarif_tindakandr').val('');
                        $('#kso').val('');
                        $('#menejemen').val('');
                    } else {
                        alert('Gagal menyimpan tindakan: ' + res.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error saving tindakan:', textStatus, errorThrown);
                    alert('Terjadi kesalahan saat menyimpan tindakan.');
                }
            });
        } else {
            alert('Harap isi Nama Tindakan, Kode Tindakan, Total Biaya, No Rawat, dan Kode Dokter!');
        }
    });

    // Fungsi untuk memuat data tindakan ke tabel
    function loadTindakanData() {
        var noRawat = $('[name="no_rawat"]').val();
        $.ajax({
            url: base_url + 'TindakanController/get_tindakan_ralan',
            method: "GET",
            data: { no_rawat: noRawat },
            success: function(data) {
                try {
                    var tindakanList = JSON.parse(data);
                    var tableBody = '';
                    var totalKeseluruhan = 0;

                    tindakanList.forEach(function(tindakan, index) {
                        var totalBiaya = parseInt(tindakan.total_byrdr);
                        totalKeseluruhan += totalBiaya;

                        tableBody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${tindakan.kd_jenis_prw}</td>
                                <td>${tindakan.nm_perawatan}</td>
                                <td>${tindakan.jam_rawat}</td>
                                <td>Rp. ${formatRupiah(totalBiaya)}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteTindakan('${tindakan.no_rawat}', '${tindakan.kd_jenis_prw}', '${tindakan.jam_rawat}')">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#tindakanTable tbody').html(tableBody);
                    updateTindakanTable(); // Perbarui total biaya keseluruhan

                } catch (error) {
                    console.error('Error parsing tindakan data:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching tindakan data:', textStatus, errorThrown);
            }
        });
    }

    // Fungsi untuk memperbarui nomor urut dan total biaya
    function updateTindakanTable() {
        var totalKeseluruhan = 0;
        $('#tindakanTable tbody tr').each(function(index) {
            var row = $(this);
            row.find('td:eq(0)').text(index + 1); // Perbarui nomor urut
            var totalBiaya = parseInt(row.find('td:eq(4)').text().replace(/[^0-9,-]+/g, ""));
            totalKeseluruhan += totalBiaya;
        });

        var tableFooter = `
            <tr>
                <td colspan="4"><strong>Total Keseluruhan:</strong></td>
                <td colspan="2"><strong>Rp. ${formatRupiah(totalKeseluruhan)}</strong></td>
            </tr>
        `;

        $('#tindakanTable tfoot').html(tableFooter);
    }

    // Fungsi untuk menghapus tindakan dari server
    window.deleteTindakan = function(no_rawat, kd_jenis_prw, jam_rawat) {
        if (confirm('Apakah Anda yakin ingin menghapus tindakan ini?')) {
            $.ajax({
                url: base_url + 'TindakanController/delete_tindakan',
                method: "POST",
                data: {
                    no_rawat: no_rawat,
                    kd_jenis_prw: kd_jenis_prw,
                    jam_rawat: jam_rawat
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        loadTindakanData();  // Memperbarui data tindakan setelah penghapusan
                    } else {
                        alert('Gagal menghapus tindakan: ' + res.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error deleting tindakan:', textStatus, errorThrown);
                    alert('Terjadi kesalahan: ' + textStatus);
                }
            });
        }
    };

    function applyAutocompleteTindakan(element) {
    element.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'TindakanController/get_DataTindakan',
                method: "GET",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nm_perawatan + ' - ' + item.total_byrdr,
                            value: item.nm_perawatan,
                            kd_jenis_prw: item.kd_jenis_prw,
                            total_byrdr: item.total_byrdr,
                            material: item.material,
                            bhp: item.bhp,
                            tarif_tindakandr: item.tarif_tindakandr,
                            kso: item.kso,
                            menejemen: item.menejemen
                        };
                    }));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching data for autocomplete:', textStatus, errorThrown);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#nm_perawatan').val(ui.item.value);
            $('#total_byrdr').val(ui.item.total_byrdr);
            $('#kd_jenis_prw').val(ui.item.kd_jenis_prw);
            $('#material').val(ui.item.material);
            $('#bhp').val(ui.item.bhp);
            $('#tarif_tindakandr').val(ui.item.tarif_tindakandr);
            $('#kso').val(ui.item.kso);
            $('#menejemen').val(ui.item.menejemen);
        },
        open: function() {
            var autocomplete = $(this).autocomplete("widget");
            var inputWidth = $(this).outerWidth();
            var inputOffset = $(this).offset();
            var autocompleteWidth = autocomplete.outerWidth();

            var newPositionTop = inputOffset.top - autocomplete.outerHeight() - 5;
            var newPositionLeft = inputOffset.left + (inputWidth / 2) - (autocompleteWidth / 2);

            autocomplete.css({
                "top": newPositionTop + "px",
                "left": newPositionLeft + "px",
                "width": inputWidth + "px"
            });
        }
    });
}


    // Fungsi untuk memformat angka ke dalam format Rupiah
    function formatRupiah(number) {
        return parseInt(number).toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).replace('Rp', '');
    }
});

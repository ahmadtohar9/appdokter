$(document).ready(function() {
    // Inisialisasi autocomplete untuk input tindakan radiologi
    applyAutocompleteRadiologi($('#nm_perawatan_radiologi'));

    // Set default tanggal dan jam sampel ke saat ini
    var today = new Date().toISOString().split('T')[0];
    $('#tgl_permintaan').val(today);

    var currentTime = new Date().toLocaleTimeString('it-IT');
    $('#jam_permintaan').val(currentTime);

    // Muat data tindakan ke tabel saat halaman pertama kali dibuka
    loadTindakanData();

    // Tambah tindakan baru dan simpan ke database
    $('#addTindakanRadiologi').on('click', function() {
        var nm_perawatan = $('#nm_perawatan_radiologi').val();
        var kd_jenis_prw = $('#kd_jenis_prw').val();
        var total_byr = $('#total_byr_radiologi').val();
        var no_rawat = $('[name="no_rawat"]').val();
        var kd_dokter = $('[name="kd_dokter"]').val();
        var tgl_permintaan = $('#tgl_permintaan').val();
        var jam_permintaan = $('#jam_permintaan').val();
        var informasi_tambahan = $('#informasi_tambahan').val();
        var diagnosa_klinis = $('#diagnosa_klinis').val();

        if (nm_perawatan && total_byr && kd_jenis_prw && no_rawat && kd_dokter && tgl_permintaan && jam_permintaan && informasi_tambahan && diagnosa_klinis) {
            $.ajax({
                url: base_url + 'RadiologiController/save_permintaan_radiologi',
                method: "POST",
                data: {
                    no_rawat: no_rawat,
                    kd_dokter: kd_dokter,
                    kd_jenis_prw: kd_jenis_prw,
                    total_byr: total_byr,
                    tgl_permintaan: tgl_permintaan,
                    jam_permintaan: jam_permintaan,
                    informasi_tambahan: informasi_tambahan,
                    diagnosa_klinis: diagnosa_klinis
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        loadTindakanData();
                        $('#nm_perawatan_radiologi').val('');
                        $('#total_byr_radiologi').val('');
                        $('#kd_jenis_prw').val('');
                        $('#tgl_permintaan').val(today); // Reset ke tanggal saat ini
                        $('#jam_permintaan').val(currentTime); // Reset ke jam saat ini
                        $('#informasi_tambahan').val('');
                        $('#diagnosa_klinis').val('');
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
            alert('Harap isi semua kolom yang diperlukan!');
        }
    });

   function loadTindakanData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + 'RadiologiController/get_permintaan_radiologi',
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var tindakanList = JSON.parse(data);
                var tableBody = '';
                var totalKeseluruhan = 0;

                tindakanList.forEach(function(tindakan, index) {
                    var totalBiaya = parseInt(tindakan.total_byr);
                    if (!isNaN(totalBiaya)) {
                        totalKeseluruhan += totalBiaya;
                    }

                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${tindakan.noorder || ''}</td>
                            <td>${tindakan.tgl_permintaan || ''}</td>
                            <td>${tindakan.informasi_tambahan || ''}</td>
                            <td>${tindakan.diagnosa_klinis || ''}</td>
                            <td>${tindakan.nm_perawatan || ''}</td>
                            <td>Rp. ${formatRupiah(totalBiaya) || '0'}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteTindakanPermintaanRadiologi('${tindakan.no_rawat}', '${tindakan.noorder}')">Hapus</button>
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

                $('#tindakanRadiologiTable tbody').html(tableBody);
                $('#tindakanRadiologiTable tfoot').html(tableFooter); // Tampilkan footer di bagian bawah tabel

            } catch (error) {
                console.error('Error parsing tindakan data:', error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching tindakan data:', textStatus, errorThrown);
        }
    });
}



    window.deleteTindakanPermintaanRadiologi = function(no_rawat, no_order) {
	    if (confirm('Apakah Anda yakin ingin menghapus tindakan ini?')) {
	        $.ajax({
	            url: base_url + 'RadiologiController/delete_permintaanRadiologi',
	            method: "POST",
	            data: { 
	                no_rawat: no_rawat,
	                no_order: no_order 
	            },
	            success: function(response) {
	                var res = JSON.parse(response);
	                if (res.status === 'success') {
	                    loadTindakanData();  // Muat ulang data setelah penghapusan berhasil
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

 


    function applyAutocompleteRadiologi(element) {
        element.autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: base_url + 'RadiologiController/get_DataTindakanRadiologi',
                    method: "GET",
                    data: { term: request.term },
                    dataType: "json",
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nm_perawatan + ' - ' + item.total_byr,
                                value: item.nm_perawatan,
                                kd_jenis_prw: item.kd_jenis_prw,
                                total_byr: item.total_byr
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
                $('#nm_perawatan_radiologi').val(ui.item.value);
                $('#total_byr_radiologi').val(ui.item.total_byr);
                $('#kd_jenis_prw').val(ui.item.kd_jenis_prw);
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

    function formatRupiah(number) {
        return parseInt(number).toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).replace('Rp', '');
    }
});

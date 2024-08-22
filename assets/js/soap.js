$(document).ready(function() {
    $('#soapForm').submit(function(event) {
        event.preventDefault();

        var jam = $('#jam').val(); 
        var originalJam = $('#original_jam').val();

        if (originalJam && originalJam.substring && jam === originalJam.substring(0, 5)) {
            jam = originalJam;
        }
        $('#jam').val(jam);

        if ($('#saveButton').is(':visible')) {
            saveSOAP();
        } else {
            updateSOAP();
        }
    });

    function saveSOAP() {
        var formData = $('#soapForm').serialize();

        $.ajax({
            url: base_url + "SoapController/save_soap",
            method: "POST",
            data: formData,
            success: function(response) {
                try {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        updateRiwayatPerawatan();
                        clearSOAPForm();
                    } else {
                        alert('Gagal menyimpan data SOAP: ' + res.message);
                    }
                } catch (error) {
                    console.error('Error parsing response JSON:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error during SOAP form submission:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }

    function updateSOAP() {
        var formData = $('#soapForm').serialize();

        $.ajax({
            url: base_url + "SoapController/update_soap",
            method: "POST",
            data: formData,
            success: function(response) {
                try {
                    var res = JSON.parse(response);

                    if (res.status === 'success') {
                        updateRiwayatPerawatan();
                        clearSOAPForm();
                    } else {
                        alert('Gagal memperbarui data SOAP: ' + res.message);
                    }
                } catch (error) {
                    console.error('Error parsing response JSON:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error during SOAP form update:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }

    function updateRiwayatPerawatan() {
        var noRawat = $('[name="no_rawat"]').val();
        $.ajax({
            url: base_url + "SoapController/get_soap_data",
            method: "GET",
            data: { no_rawat: noRawat },
            success: function(data) {
                try {
                    var soapDataList = JSON.parse(data);
                    var tableBody = '';
                    soapDataList.forEach(function(item, index) {
                        tableBody += '<tr>';
                        tableBody += '<td style="width: 30px; text-align: center;">' + (index + 1) + '</td>';
                        tableBody += '<td>' + 
                                      '<b>Rawat Jalan</b><br>' + 
                                      (item.tgl_perawatan || 'N/A') + ' ' + 
                                      (item.jam_rawat || 'N/A') + '<br>' + 
                                      (item.nik || 'N/A') + ' ' + 
                                      (item.nama || 'N/A') + 
                                      '</td>';
                        tableBody += '<td>' + 
                                      '<table class="table table-sm table-bordered" width="100%" cellspacing="0">' +
                                      '<tr>' +
                                      '<td><b>Suhu:</b> ' + (item.suhu_tubuh || 'N/A') + '</td>' +
                                      '<td><b>Tensi:</b> ' + (item.tensi || 'N/A') + '</td>' +
                                      '<td><b>Nadi:</b> ' + (item.nadi || 'N/A') + '</td>' +
                                      '<td><b>Respirasi:</b> ' + (item.respirasi || 'N/A') + '</td>' +
                                      '</tr>' +
                                      '<tr>' +
                                      '<td><b>Tinggi:</b> ' + (item.tinggi || 'N/A') + '</td>' +
                                      '<td><b>Berat:</b> ' + (item.berat || 'N/A') + '</td>' +
                                      '<td><b>SpO2:</b> ' + (item.spo2 || 'N/A') + '</td>' +
                                      '<td><b>GCS:</b> ' + (item.gcs || 'N/A') + '</td>' +
                                      '</tr>' +
                                      '<tr>' +
                                      '<td colspan="2"><b>Kesadaran:</b> ' + (item.kesadaran || 'N/A') + '</td>' +
                                      '<td><b>Alergi:</b> ' + (item.alergi || 'N/A') + '</td>' +
                                      '<td><b>Lingkar Perut:</b> ' + (item.lingkar_perut || 'N/A') + '</td>' +
                                      '<td></td>' +
                                      '</tr>' +
                                      '</table>' +
                                      '<table class="table table-sm table-bordered" width="100%" cellspacing="0">' +
                                      '<tr><td><b>Subyektif:</b></td><td>' + (item.keluhan || 'N/A') + '</td></tr>' +
                                      '<tr><td><b>Assesment:</b></td><td>' + (item.penilaian || 'N/A') + '</td></tr>' +
                                      '<tr><td><b>Plan:</b></td><td>' + (item.rtl || 'N/A') + '</td></tr>' +
                                      '<tr><td><b>Instruksi:</b></td><td>' + (item.instruksi || 'N/A') + '</td></tr>' +
                                      '<tr><td><b>Evaluasi:</b></td><td>' + (item.evaluasi || 'N/A') + '</td></tr>' +
                                      '</table>' +
                                      '<div class="d-flex justify-content-start mt-2">' +
                                      '<button type="button" class="btn btn-warning btn-sm mr-2" onclick="editSOAP(\'' + item.no_rawat + '\', \'' + item.tgl_perawatan + '\')">' +
                                      '<i class="fas fa-edit"></i> Edit</button>' +
                                      '<button type="button" class="btn btn-danger btn-sm" onclick="deleteSOAP(\'' + item.no_rawat + '\', \'' + item.nip + '\', \'' + item.jam_rawat + '\')">' +
                                      '<i class="fas fa-trash-alt"></i> Hapus</button>' +
                                      '</div>' +
                                      '</td>';
                        tableBody += '</tr>';
                    });
                    $('#soapDataList').html(tableBody);
                } catch (error) {
                    console.error('Error parsing SOAP data:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching SOAP data:', textStatus, errorThrown);
                alert('Terjadi kesalahan: ' + textStatus);
            }
        });
    }

    window.deleteSOAP = function(no_rawat, nip) {
        if (confirm('Apakah Anda yakin ingin menghapus SOAP ini?')) {
            $.ajax({
                url: base_url + "SoapController/delete_soap",
                method: "POST",
                data: {
                    no_rawat: no_rawat,
                    nip: nip
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('SOAP berhasil dihapus');
                        updateRiwayatPerawatan();
                        clearSOAPForm();
                    } else {
                        alert('Gagal menghapus SOAP: ' + res.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error deleting SOAP:', textStatus, errorThrown);
                    alert('Terjadi kesalahan: ' + textStatus);
                }
            });
        }
    }

    function clearSOAPForm() {
        $('#soapForm').find('input:text, input[type=date], input[type=time], textarea').val('');
        $('#soapForm').find('select').prop('selectedIndex', 0);
        resetTimeToCurrent(); // Setel jam ke waktu sekarang
        $('#soapForm').find('#tanggal').val(new Date().toISOString().split('T')[0]);
        $('#saveButton').show();
        $('#updateButton').hide();
    }

    function resetTimeToCurrent() {
        var currentTime = new Date();
        var formattedTime = currentTime.toLocaleTimeString('it-IT');
        $('#jam').val(formattedTime);
    }

    updateRiwayatPerawatan();

    $('#updateButton').hide();
});


// $(document).ready(function() {
//     $('#soapForm').submit(function(event) {
//         event.preventDefault();

//         var jam = $('#jam').val(); 
//         var originalJam = $('#original_jam').val();

//         if (jam === originalJam.substring(0, 5)) {
//             jam = originalJam;
//         }
//         $('#jam').val(jam);
//         if ($('#saveButton').is(':visible')) {
//             saveSOAP();
//         } else {
//             updateSOAP();
//         }
//     });
    
//     function saveSOAP() 
//     {
//         var formData = $('#soapForm').serialize();

//         $.ajax({
//             url: base_url + "SoapController/save_soap",
//             method: "POST",
//             data: formData,
//             success: function(response) {
//                 try {
//                     var res = JSON.parse(response);
//                     if (res.status === 'success') {
//                         updateRiwayatPerawatan();
//                         clearSOAPForm();
//                     } else {
//                         alert('Gagal menyimpan data SOAP: ' + res.message);
//                     }
//                 } catch (error) {
//                     console.error('Error parsing response JSON:', error);
//                 }
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 console.error('Error during SOAP form submission:', textStatus, errorThrown);
//                 alert('Terjadi kesalahan: ' + textStatus);
//             }
//         });
//     }

//     function updateSOAP() {
//         var formData = $('#soapForm').serialize();

//         $.ajax({
//             url: base_url + "SoapController/update_soap",
//             method: "POST",
//             data: formData,
//             success: function(response) {
//                 try {
//                     var res = JSON.parse(response);

//                     if (res.status === 'success') {
//                         updateRiwayatPerawatan();
//                         clearSOAPForm();
//                     } else {
//                         alert('Gagal memperbarui data SOAP: ' + res.message);
//                     }
//                 } catch (error) {
//                     console.error('Error parsing response JSON:', error);
//                 }
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 console.error('Error during SOAP form update:', textStatus, errorThrown);
//                 alert('Terjadi kesalahan: ' + textStatus);
//             }
//         });
//     }


//     // Fungsi untuk mengedit data SOAP
//     window.editSOAP = function(no_rawat, tgl_perawatan) {
//         $.ajax({
//             url: base_url + "SoapController/get_single_soap",
//             method: "GET",
//             data: {
//                 no_rawat: no_rawat,
//                 tgl_perawatan: tgl_perawatan
//             },
//             success: function(response) {
//                 try {
//                     var res = JSON.parse(response);
//                     if (res.status === 'success') {
//                         var data = res.data;
//                         $('#tanggal').val(data.tgl_perawatan);
//                         $('#jam').val(data.jam_rawat);
//                         $('#original_jam').val(data.jam_rawat);
//                         $('#tensi').val(data.tensi);
//                         $('#suhu_tubuh').val(data.suhu_tubuh);
//                         $('#nadi').val(data.nadi);
//                         $('#respirasi').val(data.respirasi);
//                         $('#tinggi').val(data.tinggi);
//                         $('#berat').val(data.berat);
//                         $('#kesadaran').val(data.kesadaran);
//                         $('#spo2').val(data.spo2);
//                         $('#gcs').val(data.gcs);
//                         $('#alergi').val(data.alergi);
//                         $('#lingkar_perut').val(data.lingkar_perut);
//                         $('#keluhan').val(data.keluhan);
//                         $('#pemeriksaan').val(data.pemeriksaan);
//                         $('#penilaian').val(data.penilaian);
//                         $('#rtl').val(data.rtl);
//                         $('#instruksi').val(data.instruksi);
//                         $('#evaluasi').val(data.evaluasi);
                        
//                         $('#saveButton').hide();
//                         $('#updateButton').show();
//                     } else {
//                         alert('Gagal mengambil data SOAP: ' + res.message);
//                     }
//                 } catch (error) {
//                     console.error('Error parsing SOAP data:', error);
//                 }
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 console.error('Error fetching SOAP data:', textStatus, errorThrown);
//                 alert('Terjadi kesalahan: ' + textStatus);
//             }
//         });
//     }

//     function updateRiwayatPerawatan() {
//     var noRawat = $('[name="no_rawat"]').val();
//     $.ajax({
//         url: base_url + "SoapController/get_soap_data",
//         method: "GET",
//         data: { no_rawat: noRawat },
//         success: function(data) {
//             try {
//                 var soapDataList = JSON.parse(data);
//                 var tableBody = '';
//                 soapDataList.forEach(function(item, index) {
//                     tableBody += '<tr>';
//                     tableBody += '<td style="width: 30px; text-align: center;">' + (index + 1) + '</td>'; // Lebar disesuaikan menjadi 30px
//                     tableBody += '<td>' + 
//                                   '<b>Rawat Jalan</b><br>' + 
//                                   (item.tgl_perawatan || 'N/A') + ' ' + 
//                                   (item.jam_rawat || 'N/A') + '<br>' + 
//                                   (item.nik || 'N/A') + ' ' + 
//                                   (item.nama || 'N/A') + 
//                                   '</td>';
//                     tableBody += '<td>' + 
//                                   '<table class="table table-sm table-bordered" width="100%" cellspacing="0">' +
//                                   '<tr>' +
//                                   '<td><b>Suhu:</b> ' + (item.suhu_tubuh || 'N/A') + '</td>' +
//                                   '<td><b>Tensi:</b> ' + (item.tensi || 'N/A') + '</td>' +
//                                   '<td><b>Nadi:</b> ' + (item.nadi || 'N/A') + '</td>' +
//                                   '<td><b>Respirasi:</b> ' + (item.respirasi || 'N/A') + '</td>' +
//                                   '</tr>' +
//                                   '<tr>' +
//                                   '<td><b>Tinggi:</b> ' + (item.tinggi || 'N/A') + '</td>' +
//                                   '<td><b>Berat:</b> ' + (item.berat || 'N/A') + '</td>' +
//                                   '<td><b>SpO2:</b> ' + (item.spo2 || 'N/A') + '</td>' +
//                                   '<td><b>GCS:</b> ' + (item.gcs || 'N/A') + '</td>' +
//                                   '</tr>' +
//                                   '<tr>' +
//                                   '<td colspan="2"><b>Kesadaran:</b> ' + (item.kesadaran || 'N/A') + '</td>' +
//                                   '<td><b>Alergi:</b> ' + (item.alergi || 'N/A') + '</td>' +
//                                   '<td><b>Lingkar Perut:</b> ' + (item.lingkar_perut || 'N/A') + '</td>' +
//                                   '<td></td>' +
//                                   '</tr>' +
//                                   '</table>' +
//                                   '<table class="table table-sm table-bordered" width="100%" cellspacing="0">' +
//                                   '<tr><td><b>Subyektif:</b></td><td>' + (item.keluhan || 'N/A') + '</td></tr>' +
//                                   '<tr><td><b>Assesment:</b></td><td>' + (item.penilaian || 'N/A') + '</td></tr>' +
//                                   '<tr><td><b>Plan:</b></td><td>' + (item.rtl || 'N/A') + '</td></tr>' +
//                                   '<tr><td><b>Instruksi:</b></td><td>' + (item.instruksi || 'N/A') + '</td></tr>' +
//                                   '<tr><td><b>Evaluasi:</b></td><td>' + (item.evaluasi || 'N/A') + '</td></tr>' +
//                                   '</table>' +
//                                   '<div class="d-flex justify-content-start mt-2">' +
//                                   '<button type="button" class="btn btn-warning btn-sm mr-2" onclick="editSOAP(\'' + item.no_rawat + '\', \'' + item.tgl_perawatan + '\')">' +
//                                   '<i class="fas fa-edit"></i> Edit</button>' +
//                                   '<button type="button" class="btn btn-danger btn-sm" onclick="deleteSOAP(\'' + item.no_rawat + '\', \'' + item.nip + '\', \'' + item.jam_rawat + '\')">' +
//                                   '<i class="fas fa-trash-alt"></i> Hapus</button>' +
//                                   '</div>' +
//                                   '</td>';
//                     tableBody += '</tr>';
//                 });
//                 $('#soapDataList').html(tableBody);
//             } catch (error) {
//                 console.error('Error parsing SOAP data:', error);
//             }
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             console.error('Error fetching SOAP data:', textStatus, errorThrown);
//             alert('Terjadi kesalahan: ' + textStatus);
//         }
//     });
// }
//     window.deleteSOAP = function(no_rawat, nip) 
//     {
//         if (confirm('Apakah Anda yakin ingin menghapus SOAP ini?')) {
//             $.ajax({
//                 url: base_url + "SoapController/delete_soap",
//                 method: "POST",
//                 data: {
//                     no_rawat: no_rawat,
//                     nip: nip
//                 },
//                 success: function(response) {
//                     var res = JSON.parse(response);
//                     if (res.status === 'success') {
//                         alert('SOAP berhasil dihapus');
//                         updateRiwayatPerawatan();
//                         clearSOAPForm();
//                     } else {
//                         alert('Gagal menghapus SOAP: ' + res.message);
//                     }
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     console.error('Error deleting SOAP:', textStatus, errorThrown);
//                     alert('Terjadi kesalahan: ' + textStatus);
//                 }
//             });
//         }
//     }


//     function clearSOAPForm() {
//         $('#soapForm').find('input:text, input[type=date], input[type=time], textarea').val('');
//         $('#soapForm').find('select').prop('selectedIndex', 0);
//         resetTimeToCurrent(); // Setel jam ke waktu sekarang
//         $('#soapForm').find('#tanggal').val(new Date().toISOString().split('T')[0]);
//         $('#saveButton').show();
//         $('#updateButton').hide();
//     }

//     function resetTimeToCurrent() {
//         var currentTime = new Date();
//         var formattedTime = currentTime.toLocaleTimeString('it-IT');
//         $('#jam').val(formattedTime);
//     }

//     updateRiwayatPerawatan();

//     $('#updateButton').hide();
// });
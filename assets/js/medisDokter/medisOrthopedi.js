$(document).ready(function(){
    loadAsesmenMedisOrthopediData();
});

function submitAsesmenMedisOrthopedi(event) {
    event.preventDefault();

    var formData = $('#asesmenMedisOrthopediForm').serialize();
    var canvas = document.getElementById('lokalisCanvas');
    var imageData = canvas.toDataURL('image/png');
    var no_rawat = document.getElementById('no_rawat').value;

    // Disable tombol simpan untuk mencegah duplikasi
    $('#submitBtn').prop('disabled', true);

    $.ajax({
        url: base_url + "MedisOrthopediController/save_asesmenMedisOrthopedi",
        method: "POST",
        data: formData,
    }).done(function(response) {
        try {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                if (imageData && imageData !== "data:,") {
                    return $.ajax({
                        url: base_url + "MedisOrthopediController/saveLokalisImage",
                        method: "POST",
                        data: {
                            imageData: imageData,
                            no_rawat: no_rawat
                        }
                    });
                } else {
                    loadAsesmenMedisOrthopediData();
                    return Promise.resolve();
                }
            } else {
                $('#error_message').text('Gagal menyimpan asesmen: ' + res.message).show();
                return Promise.reject();
            }
        } catch (error) {
            console.error('Error parsing response:', error);
            return Promise.reject();
        }
    }).done(function(imageResponse) {
        try {
            if (imageResponse) {
                let imgRes = JSON.parse(imageResponse);
                if (imgRes.status === 'success' || imgRes.message.includes('sudah ada')) {
                    loadAsesmenMedisOrthopediData();
                    alert(imgRes.message);
                } else {
                    alert('Gagal menyimpan gambar: ' + imgRes.message);
                }
            }
        } catch (error) {
            console.error('Error parsing image response:', error);
            alert('Terjadi kesalahan saat menyimpan gambar.');
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Terjadi kesalahan: ' + textStatus);
    }).always(function() {
        // Re-enable tombol setelah proses selesai
        $('#submitBtn').prop('disabled', false);

        // Reset form dan clear canvas setelah data berhasil disimpan
        $('#asesmenMedisOrthopediForm')[0].reset();
        clearCanvas(); // Bersihkan canvas setelah berhasil menyimpan data
        resetForm(); // Kembali ke mode tambah data setelah update atau tambah
    });
}

// Objek global untuk menyimpan data asesmen
var asesmenMedisOrthopediData = {};

function loadAsesmenMedisOrthopediData() {
    var noRawat = $('[name="no_rawat"]').val();
    $.ajax({
        url: base_url + "MedisOrthopediController/get_asesmenMedisOrthopedi_data",
        method: "GET",
        data: { no_rawat: noRawat },
        success: function(data) {
            try {
                var asesmenList = JSON.parse(data);
                var tableBody = '';
                
                // Dapatkan URL dasar dari konfigurasi CodeIgniter yang akan digunakan untuk mengambil gambar
                var upload_url = "<?php echo $this->config->item('upload_url'); ?>";

                // Reset asesmenData setiap kali data baru dimuat
                asesmenMedisOrthopediData = {};

                if (Array.isArray(asesmenList) && asesmenList.length > 0) {
                    asesmenList.forEach(function(asesmen, index) {
                        // Simpan data asesmen di asesmenData
                        asesmenMedisOrthopediData[asesmen.no_rawat] = asesmen;

                        tableBody += '<tr>';
                        tableBody += '<td style="width: 30px; text-align: center;">' + (index + 1) + '</td>';
                        tableBody += '<td>';
                        tableBody += '<table class="table table-sm table-bordered" width="100%" cellspacing="0">';

                       if (asesmen.tanggal) tableBody += '<td colspan="3"><b style="color: maroon;">Tanggal :</b><br/> <span style="color: black;">' + asesmen.tanggal + '</span></td>';
                        if (asesmen.nm_dokter) tableBody += '<td colspan="3"><b style="color: maroon;">Dokter :</b><br/> <span style="color: black;">' + asesmen.nm_dokter + '</span></td>';
                        if (asesmen.anamnesis) tableBody += '<td colspan="3"><b style="color: maroon;">Anamnesis :</b><br/> <span style="color: black;">' + asesmen.anamnesis + '</span></td>';
                        if (asesmen.hubungan) tableBody += '<td colspan="3"><b style="color: maroon;">Hubungan :</b><br/> <span style="color: black;">' + asesmen.hubungan + '</span></td>';

                        tableBody += '<tr>';
                        if (asesmen.kesadaran) tableBody += '<td colspan="3"><b style="color: maroon;">Kesadaran:</b> <span style="color: black;">' + asesmen.kesadaran + '</span></td>';
                        if (asesmen.status) tableBody += '<td colspan="3"><b style="color: maroon;">Status Nutrisi:</b> <span style="color: black;">' + asesmen.status + '</span></td>';
                        if (asesmen.td) tableBody += '<td colspan="2"><b style="color: maroon;">TD:</b> <span style="color: black;">' + asesmen.td + '</span></td>';
                        if (asesmen.nadi) tableBody += '<td colspan="2"><b style="color: maroon;">Nadi:</b> <span style="color: black;">' + asesmen.nadi + '</span></td>';
                        if (asesmen.suhu) tableBody += '<td colspan="2"><b style="color: maroon;">Suhu:</b> <span style="color: black;">' + asesmen.suhu + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.rr) tableBody += '<td colspan="3"><b style="color: maroon;">RR/Menit:</b> <span style="color: black;">' + asesmen.rr + '</span></td>';
                        if (asesmen.bb) tableBody += '<td colspan="3"><b style="color: maroon;">BB:</b> <span style="color: black;">' + asesmen.bb + '</span></td>';
                        if (asesmen.nyeri) tableBody += '<td colspan="3"><b style="color: maroon;">Nyeri:</b> <span style="color: black;">' + asesmen.nyeri + '</span></td>';
                        if (asesmen.gcs) tableBody += '<td colspan="3"><b style="color: maroon;">GCS:</b> <span style="color: black;">' + asesmen.gcs + '</span></td>';
                        tableBody += '</tr>';
                    
                        tableBody += '<tr>';
                        if (asesmen.kepala) tableBody += '<td colspan="3"><b style="color: maroon;">Kepala:</b><br/> <span style="color: black;">' + asesmen.kepala + '</span></td>';
                        if (asesmen.thoraks) tableBody += '<td colspan="3"><b style="color: maroon;">Thoraks:</b><br/> <span style="color: black;">' + asesmen.thoraks + '</span></td>';
                        if (asesmen.abdomen) tableBody += '<td colspan="3"><b style="color: maroon;">Abdomen:</b><br/> <span style="color: black;">' + asesmen.abdomen + '</span></td>';
                        if (asesmen.ekstremitas) tableBody += '<td colspan="3"><b style="color: maroon;">Ekstremitas:</b><br/> <span style="color: black;">' + asesmen.ekstremitas + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.columna) tableBody += '<td colspan="4"><b style="color: maroon;">Columna:</b><br/> <span style="color: black;">' + asesmen.columna + '</span></td>';
                        if (asesmen.muskulos) tableBody += '<td colspan="4"><b style="color: maroon;">Muskulos:</b><br/> <span style="color: black;">' + asesmen.muskulos + '</span></td>';
                        if (asesmen.genetalia) tableBody += '<td colspan="4"><b style="color: maroon;">Genetalia:</b><br/> <span style="color: black;">' + asesmen.genetalia + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.lainnya) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Keterangan Lainnya:</b><br/> <span style="color: black;">' + asesmen.lainnya + '</span></td></tr>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.image) {
                            // Hapus baris gambar lama (jika ada) sebelum menambahkan yang baru
                            $('#asesmenMedisOrthopediTable tbody tr.gambar-lokalis-row').remove();
                            var imageUrl = uploadUrl + asesmen.image; // Pastikan uploadUrl sudah diinisialisasi
                            console.log('Image URL:', imageUrl); // Debugging URL
                            // Tambahkan baris gambar baru
                            tableBody += '<tr class="gambar-lokalis-row">'; // Tambahkan class untuk identifikasi
                            tableBody += '<td colspan="12" style="text-align:center;"><b style="color: maroon;">Gambar Lokalis:</b><br/>';
                            tableBody += '<img src="' + imageUrl + '" alt="Gambar Lokalis" style="max-width: 100%; height: auto; margin: 10px auto;" />';
                            tableBody += '<br/><button type="button" class="btn btn-danger btn-sm" onclick="deleteLokalisImage(\'' + asesmen.no_rawat + '\')">Hapus Gambar</button>';
                            tableBody += '</td>';
                            tableBody += '</tr>';
                        }
                        tableBody += '<tr>';
                        if (asesmen.ket_fisik) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Keterangan Fisik:</b><br/> <span style="color: black;">' + asesmen.ket_fisik + '</span></td></tr>';
                        tableBody += '</tr>';

                        if (asesmen.ket_lokalis) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Keterangan Lokalis:</b><br/> <span style="color: black;">' + asesmen.ket_lokalis + '</span></td></tr>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.lab) tableBody += '<td colspan="4"><b style="color: maroon;">Laboratorium:</b><br/> <span style="color: black;">' + asesmen.lab + '</span></td>';
                        if (asesmen.rad) tableBody += '<td colspan="4"><b style="color: maroon;">Radiologi:</b><br/> <span style="color: black;">' + asesmen.rad + '</span></td>';
                        if (asesmen.pemeriksaan) tableBody += '<td colspan="4"><b style="color: maroon;">Pemeriksaan Lainnya:</b><br/> <span style="color: black;">' + asesmen.pemeriksaan + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.diagnosis) tableBody += '<td colspan="6"><b style="color: maroon;">Diagnosis Utama:</b><br/> <span style="color: black;">' + asesmen.diagnosis + '</span></td>';
                        if (asesmen.diagnosis2) tableBody += '<td colspan="6"><b style="color: maroon;">Diagnosis Sekunder:</b><br/> <span style="color: black;">' + asesmen.diagnosis2 + '</span></td>';
                        tableBody += '</tr>';

                        tableBody += '<tr>';
                        if (asesmen.permasalahan) tableBody += '<td colspan="4"><b style="color: maroon;">Permasalahan:</b><br/> <span style="color: black;">' + asesmen.permasalahan + '</span></td>';
                        if (asesmen.terapi) tableBody += '<td colspan="4"><b style="color: maroon;">Terapi:</b><br/> <span style="color: black;">' + asesmen.terapi + '</span></td>';
                        if (asesmen.tindakan) tableBody += '<td colspan="4"><b style="color: maroon;">Tindakan:</b><br/> <span style="color: black;">' + asesmen.tindakan + '</span></td>';
                        tableBody += '</tr>';

                        if (asesmen.edukasi) tableBody += '<tr><td colspan="12"><b style="color: maroon;">Edukasi:</b><br/> <span style="color: black;">' + asesmen.edukasi + '</span></td></tr>';

                        // Tambah tombol Edit dan Hapus
                        tableBody += '<tr><td colspan="12">';
                        tableBody += '<button type="button" class="btn btn-warning btn-sm" onclick="editAsesmenMedisOrthopedi(\'' + asesmen.no_rawat + '\')">Edit</button> ';
                        tableBody += '<button type="button" class="btn btn-danger btn-sm" onclick="deleteAsesmenMedisOrthopedi(\'' + asesmen.no_rawat + '\')">Hapus</button>';
                        tableBody += '</td></tr>';

                        tableBody += '</table>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    });
                } else {
                    tableBody += '<tr><td colspan="3" class="text-center">Data masih kosong</td></tr>';
                }

                $('#asesmenMedisOrthopediTable tbody').html(tableBody);
            } catch (error) {
                console.error('Error parsing asesmen data:', error);
                $('#asesmenMedisOrthopediTable tbody').html('<tr><td colspan="3" class="text-center">Terjadi kesalahan dalam memuat data</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching asesmen data:', textStatus, errorThrown);
            $('#asesmenMedisOrthopediTable tbody').html('<tr><td colspan="3" class="text-center">Terjadi kesalahan dalam memuat data</td></tr>');
        }
    });
}

let canvas = document.getElementById('lokalisCanvas');
let ctx = canvas.getContext('2d');
let painting = false;

// Gambar latar belakang ketika halaman selesai dimuat
$(document).ready(function() {
    let image = new Image();
    image.src = $('#lokalisImage').attr('src');
    image.onload = function() {
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
    };
});

function startPosition(e) {
    painting = true;
    draw(e);
}

function endPosition() {
    painting = false;
    ctx.beginPath();
}

function draw(e) {
    if (!painting) return;

    // Mendapatkan posisi kursor relatif terhadap canvas
    const rect = canvas.getBoundingClientRect();
    const x = (e.clientX - rect.left) / (rect.right - rect.left) * canvas.width;
    const y = (e.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height;

    ctx.lineWidth = 5;
    ctx.lineCap = 'round';
    ctx.strokeStyle = 'red';

    ctx.lineTo(x, y);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(x, y);
}

function resetLokalis() {
    ctx.clearRect(0, 0, canvas.width, canvas.height); // Menghapus semua coretan di canvas
    ctx.drawImage(document.getElementById('lokalisImage'), 0, 0, canvas.width, canvas.height); // Mengembalikan gambar awal
}

canvas.addEventListener('mousedown', startPosition);
canvas.addEventListener('mouseup', endPosition);
canvas.addEventListener('mousemove', draw);

function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    // Gambarkan ulang gambar latar belakang
    let image = new Image();
    image.src = $('#lokalisImage').attr('src');
    image.onload = function() {
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
    };
}

function saveLokalis() {
    let canvas = document.getElementById('lokalisCanvas');
    let imageData = canvas.toDataURL('image/png');
    let no_rawat = document.getElementById('no_rawat').value;

    $.ajax({
        url: base_url + "MedisOrthopediController/saveLokalisImage",
        method: "POST",
        data: {
            imageData: imageData,
            no_rawat: no_rawat
        },
        success: function(response) {
            try {
                let res = JSON.parse(response);

                if (res.status === 'success') {
                    alert(res.message);
                    loadAsesmenMedisOrthopediData(); // Panggil fungsi untuk memuat ulang data setelah gambar berhasil disimpan
                } else {
                    alert('Gagal menyimpan gambar: ' + res.message);
                }

            } catch (error) {
                console.error('Error parsing JSON:', error);
                console.log('Response received:', response);
                alert('Terjadi kesalahan saat menyimpan gambar.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error saving lokalis image: ' + textStatus, errorThrown);
            alert('Gagal menyimpan gambar karena kesalahan pada jaringan atau server.');
        }
    });
}

function deleteAsesmenMedisOrthopedi(no_rawat) {
    if (confirm('Apakah Anda yakin ingin menghapus asesmen ini beserta gambar yang terkait?')) {
        $.ajax({
            url: base_url + "MedisOrthopediController/delete_asesmenMedisOrthopedi",
            method: "POST",
            data: { no_rawat: no_rawat },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    // Panggil fungsi untuk menghapus gambar juga
                    deleteLokalisImage(no_rawat, function() {
                        loadAsesmenMedisOrthopediData(); // Muat ulang data asesmen setelah penghapusan
                    });
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

function deleteLokalisImage(no_rawat, callback) {
    $.ajax({
        url: base_url + "MedisOrthopediController/deleteLokalisImage",
        method: "POST",
        data: { no_rawat: no_rawat },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.status === 'success' || res.message === 'File gambar tidak ditemukan.') {
                loadAsesmenMedisOrthopediData();
                if (callback) {
                    callback(); // Panggil callback untuk memuat ulang data
                }
            } else {
                if (res.message !== 'File gambar tidak ditemukan.') {
                    alert('Gagal menghapus gambar: ' + res.message);
                    loadAsesmenMedisOrthopediData();
                }
                if (callback) {
                    callback(); // Tetap panggil callback untuk melanjutkan penghapusan asesmen
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error deleting image: ' + textStatus, errorThrown);
            if (callback) {
                callback(); // Tetap panggil callback meskipun terjadi kesalahan pada penghapusan gambar
            }
        }
    });
}

// Fungsi untuk mengedit asesmen
function editAsesmenMedisOrthopedi(no_rawat) {
    // Dapatkan data asesmen berdasarkan no_rawat dari asesmenData
    var asesmen = asesmenMedisOrthopediData[no_rawat];

    if (asesmen) {
        // Isi form dengan data asesmen
        $('#no_rawat').val(asesmen.no_rawat);
        $('#kd_dokter').val(asesmen.kd_dokter);
        $('#tanggal_jam').val(asesmen.tanggal.replace(' ', 'T'));
        $('#anamnesis').val(asesmen.anamnesis);
        $('#keluhan_utama').val(asesmen.keluhan_utama);
        $('#hubungan').val(asesmen.hubungan);
        $('#rps').val(asesmen.rps);
        $('#rpd').val(asesmen.rpd);
        $('#rpk').val(asesmen.rpk);
        $('#rpo').val(asesmen.rpo);
        $('#status').val(asesmen.status);
        $('#nyeri').val(asesmen.nyeri);
        $('#alergi').val(asesmen.alergi);
        $('#keadaan').val(asesmen.keadaan);
        $('#gcs').val(asesmen.gcs);
        $('#kesadaran').val(asesmen.kesadaran);
        $('#td').val(asesmen.td);
        $('#nadi').val(asesmen.nadi);
        $('#rr').val(asesmen.rr);
        $('#suhu').val(asesmen.suhu);
        $('#spo').val(asesmen.spo);
        $('#bb').val(asesmen.bb);
        $('#tb').val(asesmen.tb);
        $('#kepala').val(asesmen.kepala);
        $('#thoraks').val(asesmen.thoraks);
        $('#abdomen').val(asesmen.abdomen);
        $('#genitalia').val(asesmen.genitalia);
        $('#ekstremitas').val(asesmen.ekstremitas);
        $('#columna').val(asesmen.columna);
        $('#muskulos').val(asesmen.muskulos);
        $('#lainnya').val(asesmen.lainnya);
        $('#ket_fisik').val(asesmen.ket_fisik);
        $('#lab').val(asesmen.lab);
        $('#rad').val(asesmen.rad);
        $('#pemeriksaan').val(asesmen.pemeriksaan);
        $('#ket_lokalis').val(asesmen.ket_lokalis);
        $('#penunjang').val(asesmen.penunjang);
        $('#diagnosis').val(asesmen.diagnosis);
        $('#diagnosis2').val(asesmen.diagnosis2);
        $('#permasalahan').val(asesmen.permasalahan);
        $('#terapi').val(asesmen.terapi);
        $('#tindakan').val(asesmen.tindakan);
        $('#edukasi').val(asesmen.edukasi);

        // Pindahkan scroll ke form setelah data diisi
        $('#asesmenMedisOrthopediForm')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });

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
function updateAsesmenMedisOrthopedi(event) {
    event.preventDefault(); // Mencegah default form submit behavior

    var formData = $('#asesmenMedisOrthopediForm').serialize();

    $.ajax({
        url: base_url + "MedisOrthopediController/update_asesmenMedisOrthopedi",
        method: "POST",
        data: formData,
        success: function(response) {
            try {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#asesmenMedisOrthopediForm')[0].reset(); 
                    clearCanvas(); // Bersihkan canvas setelah update
                    loadAsesmenMedisOrthopediData(); 
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
    $('#asesmenMedisOrthopediForm')[0].reset(); 
    clearCanvas(); // Bersihkan canvas setelah reset
    $('#submitBtn').show();
    $('#updateButton').hide();
    $('#cancelButton').hide();
}

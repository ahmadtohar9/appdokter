<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Data</title>
    <!-- CSS untuk menghindari penyalinan -->
    <style>
        .no-copy {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        th {
            text-align: center;
        }
    </style>
</head>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Penilaian Medis Anak</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="asesmenMedisAnakTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hasil Penilaian Medis Anak</th>
                    </tr>
                </thead>
                <tbody id="asesmenMedisKandunganDataList">
                    <!-- Data asesmen akan dimuat di sini oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    document.addEventListener('copy', function(e) {
        e.preventDefault();
        alert('Maaf ini Data Rahasia dan Tidak Diperbolehkan Menyalin isi File Rekam Medis Elektronik Secara Sepihak.');
    });
</script>

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
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 10;
        }
        th {
            text-align: center;
        }
    </style>
</head>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Asesmen Medis Penyakit Dalam</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="asesmenTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Parameter</th>
                        <th>Assesmen Medis Penyakit Dalam</th>
                    </tr>
                </thead>
                <tbody id="asesmenDataList">
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

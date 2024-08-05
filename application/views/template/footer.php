
                </div>
            </div>
                   <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- End of Content Wrapper -->

    <!-- jQuery and jQuery UI Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('template/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <script src="<?php echo base_url('template/vendor/jquery-easing/jquery.easing.min.js');?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('template/js/sb-admin-2.min.js');?>"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('template/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('template/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <script>
        $(document).ready(function(){
            // Initialize autocomplete
            $("#kd_penyakit").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo site_url('DokterController/get_penyakit'); ?>",
                        method: "GET",
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.kd_penyakit + ' - ' + item.nm_penyakit,
                                    value: item.kd_penyakit
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#kd_penyakit').val(ui.item.value);
                }
            });
        });

        $(document).ready(function(){
            // Initialize autocomplete
            $("#kode_brng").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo site_url('DokterController/get_DataBarang'); ?>",
                        method: "GET",
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nama_brng,
                                    value: item.kode_brng
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#kode_brng').val(ui.item.value);
                }
            });
        });

    </script>
</body>
</html>

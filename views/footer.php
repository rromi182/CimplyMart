</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright &copy;
    <?php echo date('Y'); ?> <a href="https://www.linkedin.com/in/mar%C3%ADa-romina-almeida-b9065820a/"
      style="color: #476072" target="_blank"> Desarrollado por Romina Almeida</a>.
  </strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark" style="background-color: #476072;">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo $url_base; ?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $url_base; ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!--Select2-->
<script src="<?php echo $url_base; ?>/plugins/select2/js/select2.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $url_base; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo $url_base; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Archivo de traducción en español -->
<script>
    $(document).ready(function() {
        // Verifica si la tabla ya se ha inicializado
        if ($.fn.DataTable.isDataTable('#example1')) {
            // Si ya está inicializada, destrúyela antes de volver a inicializarla
            $('#example1').DataTable().destroy();
        }

        // Inicializa la tabla con el idioma español
        $('#example1').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }
        });
    });
</script>

<!-- Script para inicializar Select2 con mensajes en español -->
<script>
    $(document).ready(function() {
        $('.select2').select2({
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            }
        });
    });
</script>
<!-- ChartJS -->
<script src="<?php echo $url_base; ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $url_base; ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $url_base; ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $url_base; ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $url_base; ?>/plugins/moment/moment.min.js"></script>
<script src="<?php echo $url_base; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $url_base; ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $url_base; ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $url_base; ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $url_base; ?>/dist/js/adminlte.js"></script>


</body>

</html>
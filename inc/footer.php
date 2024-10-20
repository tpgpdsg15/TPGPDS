</div> <!-- Cerramos el container del header-->

    <footer class="footer">
        <div class="footer-content">
            <p>Pagina web: <a href="https://www.unso.edu.ar/es/" target="_blank">UNSO</a></p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#flash-msg").delay(7000).fadeOut("slow");
        });
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
<link rel="stylesheet" href="style.css">
</body>
</html>

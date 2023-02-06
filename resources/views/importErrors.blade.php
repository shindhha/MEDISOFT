<!DOCTYPE html>
<html>
@include('includes/header')

<body>
<div class="container-fluid h-100  text-white">
    <div class="row h-100">
        <!-- Menu -->
        @include('includes/sideBar')
        <!-- Main page -->
        <div class="col-md-11 h-100 text-center">
            <!-- Bandeau outils -->

            @include('includes/navbar')

            <span class="fs-1 d-md-none d-sm-block text-green"> Erreurs d'importations </span>
            <!-- content -->
            <div class="row h-89 align-items-center text-center overflow-scroll">
                <?php
                if  (in_array  ('curl', get_loaded_extensions())) {
                    echo "cURL is installed on this server";
                }
                else {
                    echo "cURL is not installed on this server";
                }

                ?>
                <?php echo  phpinfo()?>
                <table class="table table-danger table-striped, table-hover">
                    <tr>
                        <th class="fw-bold">Nombre d'erreurs</th>
                        <th class="fw-bold">Message d'erreur</th>
                    </tr>

                </table>
                <div class="col-12">
                    <span class="fw-bold text-black">Nombre total d'erreurs : </span>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="scripts/script.js"></script>
</div>
</body>
</html>

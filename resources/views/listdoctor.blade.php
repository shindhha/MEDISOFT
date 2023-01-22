<!DOCTYPE html>
<html>
@include('includes/header')
<body onload="resizeMenu()">
<div class="container-fluid h-100  text-white">
    <div class="row h-100">
        <!-- Menu -->
       @include('includes/sideBar')
        <!-- Main page -->
        <div class="col-md-11 h-75 text-center">
            <!-- Bandeau outils -->

            @include('includes/navbar')

            <!-- content -->
            <div class="row h-100 align-items-center text-center">
                <!-- Portail de connexion -->
                <div class="container ">
                    <div class="row justify-content-center">
                        <div class=" col-md-10 col-xl-12 col-sm-7 col-12 success border-2">
                            <div class="overflow-scroll ">
                                <table class="table table-striped lightGreen table-hover">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Exerce depuis</th>
                                        <th>Téléphone</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                    @foreach($medecins as $medecin)
                                        <td>{{ $medecin->nom}}</td>
                                        <td>{{$medecin->prenom}}</td>
                                        <td>{{$medecin->dateDebutActivites}}</td>
                                        <td>{{$medecin->numTel}}</td>
                                        <td>
                                        <div class="dropdown">
                                            <span class="material-symbols-outlined" type="button" id="dropdownMenuButton1" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
                                                more_horiz
                                            </span>
                                            <div class="p-0  dropdown-menu dropdown-menu-end green text-white no-border" aria-labelledby="dropdownMenuButton1">
                                                <table class="text-white ">
                                                    <form action="/ficheMedecin/{{$medecin->idMedecin}}" method="POST" class="d-flex flex-column green">
                                                        @csrf
                                                        <tr><td><input type="submit" value="Afficher"> </td></tr>
                                                    </form>
                                                    <form action="index.php" action="POST" class="d-flex flex-column green">
                                                        <input type="hidden" name="controller" value="administrateur">
                                                        <input type="hidden" name="action" value="deleteMedecin">
                                                        <input type="hidden" name="idMedecin" value="{{$medecin->idMedecin}}">
                                                        <input type="hidden" name="idUser" value="
                                                        {{$medecin->idUser}}">

                                                        <tr><td><input type="submit"  value="Supprimer"> </td></tr>
                                                    </form>
                                                </table>            
                                            </div>
                                        </div>
                                        </td>
                                    @endforeach
                                    <tr>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="d-flex flex-row justify-content-between float-end">
                <div class="d-flex me-2 py-2 px-3 border-1 green">
                    <form action="editDoctor/addMedecin" method="post">
                        @csrf
                        
                        <input type="submit" class="green no-border text-white" value="Ajouter un médecin">
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script type="text/javascript" src="scripts/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
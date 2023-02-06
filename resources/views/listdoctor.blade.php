<!DOCTYPE html>
<html>
@include('includes/header')
<body>
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

                                    @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{ $doctor->nom}}</td>
                                        <td>{{$doctor->prenom}}</td>
                                        <td>{{$doctor->dateDebutActivites}}</td>
                                        <td>{{$doctor->numTel}}</td>
                                        <td>
                                        <div class="dropdown">
                                            <span class="material-symbols-outlined" type="button" id="dropdownMenuButton1" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
                                                more_horiz
                                            </span>
                                            <div class="p-0  dropdown-menu dropdown-menu-end green text-white no-border" aria-labelledby="dropdownMenuButton1">

                                                    <form action="{{route('doctor.show',$doctor)}}" method="get" class="d-flex flex-column green">
                                                        @csrf
                                                        <input type="submit" value="Afficher">
                                                    </form>
                                                    <form action="{{route('doctor.destroy',$doctor)}}" method="POST" class="d-flex flex-column green">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="Supprimer">
                                                    </form>

                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="d-flex flex-row justify-content-between float-end">
                <div class="d-flex me-2 py-2 px-3 border-1 green">
                    <form action="{{route('doctor.create')}}" method="get">
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

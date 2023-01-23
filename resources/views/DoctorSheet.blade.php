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
            @csrf
            <!-- Bandeau Patient -->
                <div class="blue row">
                    <div class="d-flex justify-content-between">
                        <span></span>
                        <div>
                            <span>{{ $medecin->nom}}</span> 
                            <span>{{ $medecin->prenom }}</span>
                        </div>
                        <div></div>
                    </div>
                </div>


                    <div class="container-fluid text-green mt-5">
                        <div class="row d-flex flex-column gap-5 gap-md-0 flex-md-row ">
                            <div class="col-12 col-md-6 d-flex flex-column ">
                                <h1>Informations personnelles</h1>
                                <span> AdresseFAddm
                                    <div class="border border-1 border-green d-flex">
                                        <span> {{ $medecin->adresse }}
                                        </span>
                                    </div>
                                </span>
                                <span> Code postal / Ville
                                    <div class="border border-1 border-green d-flex">
                                        <span>{{ $medecin->codePostal}}</span> / <span> {{$medecin->ville }}</span>
                                    </div>
                                </span>
                                <span> Téléphone
                                    <div class="border border-1 border-green d-flex">
                                        <span> {{ $medecin->numTel}}</span>
                                    </div>
                                </span>
                                <span>Email
                                    <div class="border border-1 border-green d-flex">
                                        <span> {{ $medecin->email}}</span>
                                    </div>
                                </span>
                            </div>
                            <div class="col-12 col-md-6 d-flex flex-column ">
                                <h1>Informations professionnelles</h1>
                                <span> Numéro RPPS
                                    <div class="border border-1 border-green d-flex">
                                        <span> {{$medecin->numRPPS}}</span>
                                    </div>
                                </span>
                                <span> Secteur d'activité
                                    <div class="border border-1 border-green d-flex">
                                        <span> {{$medecin->activite }}</span>
                                    </div>
                                </span>
                                <span> Date d'enregistrement
                                    <div class="border border-1 border-green text-black">
                                        <span>{{$medecin->dateInscription }}</span>
                                    </div>
                                </span>
                                <span>
                                    Date du début d'activité
                                    <div class="border border-1 border-green text-black">
                                        <span>{{ $medecin->dateDebutActivites }}</span>
                                    </div>
                                </span>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center text-md-end px-4 pt-3">
                    <form action="{{route('update',['id' => $id])}}" method="post">
                        @csrf
                        <input type="submit" class="green no-border text-white" value="Modifier le médecin">
                    </form>
                        
                    </div>
                    <?php dd($id); ?>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="scripts/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
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
                @if(isset($doctor->id))
                    <form method="post" action="{{route('doctor.update',$doctor)}}">
                    @method('PUT')
                @else
                    <form method="post" action="{{route('doctor.store')}}">
                @endif

                <!-- Bandeau Patient -->
                    @csrf

                    <div class="container-fluid text-green text-center text-md-start ">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h1>Informations personnelles</h1>
                                <div>
                                    Nom
                                    <input type="text" name="nom" class="form-control" value="{{old('nom',$doctor->nom)}}" placeholder="Nom">
                                </div>
                                <div>
                                    Adresse
                                    <input type="text" placeholder="adresse" name="adresse" class="form-control" value="{{old('adresse',$doctor->adresse)}}">
                                </div>
                                <div>
                                    Code postal / Ville
                                    <div class="d-flex flex-row">
                                        <input type="number" placeholder="Code Postal" class="form-control"  name="codePostal" min="1001" max="98800" value="{{old('codePostal',$doctor->codePostal)}}"> / <input type="text" name="ville" class="form-control" value="{{old('ville',$doctor->ville)}}">
                                    </div>
                                </div>
                                <div>
                                    Téléphone
                                    <input type="number" placeholder="Numéro de téléphone" name="numTel" class="form-control" min="100000000" max="799999999" value="{{old('numTel',$doctor->numTel)}}">
                                </div>
                                <div>
                                    Email
                                    <input type="text" placeholder="Adresse mail" name="email" class="form-control" value="{{old('email',$doctor->email)}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h1>Informations professionnelles</h1>
                                <div>
                                    Prenom
                                    <input type="text" name="prenom" class="form-control" value="{{old('prenom',$doctor->prenom)}}" placeholder="Prénom">
                                </div>
                                <div>
                                    Numéro RPPS
                                    <input type="text" placeholder="Numéro de RPPS" name="numRPPS" class="form-control" value="{{old('numRPPS',$doctor->numRPPS)}}">
                                </div>
                                <div>
                                    Secteur d'activité
                                    <input type="text" placeholder="Secteur d'Activite" name="activite" class="form-control" value="{{old('activite',$doctor->activite)}}">
                                </div>
                                <div>
                                    Mot de passe
                                    <input type="text" placeholder="Mot de Passe" name="password" class="form-control" value="">
                                </div>
                                <div>
                                    Date du début d'activité
                                    <input type="date" placeholder="Date début d'activité" name="dateDebutActivites" class="form-control" max="<?php echo date('Y-m-d'); ?>" value="{{old('dateDebutActivites',$doctor->dateDebutActivites)}}">
                                </div>
                            </div>

                        </div>
                        <div class="col-12 mt-3">
                            <div class="d-flex col-12 flex-row justify-content-around">
                                <input type="submit" class="btn btn-danger btn-lg" value="Annuler">
                                <input class="btn btn-success btn-lg" type="submit" value="Valider">
                            </div>
                        </div>
                    </div>
                </form>



            </div>

        </div>

        <script type="text/javascript" src="scripts/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>

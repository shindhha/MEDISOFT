<!DOCTYPE html>
<html>
@include('includes/header')
<body onload="resizeMenu()">
    <div class="container-fluid h-100  text-white">
        <div class="row h-100">
            <!-- Menu -->
            @include('includes/sideBar')
            <!-- Main page -->
            <div class="col-md-11 h-100 text-center">
                <!-- Bandeau outils -->
                @include('includes/navbar')

                
                <!-- Bandeau Patient -->
                <form method="post" action="{{$action}}" class="h-75 overflow-scroll w-100">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid text-green text-center text-md-start ">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h1>Informations personnelles</h1>
                                <div>
                                    Nom
                                    <input type="text" name="nom" class="form-control" value="<?php if(isset($medecin['nom'])) echo $medecin['nom']; ?>" class="input-grow" placeholder="Nom">
                                </div>
                                <div>
                                    Adresse
                                    <input type="text" name="adresse" class="form-control" value="<?php if(isset($medecin['adresse'])) echo $medecin['adresse'];?>" class="input-grow">
                                </div>
                                <div>
                                    Code postal / Ville
                                    <div class="d-flex flex-row">
                                        <input type="number" class="form-control"  name="codePostal" min="1001" max="98800" value="<?php if(isset($medecin['codePostal'])) echo $medecin['codePostal']; ?>" class="input-grow"> / <input type="text" name="ville" class="form-control" value="<?php if(isset($medecin['codePostal'])) echo $medecin['ville']; ?>" class="input-grow">
                                    </div>
                                </div>
                                <div>
                                    Téléphone
                                    <input type="number" name="numTel" class="form-control" min="100000000" max="799999999" value="<?php if(isset($medecin['numTel'])) echo $medecin['numTel'];?>" class="input-grow">
                                </div>
                                <div>
                                    <?php if (isset($emailError)) echo $emailError; ?>
                                    Email
                                    <input type="text" name="email" class="form-control" value="<?php if(isset($medecin['email'])) echo $medecin['email']; ?>" class="input-grow">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h1>Informations professionnelles</h1>
                                <div>
                                    Prenom
                                    <input type="text" name="prenom" class="form-control" value="<?php if(isset($medecin['nom'])) echo $medecin['prenom'];?>" class="input-grow" placeholder="Prénom">
                                </div>
                                <div>
                                    Numéro RPPS
                                    <?php if (isset($numRPPSError)) echo $numRPPSError; ?>
                                    <input type="text" name="numRPPS" class="form-control" value="<?php if(isset($medecin['numRPPS'])) echo $medecin['numRPPS']; ?>" class="input-grow">
                                </div>
                                <div>
                                    Secteur d'activité
                                    <input type="text" name="activite" class="form-control" value="<?php if(isset($medecin['activite'])) echo $medecin['activite'];?>" class="input-grow">
                                </div>
                                <div>
                                    Mot de passe
                                    <input type="text" name="password" class="form-control" value="<?php if(isset($medecin['password'])) echo $medecin['password'];?>" class="input-grow">
                                </div>
                                <div>
                                    <?php if(isset($dateError)) echo $dateError; ?>
                                    Date du début d'activité
                                    <input type="date" name="dateDebutActivite" class="form-control" max="<?php echo date('Y-m-d'); ?>" value="<?php if(isset($medecin['dateDebutActivites'])) echo $medecin['dateDebutActivites']; ?>" class="input-grow">
                                </div>

                            </div>

                        </div>
                        <div class="col-12 mt-3">
                            <div class="d-flex col-12 flex-row justify-content-around">
                                <input type="submit" class="btn btn-danger btn-lg" value="Annuler" onclick="goTo('goListMedecins','administrateur');"> 
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
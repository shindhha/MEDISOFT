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
            <!-- Bandeau Patient -->
            @if(isset($patient->id))

            <form method="post" action="{{route('patient.update',$patient)}}">
                @method('PUT')
            @else
            <form method="post" action="{{route('patient.store')}}">
            @endif
                @csrf
                <div class="d-flex justify-content-center ">
                    <div class="d-flex flex-column col-12 col-md-8">
                        <div class="d-flex flex-row  justify-content-around text-green">
                            <div class="d-flex flex-column text-start">
                                <span class="" >Nom</span>
                                <div class="d-flex ">
                                    <input class="form-control " type="text" name="nom" value="{{old('nom',$patient->nom)}}">
                                </div>
                                <span class="" >Prenom</span>
                                <div><input class="form-control" type="text" name="prenom" value="{{old('prenom',$patient->prenom)}}"> </div>
                                <span class="" >Adresse</span>
                                <div><input class="form-control" type="text" name="adresse" value="{{old('adresse',$patient->adresse)}}">
                                </div>
                                <span class="" >Code Postal</span>
                                <div>

                                    <input class="form-control" type="number" name="codePostal" min="1001" max="98800" value="{{old('codePostal',$patient->codePostal)}}">
                                </div>
                                <span class="">Ville</span>
                                <div>

                                    <input class="form-control" type="text" name="ville"  value="{{old('ville',$patient->ville)}}">
                                </div>
                                <span class="" >n°Telephone</span>
                                <div><input class="form-control" type="number" name="numTel" max="999999999" value="{{old('numTel',$patient->numTel)}}">
                                </div>

                            </div>
                            <div class="d-flex flex-column text-start">
                                <span >Medecin Traitant</span>
                                <select name="medecinTraitant" class="form-select">
                                    <option value="0">Medecin Traitant</option>
                                    @foreach($medecins as $medecin)
                                        <option  value="{{$medecin->numRPPS}}" @selected(old('alter') == $medecin)>{{$medecin->nom . ' ' . $medecin->prenom}}</option>
                                    @endforeach
                                </select>
                                <span >Sexe</span>
                                <select name="sexe" class="form-select">
                                    <option value="0">Femme</option>
                                    <option value="1">Homme</option>
                                </select>
                                <span >Numéro sécurité sociale</span>
                                <div>

                                    <input class="form-control" type="text" name="numSecu" value="{{old('numSecu',$patient->numSecu)}}">
                                </div>
                                <span >Date Naissance</span>
                                <div><input class="form-control" type="date" max="<?php echo date('Y-m-d'); ?>" name="dateNaissance" value="{{old('dateNaissance',$patient->dateNaissance)}}">
                                </div>
                                <span >Lieu Naissance</span>
                                <div><input class="form-control" type="text" name="LieuNaissance" value="{{old('LieuNaissance',$patient->LieuNaissance)}}">
                                </div>
                                <span>Email</span>
                                <div>


                                    <input class="form-control" type="text" name="email" value="{{old('email',$patient->email)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="d-flex col-12 col-md-10 text-start mb-2 flex-column text-green">
                        <h1>Notes</h1>
                        <textarea  name="notes" rows="12" cols="33">{{old('notes',$patient->notes)}}</textarea>
                    </div>
                </div>

                <!-- Portail de connexion -->
                <div class="d-flex justify-content-end justify-content-md-center">
                    <div class="d-flex col-md-10 flex-row justify-content-between">
                        <div class="d-flex me-2 py-2 px-3 border-1 bg-danger">
                            <input type="submit" class="bg-danger no-border text-white" value="Annuler">
                        </div>
                        <div class="d-flex me-2 py-2 px-3 border-1 green">

                            <input type="submit" class="green no-border text-white" value="Valider">
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

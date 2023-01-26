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
				<!-- Bandeau Patient -->
				<form method="post" action="/editPatient/{{$id}}">
					@method('PUT')
                    @csrf
					<div class="d-flex justify-content-center ">
						<div class="d-flex flex-column col-12 col-md-8">
							<div class="d-flex flex-row  justify-content-around text-green">
								<div class="d-flex flex-column text-start">
										<span class="" >Nom</span>
										<div class="d-flex ">
											<input class="form-control " type="text" name="nom" value="{{$patient->nom}}"> 
										</div>
										<span class="" >Prenom</span>
										<div><input class="form-control" type="text" name="prenom" value="{{$patient->prenom}}"> </div>
										<span class="" >Adresse</span>
										<div><input class="form-control" type="text" name="adresse" value="{{$patient->adresse}}"> 
										</div>
										<span class="" >Code Postal</span>
										<div>
											<?php if (isset($codePostalError)) echo $codePostalError; ?>
											<input class="form-control" type="number" name="codePostal" min="1001" max="98800" value="{{$patient->codePostal}}">
										</div>
                                        <span class="" >Ville</span>
                                        <div>
                                            <?php if (isset($villeError)) echo $villeError; ?>
                                            <input class="form-control" type="text" name="ville" min="1001" max="98800" value="{{$patient->ville}}">
                                        </div>
										<span class="" >n°Telephone</span>
										<div><input class="form-control" type="number" name="numTel" max="999999999" value="{{$patient->numTel}}">
										</div>

								</div>
								<div class="d-flex flex-column text-start">
									<span >Medecin Traitant</span>
										<select name="medecinTraitant" class="form-select">
											<option value="0">Medecin Traitant</option>
											@foreach($medecins as $medecin)
												<option  value="{{$medecin->idMedecin}}" @selected(old('medecin') == $medecin)>{{$medecin->nom . ' ' . $medecin->prenom}}</option>
											@endforeach
										</select>
										<span >Sexe</span>
										<select name="sexe" class="form-select">
											<option value="0">Femme</option>
											<option value="1">Homme</option>
										</select>
										<span >Numéro sécurité sociale</span>
										<div>
											<?php if (isset($numSecuError)) echo $numSecuError; ?>
											<input class="form-control" type="text" name="numSecu" value="{{$patient->numSecu}}">
										</div>
										<span >Date Naissance</span>
										<div><input class="form-control" type="date" max="<?php echo date('Y-m-d'); ?>" name="dateNaissance" value="{{$patient->dateNaissance}}">
										</div>
										<span >Lieu Naissance</span>
										<div><input class="form-control" type="text" name="LieuNaissance" value="{{$patient->LieuNaissance}}">
										</div>
                                        <span>Email</span>
                                        <div>

                                            <?php if (isset($emailError)) echo $emailError; ?>
                                            <input class="form-control" type="text" name="email" value="{{$patient->email}}">
                                        </div>
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-center">
						<div class="d-flex col-12 col-md-10 text-start mb-2 flex-column text-green">
							<h1>Notes</h1> 
							<textarea  name="notes" rows="12" cols="33">{{$patient->notes}}</textarea>
						</div>
					</div>

						<!-- Portail de connexion -->
					<div class="d-flex justify-content-end justify-content-md-center">
						<div class="d-flex col-md-10 flex-row justify-content-between">	
							<div class="d-flex me-2 py-2 px-3 border-1 bg-danger">
								<input type="submit" class="bg-danger no-border text-white" value="Annuler" onclick="goTo('index','patientslist')">	
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

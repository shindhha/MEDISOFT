<!DOCTYPE html>
<html>
@include('includes/header')

<body onload="resizeMenu()">
	<div class="container-fluid h-100  text-white">
		<div class="row h-100">
			<!-- Menu -->
			<div id="menu" class="pt-3 menu z-index-dropdown col-md-1 col-4 d-md-flex d-none flex-column gap-3 blue h-100 align-items-center">
				<span onclick="manageClass('menu','d-none')"class="material-symbols-outlined d-block d-md-none text-end w-100">arrow_back</span>
				<div class=" green border-1 ratio ratio-1x1">

				</div>
				<a href="index.php?controller=medicamentslist" class="d-md-none">
					<div class="text-white green border-1 ratio ratio-1x1">
						<span class="d-flex display-3 align-items-center justify-content-center material-symbols-outlined">
							medication
						</span>
					</div>
				</a>
				<a href="index.php?controller=patientslist" class="d-md-none">
					<div  class=" text-white green border-1 ratio ratio-1x1">
						<span class="d-flex display-3 justify-content-center align-items-center material-symbols-outlined">
							groups
						</span>
					</div>
				</a>
				<a href="index.php?controller=medicamentslist" class="text-white d-none d-md-block green border-1 ratio ratio-1x1">

                    <span class="d-flex display-3 align-items-center justify-content-center material-symbols-outlined">
                        medication
                    </span>
                </a>
                <a href="index.php?controller=patientslist" class=" text-white d-none d-md-block green border-1 ratio ratio-1x1">
                    <span class="d-flex display-3 justify-content-center align-items-center material-symbols-outlined">
                        groups
                    </span>
                </a>
			</div>
			<!-- Main page -->
			<div class="col-md-11 h-75 text-center">
				<!-- Bandeau outils -->	
				
				<nav class="  row h-15 navbar navbar-expand-lg navbar-light green">
					<div class="d-flex justify-content-center justify-content-md-start px-5 container-fluid green">
						<span class="material-symbols-outlined  d-block d-md-none col-1" onclick="manageClass('menu','d-none')">menu</span>
						<span class="h1 "> Visite n°</span>
						<form>
								<input type="hidden" name="action" value="deconnexion">
								<input type="submit" class="btn btn-danger" value="Deconnexion">
						</form>
					</div>
				</nav>
				<div class="container-fluid d-flex justify-content-center">
				<form method="post" action="editVisite/{{$visite->idVisite}}" class=" d-flex flex-column col-12 col-md-9">
					<input type="hidden" name="idPatient" value="{{$idPatient}}">
					@method('PUT')
                    @csrf
				<div class="flex-row  text-dark  justify-content-center mb-3">
					<div class="d-flex flex-column gap-5">
						<div class="d-flex flex-row justify-content-between ">
							<div class="d-flex flex-row align-items-center"> 
							<span>Motif: </span> <input class="form-control" type="text" name="motifVisite" value="{{$visite->motifVisite}}"> 
							</div>
							
							<div class="d-flex flex-column">
								<span class="text-danger"><?php if (isset($dateError)) echo $dateError; ?></span>
								<div class="d-flex flex-row align-items-center">
									<span>Date: </span><input class="form-control" type="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="{{$visite->dateVisite}}">
								</div>
								
							</div>
						</div>
						<div class="d-flex flex-column text-start">
							<span>Description</span>
							<textarea rows="5" name="Description">{{$visite->Description}}</textarea>
						</div>						
						<div class="d-flex flex-column text-start	">
							<span>Conclusion</span>
							<textarea rows="5" name="Conclusion">{{$visite->Conclusion}}</textarea>			
						</div>
					</div>					
				</div>

				<!-- content -->
				<div class="row h-100 align-items-center text-center">
					<!-- Portail de connexion -->
					<div class="container ">
						<div class="row justify-content-center">
							<div class="d-flex flex-row justify-content-between">
								<div class="d-flex me-2 py-2 px-3 border-1 bg-danger">
								<input type="submit" class="bg-danger no-border text-white" value="Annuler" onclick="goTo('goFicheVisite','patientslist')">
								</div>
								<div class="d-flex me-2 py-2 px-3 border-1 green">
									<input type="submit" class="green no-border text-white" value="Valider">
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</form>
			</div>
			</div>

		</div>

		<script type="text/javascript" src="scripts/script.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
	</div>
</body>
</html>

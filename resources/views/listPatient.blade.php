<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes/header')

<body onload="resizeMenu()">
	<div class="container-fluid h-100  text-white">
		<div class="row h-100">
			<!-- Menu -->
			@include('includes/sideBar')
			<div class="col-md-11 h-100 text-center">
				<!-- Bandeau outils -->

				<nav class="row h-11 navbar navbar-expand-lg navbar-light green">
					<div class="col-12 d-flex justify-content-center justify-content-md-between px-1 px-md-5 green align-items-center">
						<div class="d-flex px-md-5 container-fluid green">
							<span class="material-symbols-outlined  d-block d-md-none col-1" onclick="manageClass('menu','d-none')">menu</span>
							<span class="h1 d-md-block d-none"> Liste Patients </span>

						</div>
						<!-- Barre de recherche -->
						<form class="d-flex align-items-center justify-content-end" action="index.php" method="POST">
							<input type="hidden" name="controller" value="patientslist">
							<div class="d-flex me-2 py-2 px-3 bg-white border-1 col-7 col-md-10 justify-content-end">
								<input name="search" class="no-border form-control" type="search" placeholder="Nom prenom" value="" onkeyup="showHint(this.value)" aria-label="Search">
								<input type="submit" class="no-border bg-white material-symbols-outlined text-black" value="search">

							</div>
							<!-- Filtre -->
							<div class="dropdown-toggle" type="button" id="dropdownMenuClickable" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
								Filtres
							</div>
							<div class="dropdown-menu p-0 z-index-dropdown dropdown-menu-end col-10 col-md-5 "  aria-labelledby="dropdownMenuClickable">
								<div class="container-fluid green p-4 z-index-dropdown">
									<div class="row gap-1 gap-md-0">
										<div class="col-12 col-md-6 d-flex gap-1 flex-column">
											<input type="date" class="form-control" name="dateMin">
											<input type="date" class="form-control" name="dateMax">
										</div>
										<div class="col-12 col-md-6 d-flex gap-1 flex-column">
											<select name="medecin" class="form-select text-green">
												<option value="%">MEDECIN</option>
												@foreach($medecins as $medecin)
												<option  value="{{$medecin->idMedecin}}" @selected(old('alter') == $medecin)>{{$medecin->nom . ' ' . $medecin->prenom}}</option>
												@endforeach
											</select>
											<select name="pValeurASMR" class="form-select text-green">
												<option value="%"></option>
												<?php
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</form>
						<form class="ms-2">
							<input type="hidden" name="action" value="deconnexion">
							<input type="submit" class="btn btn-danger" value="Deconnexion">
						</form>
					</div>

				</nav>

				<!-- content -->
				<div class="container-fluid h-100">
					<span class="fs-1 d-md-none d-sm-block text-green"> Liste Patients </span>
					<div class=" d-flex text-green justify-content-start">
						résultats
					</div>
					<div class="d-flex h-75 align-items-center justify-content-center">
						<div class="table-responsive h-75 border border-success align-middle">

							<table class="table table-striped lightGreen">
								<thead class="sticky-top bg-white text-dark  ">
									<tr>
										<th>Numéro de sécurité sociale</th>
										<th>Nom</th>
										<th>Prenom</th>
										<th>Date de naissance</th>
										<th>Medecin Traitant</th>
										<th>Numéro de téléphone</th>
										<th>Adresse</th>
										<th></th>
									</tr>
								</thead>
								@foreach ($patients as $patient)
								<tr>
									<td> {{$patient->numSecu}} </td>
									<td> {{$patient->nom}} </td>
									<td> {{$patient->prenom}} </td>
									<td> {{$patient->dateNaissance}} </td>
									<td> 0{{$patient->numTel}} </td>
									<td>  {{$patient->adresse}} </td>


									<td>
										<div class="dropdown  ">
											<span class=" material-symbols-outlined" type="button" id="dropdownMenuButton1" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
												more_horiz
											</span>
											<div class="p-0 border-2 dropdown-menu green dropdown-menu-end text-white no-border" aria-labelledby="dropdownMenuButton1">
												<div class="d-flex flex-column green">
													<table class="text-white ">

														<form action="{{route('showPatient',['id' => $patient->id])}}" action="POST" class="d-flex flex-column green">
															@csrf
															<tr><input type="submit" class="btn text-white text-decoration-underline text-end" value="Afficher"> </tr>
														</form>

															<a  href="#exampleModal" class="btn text-white text-decoration-underline text-end" data-bs-toggle="modal" class="btn green" onclick="add('{{$patient->nom}}  {{$patient->prenom}}','{{$patient->id}}')">Supprimer</a>
													</table>
												</div>
											</div>
										</div>

									</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
					<div class="d-flex flex-row justify-content-end">
						<div class="d-flex me-2 py-2 px-3 border-1 green">
							<form method="post" action="{{route('addPatient')}}">
								@csrf
								<input type="submit" class="green no-border text-white" value="Ajouter un patient">
							</form>
						</div>
					</div>
				</div>
			</div>


			@include('includes/popup')



		</div>


		<script type="text/javascript" src="{{asset('t.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
	</div>
</body>
</html>

	<!DOCTYPE html>
<html>
@include('includes/header')

<body onload="resizeMenu()">
	<div class="container-fluid h-100  text-white ">
		<div class="row h-100">
			<!-- Menu -->
			@include('includes/sideBar')
			<!-- Main page -->
			<div class="col-md-11 h-100 text-center">
				<!-- Bandeau outils -->	
				<nav class="row h-11 navbar navbar-expand-lg navbar-light green">
					<div class="col-12 d-flex justify-content-center justify-content-md-between px-1 px-md-5 green align-items-center">

						<span class="material-symbols-outlined  d-block d-md-none col-1" onclick="manageClass('menu','d-none')">menu</span>
						<span class="h1 d-md-block d-none"> Liste Médicaments </span>
						<!-- Barre de recherche -->
						<div class="d-flex flex-row align-items-center">
						<form class=" d-flex align-items-center justify-content-end" action="index.php" method="POST">
							<input type="hidden" name="controller" value="medicamentslist">
							<div class="d-flex me-2 py-2 px-3 bg-white border-1 col-7 col-md-10 justify-content-end">
								<input name="pDesignation" class="no-border form-control" type="search" placeholder="Designation" value="{{$pDesignation}}" onkeyup="showHint(this.value)" aria-label="Search">
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
											<select name="pNiveauSmr" class="form-select text-green">
												<option value="%">Valeur SMR</option>
												@foreach($niveauSmr as $nSmr)
												<option @selected(old('pNiveauSmr') == $nSmr)>{{$nSmr}}</option>
												@endforeach
												
											</select>
											<select name="pValeurASMR" class="form-select text-green">
												<option value="%">Valeur ASMR</option>
												@foreach($valeurASMR as $nAsmr)
												<option @selected(old('pValeurASMR') == $nAsmr)>{{$nAsmr}}</option>
												@endforeach
											</select>
											<select name="pVoieAdmi"  class="form-select text-green">
												<option value="%">Voie d'administration</option>
												@foreach($voieAdministration as $nAd)
												<option @selected(old('pVoieAdmi') == $nAd)>{{$nAd}}</option>
												@endforeach
											</select>
            							</div>
                						<div class="col-12 col-md-6 d-flex gap-1 flex-column">
            								<select name="pTauxRem" class=" form-select text-green ">
												<option value="">Taux Remboursement</option>
												@foreach($tauxRemboursements as $ntx)
												<option @selected(old('pTauxRem') == $ntx)>{{$ntx}}</option>
												@endforeach
											</select>
            								<select name="pformePharma"  class="form-select text-green">
												<option value="%">Forme Pharmacie</option>
												@foreach($formePharmas as $nfp)
												<option @selected(old('pformePharma') == $nfp)>{{$nfp}}</option>
												@endforeach
											</select>
											<select name="pSurveillance" class="form-select text-green">
												<option value="-1"<?php if ($pSurveillance == -1) echo "selected='selected'"; ?>>Surveillance Renforcée</option>
												<option value="1" <?php if ($pSurveillance == 1) echo "selected='selected'"; ?>>Oui</option>
												<option value="0" <?php if ($pSurveillance == 0) echo "selected='selected'"; ?>>Non</option>
											</select>
											<select name="pEtat" class="form-select text-green">
												<option value="-1"<?php if ($pEtat == -1) echo "selected='selected'"; ?>>Etat Commercialisation</option>
												<option value="1" <?php if ($pEtat == 1) echo "selected='selected'"; ?>>Commercialisé</option>
												<option value="0" <?php if ($pEtat == 0) echo "selected='selected'"; ?>>Non Commercialisé</option>
											</select>	
            							</div>
            							<div class="col-12 d-flex flex-row">
            								<div class="col-6 text-white">
												<label for="pPrixMin">Prix min :</label>
												<input class="form-control" type="number" name="pPrixMin" value="<?php echo $pPrixMin; ?>">
											</div>
            								<div class="col-6 text-white">
												<label for="pPrixMax">Prix Max :</label>
												<input class="form-control" type="number" name="pPrixMax" value="<?php echo $pPrixMax; ?>">
											</div>
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
					</div>

				</nav>
				<!-- content -->
				<div class="container-fluid h-100">
					<span class="fs-1 d-md-none d-sm-block text-green"> Liste Medicaments </span>
					<div class=" d-flex text-green justify-content-start">
					<?php echo count($drugs) ?> resultats
					</div>
					<div class="d-flex h-75 align-items-center">
						<div class="table-responsive h-75 border border-success align-middle">
						<table class="table table-striped lightGreen">
							<thead class="sticky-top bg-white text-dark  ">
								<tr>
									<th>Forme Pharmaceutique</th>
									<th>Voie d'administration</th>
									<th>Taux Remboursement</th>
									<th>Prix</th>
                                    <th>Designation</th>
									<th>Presentation </th>
									<th>Etat Commercialisation </th>
									<th>Surveillance Renforcé</th>
									<th></th>
								</tr>
							</thead>
								
								<?php

										$surveillance = "";
										$commercialiser = "";
											foreach ($drugs as $row)  {
												if ($row['etatCommercialisation']) {
													$commercialiser = "Commercialisé";
												} else {
													$commercialiser = "Non Commercialisé";
												}
												if ($row['surveillanceRenforcee']) {
													$surveillance = "OUI";
												} else {
													$surveillance = "NON";
												}
											echo "<tr>"
												 ."<td>" . $row['formePharma'] . "</td>"
												 ."<td>" . $row['labelVoieAdministration'] . "</td>"
												 ."<td>" . $row['tauxRemboursement'] . "</td>"
												 ."<td>" . $row['prix'] . "</td>"
                                                 ."<td>" . $row['designation'] . "</td>"
												 ."<td>" . $row['libellePresentation'] . "</td>"
												 ."<td>" . $commercialiser . "</td>"
												 ."<td>" . $surveillance . "</td>"
										?>
										<td>		
										<div class="dropdown ">
											<span class=" material-symbols-outlined" type="button" id="dropdownMenuButton1" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
												more_horiz
											</span>
											<div class="p-0  dropdown-menu dropdown-menu-end text-white no-border" aria-labelledby="dropdownMenuButton1">
												<form action="index.php" method="POST" class="d-flex flex-column green">
													<table class="text-white ">
														<form action="index.php" method="POST" class="d-flex flex-column green">
															<input type="hidden" name="controller" value="medicamentslist">
															<input type="hidden" name="action" value="goFicheMedicament">
															<input type="hidden" name="codeCIP7" value="<?php echo $row['codeCIP7'] ?>">
															<tr><input type="submit" class="btn text-white text-decoration-underline text-end" value="Afficher"> </tr>
														</form>
														<form action="index.php" method="POST" class="d-flex flex-column green">
															
															<?php if (isset($_SESSION['idVisite'])) {
															?>
																<a class="btn text-white text-decoration-underline text-end" data-bs-toggle="modal" href="#exampleModal" onclick="add('<?php echo $row['libellePresentation']."','". $row['codeCIP7']  ?>')" role="button">Ajouter</a>
															<?php
															} ?>						
														</form>
													</table>
											</div>
										</div>
										</td>
										<?php 
												echo "</tr>";
											} 
										?>	
						</table>
					</div>
					</div>
					
				</div>
				
			</div>

		</div>
		
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		 	<div class="modal-dialog modal-xl modal-dialog-centered">

		    	<div class="modal-content gap-2">
		    		<div class = "col-12 green d-flex text-start p-3 align-middle">
		    			<span id ="libelle"></span>
		    		</div>
		    		<form>
		    		<div class = "col-12 bg-white h-50 d-flex flex-column text-black text-start px-3">
		    			<span> instruction medicament:</span>
		    			<textarea name="instruction"></textarea>
		    		</div>
		    		<div class = "d-flex justify-content-end p-3">
		    			
		    				<input type="submit" value="confirmer">
		    				<input type="hidden" name="controller" value = "patientslist">
		    				<input type="hidden" name="action" value = "addMedicament">
		    				<input type="hidden" name="codeCIP7" value="" id ="code">
		    			
		    		</div>
		    		</form>
		    	</div>
			</div>
		</div>


		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="scripts/script.js"></script>
	</div>
</body>
</html>

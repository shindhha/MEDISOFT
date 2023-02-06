<form class="d-flex align-items-center justify-content-end" action="index.php" method="POST">
	<input type="hidden" name="controller" value="patientslist">
	<div class="d-flex me-2 py-2 px-3 bg-white border-1 col-7 col-md-10 justify-content-end">
		<input name="search" class="no-border form-control" type="search" placeholder="Nom prenom" value="" aria-label="Search">
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

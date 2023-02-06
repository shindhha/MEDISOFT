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

				<span class="fs-1 d-md-none d-sm-block text-green"> Administrateur </span>
				<!-- content -->
				<div class="row h-100 align-items-center text-center">
					<!-- Portail de connexion -->
					<div class="container">
						<div class="row justify-content-center text-start">
                            <span class="h1 text-dark">Informations du cabinet</span>
							<form  method="post" action="/cabinet" class="form-control">
								@method('PUT')
								@csrf
                                <label for="adresse">Adresse : </label>
                                <input class="form-control" type="text" name="adresse" value="{{$cabinet->adresse}}">
                                <label for="codePostal">Code postal : </label>
                                <input class="form-control" type="number" name="codePostal" min="1001" max="98800" value="{{$cabinet->codePostal}}">
                                <label for="ville">Ville : </label>
                                <input class="form-control" type="text" name="ville" value="{{$cabinet->ville}}">
								<input type="hidden" name="controller" value="administrateur">
								<input type="hidden" name="action" value="insertCabinet">
                                <div class="text-center mt-2">
                                    <input type="submit" value="Mettre à jour">
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>

		<script type="text/javascript" src="scripts/script.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
	</div>
</body>
</html>

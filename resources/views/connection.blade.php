<!DOCTYPE html>
<html>
@include('includes/header')
<body onload="resizeMenu()">
	<input name="controller" type="hidden" value="connection">
	<div class="container-fluid h-100  text-white">
		<div class="row h-100">
			<!-- Menu -->
			@include('includes/sideBar')
			<!-- Main page -->
			<div class="col-md-11 h-75 text-center">
				<!-- Bandeau titre -->
				@include('includes/navbar')
				<span class="fs-1 d-md-none d-sm-block text-green"> Connexion </span>
				<!-- content -->
				<div class="row h-100 align-items-center text-center">

					<div class="container ">
						
						<div class="row justify-content-center">
							<div class="col-md-8 col-xl-6 col-sm-7 col-12 green border-2 p-5">

								<form method="post" class="d-flex flex-column gap-3">
									@csrf
									<span class="fs-1"> Connexion à <u>{{ config('app.name')}}</u> </span>
									<div class="d-flex gap-3"><img src="res/iaccount.svg" class="sizeIcon"><input name="login" type="text" placeholder="Identifiant" class="border-0 border-1 w-75 ps-2 pt-2 pb-2"></div>

									<div class="d-flex gap-3"><img src="res/ipassword.svg" class="sizeIcon"><input name="password" type="password" placeholder="Mot de passe" class="ps-2 border-0 border-1 w-75 pt-2 pb-2"></input></div>
									<input type="hidden" name="test" value="dqs">
									<div><button class="border-0 w-50 border-1 text-green fs-3"><u> Valider </u></button></div>
								</form>
							</div>

						</div>

					</div>
				</div>
			</div>

		</div>
		
	</div>
</body>
</html>
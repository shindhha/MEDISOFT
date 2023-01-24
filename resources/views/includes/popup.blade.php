<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">

		<div class="modal-content ">
			<div class = "h5 col-12 green d-flex text-start p-3 align-middle">
				<span id ="libelle"></span>
			</div>
			<div class="text-center text-danger d-flex flex-column">
				<span>Etes vous sur de vouloir supprimer le patient ?</span>
				<span>Toutes ses visites seront perdue .</span>
			</div>
			<div class = "d-flex justify-content-end p-3 gap-3">
				<input type="submit" class="green no-border text-white me-2 py-2 px-3 border-1" data-bs-dismiss="modal" value="Annuler">
				<form>		
					<input type="submit" class="green no-border text-white me-2 py-2 px-3 border-1" value="confirmer">
					<input type="hidden" name="controller" value="patientslist">
					<input type="hidden" name="action" value="deletePatient">
					<input type="hidden" name="idPatient" value="" id ="code">
				</form>

			</div>
			
			
		</div>
	</div>
</div>
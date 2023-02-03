<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">

		<div class="modal-content ">
			<div class = "h5 col-12 green d-flex text-start p-3 align-middle">
				<span id ="libelle"></span>
			</div>
			<div class="text-center text-danger d-flex flex-column">
				@foreach($pageInfos['popUpSettings']['texts'] as $text)
				<span>{{$text['text']}}</span>
				@endforeach
			</div>
			<div class = "d-flex justify-content-end p-3 gap-3">
				<input type="submit" class="green no-border text-white me-2 py-2 px-3 border-1" data-bs-dismiss="modal" value="Annuler">
				<form method="post" action="{{route($pageInfos['popUpSettings']['route'],${$pageInfos['popUpSettings']['variable']})}}">
					@csrf
                    @method('DELETE')

					<input type="submit" class="green no-border text-white me-2 py-2 px-3 border-1" value="confirmer">

				</form>

			</div>


		</div>
	</div>
</div>

<nav class="  row h-15 navbar navbar-expand-lg navbar-light green">
	<div class="d-flex justify-content-between px-5 container-fluid green">
		<span class="h1 d-md-block d-none"> {{$pageInfos['title']?: "bot"}}</span>
		<input type="hidden" id="controller" value="administrateur">
		<input type="hidden" id="action" value="importAll">
		<span class="material-symbols-outlined text-start d-block d-md-none" onclick="manageClass('menu','d-none')">menu</span>
		<div class="d-flex flex-row aligns-items-center">
			
			@foreach($pageInfos['navBarContents'] as $navBarContent)
			@include('includes/navBarIcons')
			@endforeach
			<form>
				<input type="hidden" name="action" value="deconnexion">
				<input type="submit" class="btn btn-danger" value="Deconnexion">
			</form>
		</div>

	</div>
</nav>
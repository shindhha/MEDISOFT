<form action="{{$navBarContent['pageLinked']}}" method="post" class="d-flex aligns-items-center">
	@csrf
	<input type="submit" class="material-symbols-outlined green no-border text-white" value="{{$navBarContent['icone']}}">
</form>
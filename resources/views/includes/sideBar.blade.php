<div id="menu" class="pt-3 menu col-md-1 col-3 col-sm-2 d-md-flex d-none flex-column gap-3 blue h-100 align-items-center">

	@foreach($pageInfos['sideBarContents'] as $sideBarContent)
	@include('includes/linkSideBar')
	@endforeach
</div>

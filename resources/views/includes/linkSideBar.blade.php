<form action="{{$sideBarContent['pageLinked']}}" method="post" class="ratio ratio-1x1">
    @csrf
    <input type="submit" class="d-flex display-3 align-items-center justify-content-center green text-white no-border border-1 material-symbols-outlined" value="{{$sideBarContent['icone']}}">

</form>
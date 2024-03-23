<div class="btn-group dropleft">
    <button type="button"  class="btn btn-primary btn-sm dropdown-toggle w-100 d-block" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>

    <div class="dropdown-menu" x-placement="left-start" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="{{route('tenants.edit', ['tenant' => $id])}}"><i class="fas fa-pen text-info"></i>  Edit</a>
        <a class="dropdown-item" href="{{route('tenants.tokens', ['tenant' => $id])}}"><i class="fas fa-database text-success"></i> Tokens</a>
    </div>
</div>

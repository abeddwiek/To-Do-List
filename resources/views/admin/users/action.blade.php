{{--<a href="{{route('users.edit', [$id])}}"><i class="fas fa-pen"></i></a>--}}
{{--<a href="{{route('users.view', [$id])}}"><i class="fas fa-eye"></i></a>--}}
{{--<a href="#"><i class="fas fa-search"></i></a>--}}
{{--<a href="#"><i class="far fa-edit"></i></a>--}}

<div class="btn-group dropleft">
    <button type="button"  class="btn btn-primary btn-sm dropdown-toggle w-100 d-block" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action
    </button>

    <div class="dropdown-menu" x-placement="left-start" aria-labelledby="dropdownMenuLink">
        <x-access-link title="<i class='fas fa-pen text-info'></i> Edit" :href="route('users.edit', [$data->id])"
                       class="dropdown-item" access="Editors Admin Control" />
        <x-access-link title="<i class='fas fa-pen text-info'></i> Edit Password" :href="route('users.showEditPassword', [$data->id])"
                       class="dropdown-item" access="Editors Admin Control" />
        <x-access-link :title="$data->active ? '<i class=\'fas fa-ban\'></i> Disable User' : '<i class=\'far fa-check-circle text-success\'></i> Enable User'" :href="route('users.changeStatus', ['user' => $data])"
                       class="dropdown-item changeStatus" access="Readers Admin Control" />

</div>


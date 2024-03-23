
    @foreach(config('menu') as $menu)
        @php $show = false; $hasPermission = false; @endphp
        @if(isset($menu['children']))
            @foreach($menu['children'] as $children)
                @if(isset($children['children']))
                    @foreach($children['children'] as $item)
                        @if($item['route'] == Route::currentRouteName())
                            @php $show = true; @endphp
                        @endif
                        @can($item['tenant_permission']??'', 'tenants')
                            @php $hasPermission = true; @endphp
                        @endcan
                    @endforeach
                @endif
            @endforeach
        @endif

        @if($hasPermission)
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link {{$show ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapse{{str($menu['name'])->slug()}}"
               aria-expanded="{{$show ? 'true' : 'false'}}" aria-controls="collapse{{str($menu['name'])->slug()}}">
                <i class="fa fa-chart-line"></i>
                <span>{{$menu['name']}}</span>
            </a>


            <div id="collapse{{str($menu['name'])->slug()}}" class="collapse @if($show) show @endif" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

            @if(isset($menu['children']))

                    @foreach($menu['children'] as $children)


                        <h6 class="collapse-header">{{ $children['name']}}:</h6>
                        @if(isset($children['children']))
                            @foreach($children['children'] as $item)

                                    @can($item['tenant_permission']??'', 'tenants')
                                <x-access-link :title="$item['name']" :href="route($item['route']??'home')"
                                               class="collapse-item" :access="$item['access']" />
                            @endcan
                            @endforeach
                        @endif

                    @endforeach

            @endif

    @endif
    @endforeach

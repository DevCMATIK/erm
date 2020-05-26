<nav class="navbar navbar-expand-lg navbar-light bg-light mb-6">
    <a class="navbar-brand mr-2 text-primary" href="/{{ $entity }}"><i class="fal fa-@yield('page-icon')"></i> @yield('page-title') </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Arbol Completo
                </a>
                <div class="dropdown-menu">
                @forelse($navBar as $item)
                        @if($item['childs'])
                            <div class="dropdown-multilevel">
                                <div class="dropdown-item">{{ $item['name']  }}</div>
                                <div class="dropdown-menu">
                                    <a href="{{ $item['url'] }}" class="dropdown-item">{{ $item['alter'] }}</a>
                                    @foreach($item['childs'] as $child1)
                                        @if($child1['childs'])
                                            <div class="dropdown-multilevel">
                                                <div class="dropdown-item">{{ $child1['name'] }}</div>
                                                <div class="dropdown-menu">
                                                    <a href="{{ $child1['url'] ?? '#' }}" class="dropdown-item">{{ $child1['alter'] }}</a>
                                                    @foreach($child1['childs'] as $child2)
                                                        @if($child2['childs'])
                                                            <div class="dropdown-multilevel">
                                                                <div class="dropdown-item" class="dropdown-item">{{ $child2['name'] }}</div>
                                                                <div class="dropdown-menu">
                                                                    <a href="{{ $child2['url'] ?? '#' }}" class="dropdown-item">{{ $child2['alter'] }}</a>
                                                                    @foreach($child2['childs'] as $child3)
                                                                        <a href="{{ $child3['url'] ?? '#'}}" class="dropdown-item">{{ $child3['name'] }}</a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a href="{{ $child2['url'] ?? '#'}}" class="dropdown-item">{{ $child2['name'] }}</a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $child1['url'] ?? '#'}}" class="dropdown-item">{{ $child1['name'] }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $item['url'] }}" class="dropdown-item">{{ $item['name'] }}</a>
                        @endif
                @empty
                    sin registros.
                @endforelse
                </div>
            </li>
        </ul>
        <div class="float-right">
            @hasSection('page-buttons')
                @yield('page-buttons')
            @endif
            {!! makeAddLink() !!}
        </div>
    </div>
</nav>

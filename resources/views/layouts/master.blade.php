<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ env('APP_NAME', 'CDS') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    @yield('meta')
    <link rel="stylesheet" href="/css/style.min.css">
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <style>@yield('style')</style>
</head>

<body class="skin-red sidebar-mini {{ isset($bodyClasses) ? $bodyClasses : '' }}">
    <div class="wrapper">
        <header class="main-header">
            <a href="/" class="logo">
                <span class="logo-lg">{{ env('APP_NAME', 'CDS') }}</span>
                <span class="logo-mini">CDS</span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="header">Navigation</li>
                    <li @if(isset($routeGroup) && $routeGroup == 'site')class="active"@endif>
                        <a href="{{ route('site.index') }}"><i class="fa fa-globe"></i><span>Sites</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'user')class="active"@endif>
                        <a href="{{ route('user.index') }}"><i class="fa fa-users"></i><span>Users</span></a>
                    </li>

                    <li class="header">Content</li>
                    <li @if(isset($routeGroup) && $routeGroup == 'page')class="active"@endif>
                        <a href="{{ route('page.index') }}"><i class="fa fa-file-text"></i><span>Pages</span></a>
                    </li>
                  <!--  <li @if(isset($routeGroup) && $routeGroup == 'page-type')class="active"@endif>
                        <a href="{{ route('page-type.index') }}"><i class="fa fa-file-text-cog"></i><span>Page types</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'page-template')class="active"@endif>
                        <a href="{{ route('page-template.index') }}"><i class="fa fa-file-text-tag"></i><span>Page templates</span></a>
                    </li>
                  -->
                  <!--  <li @if(isset($routeGroup) && $routeGroup == 'view')class="active"@endif>
                        <a href="{{ route('view.index') }}"><i class="fa fa-newspaper-o"></i><span>Views</span></a>
                    </li>
                  -->
                    <li @if(isset($routeGroup) && $routeGroup == 'field')class="active"@endif>
                        <a href="{{ route('field.index') }}"><i class="fa fa-tasks"></i><span>Fields</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'widget')class="active"@endif>
                        <a href="{{ route('widget.index') }}"><i class="fa fa-cubes"></i><span>Widgets</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'menu')class="active"@endif>
                        <a href="{{ route('menu.index') }}"><i class="fa fa-bars"></i><span>Menus&Search</span></a>
                    </li>
                    <!--<li @if(isset($routeGroup) && $routeGroup == 'taxonomy')class="active"@endif>
                        <a href="{{ route('taxonomy.index') }}"><i class="fa fa-book"></i><span>Taxonomy</span></a>
                    </li>-->

                    <li class="header">Other</li>
                    <!--<li @if(isset($routeGroup) && $routeGroup == 'media')class="active"@endif>
                        <a href="{{ route('media.index') }}"><i class="fa fa-photo"></i><span>Media</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'storage')class="active"@endif>
                        <a href="{{ route('storage.index') }}"><i class="fa fa-hdd-o"></i><span>Storage</span></a>
                    </li>
                    <li @if(isset($routeGroup) && $routeGroup == 'translation')class="active"@endif>
                        <a href="{{ route('translation.index') }}"><i class="fa fa-flag"></i><span>Translations</span></a>
                    </li>-->
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            <strong>{{ $route or '' }}</strong>
        </footer>
    </div>

    @include('partials.modal-help')
    @yield('modals')
    <script src="/js/app.min.js"></script>
    @if(isset($scripts))
        @foreach($scripts as $script)
            {!! Html::script('js/' . $script) !!}
        @endforeach
    @endif
    @yield('javascripts')
</body>
</html>

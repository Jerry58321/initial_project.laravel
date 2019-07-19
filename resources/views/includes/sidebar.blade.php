<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">{{ trans('sidebar.system') }}</li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.platform') }}</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('database.index') }}"><i class="fa fa-circle-o"></i>{{ trans('sidebar.platform_category.platform_database_list') }}</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
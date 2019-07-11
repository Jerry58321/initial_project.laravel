<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-plus"></i>
                        <span class="user-auth-count label label-success">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">你有<span class="user-auth-count"></span>個會員等待註冊審核中</li>
                        <li>
                            <ul id="user-auth-menu" class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="http://s8_agent.test/user/auth?status=auth&amp;begin_at=2019-05-15 00:00:00&amp;end_at=2019-05-22 23:59:59"><span class="fa fa-search">&nbsp;&nbsp;註冊審核列表</span></a></li>
                    </ul>
                </li>

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="user-withdraw-count label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">你有<span class="user-withdraw-count"></span>個會員等待取款審核中</li>
                        <li>
                            <ul id="user-withdraw-menu" class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="http://s8_agent.test/user/withdraw?status=pending&amp;begin_at=2019-05-15 00:00:00&amp;end_at=2019-05-22 23:59:59"><span class="fa fa-search">&nbsp;&nbsp;取款審核列表</span></a></li>
                    </ul>
                </li>

                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="user-deposit-count label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">你有<span class="user-deposit-count"></span>個會員等待存款審核中</li>
                        <li>
                            <ul id="user-deposit-menu" class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="http://s8_agent.test/user/deposit?status=all&amp;begin_at=2019-05-15 00:00:00&amp;end_at=2019-05-22 23:59:59"><span class="fa fa-search">&nbsp;&nbsp;存款審核列表</span></a></li>
                    </ul>
                </li>

                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bullhorn"></i>
                        <span class="user-promote_auth-count label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">你有<span class="user-promote_auth-count"></span>個會員等待優惠審核中</li>
                        <li>
                            <ul id="user-promote-menu" class="menu">
                            </ul>
                        </li>
                        <li class="footer"><a href="http://s8_agent.test/promote/auth?status=auth&amp;begin_at=2019-05-15&amp;end_at=2019-05-22"><span class="fa fa-search">&nbsp;&nbsp;優惠審核列表</span></a></li>
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <img class="user-image" src="http://s8_agent.test/images/lang/icon_tw.png">
                        <span class="lang_id">繁體中文</span> <span class="fa fa-caret-down"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="http://s8_agent.test/language/cn">
                                <img id="cn" class="lang-pic gray-scale" src="http://s8_agent.test/images/lang/icon_cn.png" alt="error">
                                <span class="text-muted">简体中文</span>
                            </a></li>
                        <li><a href="http://s8_agent.test/language/tw">
                                <img id="tw" class="lang-pic" src="http://s8_agent.test/images/lang/icon_tw.png" alt="error">
                                <span class="text-muted">繁體中文</span>
                            </a></li>
                        <li><a href="http://s8_agent.test/language/vn">
                                <img id="vn" class="lang-pic gray-scale" src="http://s8_agent.test/images/lang/icon_vn.png" alt="error">
                                <span class="text-muted">Người việt nam</span>
                            </a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i>登出</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
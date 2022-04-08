<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">منوی مدیریت</li>

                <li>
                    <a href="{{route('admin.dashboard')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div>
                        <span>داشبورد</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.users.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-sign-in-alt"></i></div>
                        <span>کاربران</span>
                    </a>
                </li>


                <li class="menu-title">منوی تنظیمات</li>
                <li>
                    <a href="{{route('admin.medias.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-link-h"></i></div>
                        <span>شبکه ها</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.packages.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-th-large"></i></div>
                        <span>پکیج ها</span>
                    </a>
                </li>

                <li class="menu-title">حسابداری</li>
                <li>
                    <a href="{{route('admin.payments.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-download-alt"></i></div>
                        <span>پرداخت ها</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.transactions.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-layer-group"></i></div>
                        <span>تراکنشات </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.safes.index')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-box"></i></div>
                        <span>گاوصندوق</span>
                    </a>
                </li>

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="has-arrow waves-effect">--}}
{{--                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-comment-message"></i></div>--}}
{{--                        <span>Email</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li><a href="email-inbox.html">Inbox</a></li>--}}
{{--                        <li><a href="email-read.html">Email Read</a></li>--}}
{{--                        <li><a href="email-compose.html">Email Compose</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}


            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

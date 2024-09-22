<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <div class="pull-left"><i class="ti-home"></i><span
                                    class="right-nav-text">{{ trans('layouts/sidebar.dashboard') }}</span>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{ trans('layouts/sidebar.program') }}
                    </li>

                    <!-- Invoices -->
                    @if (Auth::user()->can('الفواتير') or Auth::user()->can('Invoices'))
                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#invoices-menu">
                                <div class="pull-left"><i class="ti-receipt"></i></i><span
                                        class="right-nav-text">{{ trans('layouts/sidebar.invoices') }}</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            @php
                                $all_count = \App\Models\Invoice::count();
                                $paid_count = \App\Models\Invoice::where('status', 1)->count();
                                $partial_paid_count = \App\Models\Invoice::where('status', 3)->count();
                                $unpaid_count = \App\Models\Invoice::where('status', 2)->count();
                            @endphp
                            <ul id="invoices-menu" class="collapse" data-parent="#sidebarnav">
                                @if (Auth::user()->can('قائمة الفواتير') or Auth::user()->can('Invoices List'))
                                    <li><a href="{{ route('invoices') }}">{{ trans('layouts/sidebar.invoice.list') }}&nbsp;&nbsp;&nbsp;<span class="badge bg-info float-end mt-1">{{ $all_count }}</span></a></li>
                                @endif

                                @if (Auth::user()->can('الفواتير المدفوعة') or Auth::user()->can('Paid Invoices'))
                                    <li><a href="{{ route('paidInvoices') }}">{{ trans('layouts/sidebar.invoice.paid') }}&nbsp;&nbsp;&nbsp;<span class="badge bg-success float-end mt-1">{{ $paid_count }}</span></a></li>
                                @endif

                                @if (Auth::user()->can('الفواتير الغير مدفوعة') or Auth::user()->can('Unpaid Invoices'))
                                    <li><a href="{{ route('unpaidInvoices') }}">{{ trans('layouts/sidebar.invoice.unpaid') }}&nbsp;&nbsp;&nbsp;<span class="badge bg-danger float-end mt-1">{{ $unpaid_count }}</span></a></li>
                                @endif

                                @if (Auth::user()->can('الفواتير المدفوعة جزئيا') or Auth::user()->can('Partial Paid Invoices'))
                                    <li><a href="{{ route('partialPaidInvoices') }}">{{ trans('layouts/sidebar.invoice.partial') }}&nbsp;&nbsp;&nbsp;<span class="badge bg-warning float-end mt-1">{{ $partial_paid_count }}</span></a></li>
                                @endif

                                @if (Auth::user()->can('أرشيف الفواتير') or Auth::user()->can('Invoices Archive'))
                                    <li><a href="{{ route('invoicesArchive') }}">{{ trans('layouts/sidebar.invoice.archive') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <!-- Reports -->
                    @if (Auth::user()->can('التقارير') or Auth::user()->can('Reports'))
                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#reports-menu">
                                <div class="pull-left"><i class="ti-pie-chart"></i><span
                                        class="right-nav-text">{{ trans('layouts/sidebar.reports') }}</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="reports-menu" class="collapse" data-parent="#sidebarnav">
                                @if (Auth::user()->can('تقارير الفواتير') or Auth::user()->can('Invoices Reports'))
                                    <li><a href="{{ route('invoicesReports') }}">{{ trans('layouts/sidebar.report.invoices') }}</a></li>
                                @endif

                                @if (Auth::user()->can('تقارير العملاء') or Auth::user()->can('Customer Reports'))
                                    <li><a href="{{ route('customersReports') }}">{{ trans('layouts/sidebar.report.customer') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <!-- Users -->
                    @if (Auth::user()->can('المستخدمين') or Auth::user()->can('Users'))
                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#users-menu">
                                <div class="pull-left"><i class="ti-user"></i></i><span
                                        class="right-nav-text">{{ trans('layouts/sidebar.users') }}</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="users-menu" class="collapse" data-parent="#sidebarnav">
                                @if (Auth::user()->can('قائمة المستخدمين') or Auth::user()->can('Users List'))
                                    <li><a href="{{ route('users') }}">{{ trans('layouts/sidebar.user.list') }}</a></li>
                                @endif

                                @if (Auth::user()->can('صلاحيات المستخدمين') or Auth::user()->can('Users Permissions'))
                                    <li><a href="{{ route('roles') }}">{{ trans('layouts/sidebar.user.permissions') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <!-- Settings -->
                    @if (Auth::user()->can('الإعدادات') or Auth::user()->can('Settings'))
                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#settings-menu">
                                <div class="pull-left"><i class="ti-settings"></i></i><span
                                        class="right-nav-text">{{ trans('layouts/sidebar.settings') }}</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="settings-menu" class="collapse" data-parent="#sidebarnav">
                                @if (Auth::user()->can('الأقسام') or Auth::user()->can('Sections'))
                                    <li><a href="{{ route('sections') }}">{{ trans('layouts/sidebar.setting.section') }}</a></li>
                                @endif

                                @if (Auth::user()->can('المنتجات') or Auth::user()->can('Products'))
                                    <li><a href="{{ route('products') }}">{{ trans('layouts/sidebar.setting.product') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <!-- Contact -->
                    <li>
                        <a href="{{ route('contact') }}"><i class="ti-headphone-alt"></i><span class="right-nav-text">{{ trans('layouts/sidebar.contact') }} </span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================

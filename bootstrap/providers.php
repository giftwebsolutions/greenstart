<?php

use Modules\Frontend\Providers\FrontendServiceProvider;
use Modules\SysAdmin\Providers\SysAdminServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    SysAdminServiceProvider::class,
    FrontendServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Yajra\DataTables\HtmlServiceProvider::class,
];

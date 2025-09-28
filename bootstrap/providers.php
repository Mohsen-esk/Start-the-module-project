<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\PermissionServiceProvider::class,

    /*
     * Module Service Providers...
     */
    Modules\Auth\AuthServiceProvider::class,
    Modules\Post\PostServiceProvider::class,
];

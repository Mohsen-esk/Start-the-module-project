<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Controllers\Admin\CategoryController;

// Admin routes for the Post module will be placed here.
// These routes should be loaded under the 'admin' prefix and middleware group.

Route::resource('categories', CategoryController::class);
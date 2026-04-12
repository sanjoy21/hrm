<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(
            [
                'admin.guest'=>\App\Http\Middleware\AdminRedirect::class,
                'admin.auth'=>\App\Http\Middleware\AdminAuthenticate::class,
                'management.guest'=>\App\Http\Middleware\ManagementRedirect::class,
                'management.auth'=>\App\Http\Middleware\ManagementAuthenticate::class,
                'army.guest'=>\App\Http\Middleware\ArmyRedirect::class,
                'army.auth'=>\App\Http\Middleware\ArmyAuthenticate::class,
            ]
            );

            $middleware->redirectTo(

                guests:'/employee/login',
                users:'/employee/dashboard'
            );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

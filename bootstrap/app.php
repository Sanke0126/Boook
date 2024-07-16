<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//use App\Http\Middleware\LoginAuth;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
      //  $middleware->alias([ 'IsUserLogin' => \App\Http\Middleware\LoginAuth::class,  ]);
        //$middleware->append(LoginAuth::class);
        $middleware->redirectTo(
            guests:'account/login',
            users:'account/profile',
        );  
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

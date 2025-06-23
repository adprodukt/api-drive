<?php

use App\Http\Middleware\AdminCheck;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '/api-drive',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
                return response()->json([
                    "messege" => 'Login failed'
                ], 403);
        });
        $exceptions->renderable(function (ValidationException $e, $request) {
                return response()->json([
                    'error' => [
                    'code' => 422,
                    "messege" => "Validation error",
                    'errors'=>$e->errors(),
                    ]
                ], 422);
            });
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    "messege" => "Not found",
                ]
            ], 404);
        });
    })->create();

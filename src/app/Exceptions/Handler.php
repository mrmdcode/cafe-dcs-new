<?php
namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    public function render($request, Throwable $e)
    {
        // Validation failures (e.g. wrong login credentials) and auth redirects
        // must keep Laravel's default handling (redirect back with errors),
        // not be swallowed into a generic 500 page.
        if ($e instanceof ValidationException || $e instanceof AuthenticationException) {
            return parent::render($request, $e);
        }

        // 404 Page not found
        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // 403 Forbidden
        if ($e instanceof AccessDeniedHttpException) {
            return response()->view('errors.403', [], 403);
        }

        // HTTP exceptions (403, 404, 500, etc.)
        if ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();

            if (view()->exists("errors.$statusCode")) {
                return response()->view("errors.$statusCode", [
                    'exception' => $e,
                ], $statusCode);
            }

            return response()->view('errors.500', [], 500);
        }

        // Handle non-HTTP exceptions (real 500 errors)
        if (! app()->environment('local')) {
            return response()->view('errors.500', [
                'exception' => $e,
            ], 500);
        }

        // Default Laravel behavior (shows debug in local)
        return parent::render($request, $e);
    }
}

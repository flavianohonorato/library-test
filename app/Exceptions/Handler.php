<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'integration_customer_password',
    ];

    /**
     * Report or log an exception.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Throwable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        return $this->prepareJsonResponse($request, $exception);
    }

    public function prepareJsonResponse($request, Throwable $e)
    {
        $message = $e->getMessage();

        if (empty($message) && $e instanceof NotFoundHttpException) {
            $message = 'Not found';
        }

        if ($e instanceof AuthorizationException || $e instanceof AuthenticationException) {
            $errors = [
                'message' => __($message),
                'code' => Response::HTTP_UNAUTHORIZED,
            ];

            return new JsonResponse($errors, Response::HTTP_UNAUTHORIZED);
        }

        $arr = (config('app.debug')) ? [
            'message' => $message,
            'response' => method_exists($e, 'getResponse') ? $e->getResponse() : 'não existe',
            'path' => $request->getPathInfo(),
            'exception' => \get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'path' => $request->getPathInfo(),
            'exception' => \get_class($e),
        ];

        return new JsonResponse(
            $arr,
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : [],
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES
        );
    }
}

<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use BadMethodCallException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ThrottleRequestsException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }


        if ($exception instanceof ThrottleRequestsException) {
            return $this->response409($e);
        }


        if ($exception instanceof BadMethodCallException) {
            return $this->errorResponse($exception->getMessage(), 405);
        }

        if ($exception instanceof QueryException) {
            return $this->errorResponse($exception->getMessage(), 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The Url Specified cannnot be found', 404);
        }

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }


        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors,    422);


    }

    public function response409(Exception $e)
    {
        $errors = new MessageBag();
        $errors->add("message", "409 Too many requests");
        return response()->make(view('errors.409')->withErrors($errors), Response::HTTP_CONFLICT);
    }
}

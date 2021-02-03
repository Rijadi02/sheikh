<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if($this->isModel($e))
        {
           return $this->NotFound("Record not found!");
        }

        if($this->isHttp($e))
        {
            return $this->NotFound("Incorrect Route!");
        }

        if($this->isMedhod($e))
        {
            return $this->Error("Method not supported in this route!", Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return parent::render($request, $e);
    }

    public function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    public function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    public function isMedhod($e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    public function NotFound($message)
    {
        return response()->json([
            "errors" => $message
        ], Response::HTTP_NOT_FOUND);
    }

    public function Error($message, $response)
    {
        return response()->json([
            "errors" => $message
        ], $response);
    }
}

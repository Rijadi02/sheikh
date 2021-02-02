<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;


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

    public function NotFound($message)
    {
        return response()->json([
            "errors" => $message
        ], Response::HTTP_NOT_FOUND);
    }
}

<?php

namespace App\Exceptions;

use Exception;

class BatchNumberConflictException extends Exception
{
    public function render($request)
    {
        $response = [
            'status' => 'error',
            'message' => $this->getMessage(),
            'code' => $this->getCode() ?: 409 // Conflict status code
        ];

        if ($request->expectsJson()) {
            return response()->json($response, $response['code']);
        }

        return back()->withErrors(['error' => $this->getMessage()])->withInput();
    }
}
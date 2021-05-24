<?php

namespace App\Exceptions;

use Exception;

class CantDeleteModelException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 400,
                'error' => $this->getMessage(),
                'message'=>$this->getMessage(),
            ], 400);
        }

        return redirect()->back()->withInput(
            $request->input()
        );
    }
}

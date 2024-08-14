<?php

namespace App\Exceptions;

use Exception;

class RecordNotFound extends Exception
{
      /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            'error' => 'Record not found',
        ], 404);
    }

}

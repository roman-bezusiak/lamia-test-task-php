<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

interface APIController {
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request);

    /**
     * Creates and returns validator for the incoming request.
     *
     * @param  \Illuminate\Http\Request              $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function createValidator(Request $request);
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\AuthGate;
use App\Http\Controllers\API\APIController;

class BookController extends AuthGate implements APIController
{
    private static $validationRules = [
        'isbn' => ['required', 'regex:/^.{10,17}$/'],
    ];

    private static $validationErrorMessages = [
        'isbn.required' => 'ISBN is not specified',
        'isbn.regex'    => 'ISBN is invalid',
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        // Authentication check
        if(!$this->authenticated()) return redirect()->route('login_page');

        // Validating the request
        $validator = $this->createValidator($request);
        if ($validator->fails())
        {
            return redirect()->route('book_search_page');
        }

        // Fetching data from JSON REST API
        $response = $this->fetchBook($request->isbn);

        // Validating JSON REST API response code
        if (!$response->ok())
        {
            $status = $response->status();
            if ($status === 404)
            {
                return view('errors.no_search_results', [
                    'query' => ['isbn' => $request->isbn]
                ]);
            }
            else
            {
                return view('errors.remote_error', [
                    'error_status' => $status,
                    'error_message' => $request->body() ?? null
                ]);
            }
        }

        return response()->json($response->json());
    }

    /**
     * Creates and returns validator for the incoming request.
     *
     * @param  \Illuminate\Http\Request              $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function createValidator(Request $request)
    {
        return Validator::make(
            $request->all(),
            BookController::$validationRules,
            BookController::$validationErrorMessages
        );
    }

    /**
     * Sends GET request to JSON REST API and returns the Response.
     *
     * @param  string                    $isbn
     * @return \Illuminate\Http\Response
     */
    private function fetchBook(string $isbn)
    {
        return Http::get(config('services.get_book_endpoint_url'), [
            'isbn' => $isbn,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class BookRequestController extends Controller
{
    private static $validationRules = [
        'isbn' => ['required', 'regex:/^.{10,17}$/'],
    ];

    private static $validationErrorMessages = [
        'isbn.required' => 'ISBN is not specified',
        'isbn.regex' => 'ISBN is invalid',
    ];

    private static $GET_BOOK_ENDPOINT_URL = 'https://lamia-py-api.herokuapp.com/getBook';

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request) {
        // Validating the request
        $validator = $this->createValidator($request);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Fetching data from JSON REST API
        $response = $this->fetchBook($request->isbn);

        // Validating JSON REST API response code
        if (!$response->ok()) {
            $status = $response->status();
            if ($status === 404) {
                return view('no_search_results', [
                    'query' => [
                        'isbn' => $request->isbn
                    ]
                ]);
            } else {
                return view('remote_error', [
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
     * @param  \Illuminate\Http\Request             $request
     * @return Illuminate\Support\Facades\Validator
     */
    private function createValidator(Request $request) {
        return Validator::make(
            $request->all(),
            BookRequestController::$validationRules,
            BookRequestController::$validationErrorMessages
        );
    }

    /**
     * Sends GET request to JSON REST API and returns the Response.
     *
     * @param  string                    $isbn
     * @return \Illuminate\Http\Response
     */
    private function fetchBook(string $isbn) {
        return Http::get(BookRequestController::$GET_BOOK_ENDPOINT_URL, [
            'isbn' => $isbn,
        ]);
    }
}

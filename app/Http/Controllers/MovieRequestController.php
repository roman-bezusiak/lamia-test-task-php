<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MovieRequestController extends Controller
{
    private static $validationRules = [
        'title' => ['required'],
        'year' => ['required', 'regex:/^[1-2][0-9]{3}$/'],
        'plot' => ['required', 'regex:/^short|full$/']
    ];

    private static $validationErrorMessages = [
        'title.required' => 'Title is not specified',
        'year.required' => 'Year is not specified',
        'year.regex' => 'Year is out of range',
        'plot.required' => 'Plot is not specified',
        'plot.regex' => 'Plot should be either "short" or "full"'
    ];

    private static $GET_MOVIE_ENDPOINT_URL = 'https://lamia-py-api.herokuapp.com/getMovie';

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
        $response = $this->fetchMovie(
            $request->title,
            $request->year,
            $request->plot
        );

        // Validating JSON REST API response code
        if (!$response->ok()) {
            $status = $response->status();
            if ($status === 404) {
                return view('no_search_results', [
                    'query' => [
                        'title' => $request->title,
                        'year' => $request->year,
                        'plot' => $request->plot
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
            MovieRequestController::$validationRules,
            MovieRequestController::$validationErrorMessages
        );
    }

    /**
     * Sends GET request to JSON REST API and returns the Response.
     *
     * @param  string                    $title
     * @param  string                    $year
     * @param  string                    $plot
     * @return \Illuminate\Http\Response
     */
    private function fetchMovie(string $title, string $year, string $plot) {
        return Http::get(MovieRequestController::$GET_MOVIE_ENDPOINT_URL, [
            'title' => $title,
            'year' => $year,
            'plot' => $plot
        ]);
    }
}

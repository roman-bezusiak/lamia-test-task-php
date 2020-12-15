<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\AuthGate;
use App\Http\Controllers\API\APIController;

class MovieController extends AuthGate implements APIController
{
    private static $validationRules = [
        'title' => ['required'],
        'year'  => ['required', 'regex:/^[1-2][0-9]{3}$/'],
        'plot'  => ['required', 'regex:/^short|full$/']
    ];

    private static $validationErrorMessages = [
        'title.required' => 'Title is not specified',
        'year.required'  => 'Year is not specified',
        'year.regex'     => 'Year is out of range',
        'plot.required'  => 'Plot is not specified',
        'plot.regex'     => 'Plot should be either "short" or "full"'
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
        if(!$this->authenticated()) return redirect('/login');

        // Validating the request
        $validator = $this->createValidator($request);
        if ($validator->fails())
        {
            return redirect()->route('movie_search_page');
        }

        // Fetching data from JSON REST API
        $response = $this->fetchMovie(
            $request->title,
            $request->year,
            $request->plot
        );

        // Validating JSON REST API response code
        if (!$response->ok())
        {
            $status = $response->status();
            if ($status === 404)
            {
                return view('no_search_results', [
                    'query' => [
                        'title' => $request->title,
                        'year'  => $request->year,
                        'plot'  => $request->plot
                    ]
                ]);
            }
            else
            {
                return view('remote_error', [
                    'error_status'  => $status,
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
            MovieController::$validationRules,
            MovieController::$validationErrorMessages
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
    private function fetchMovie(string $title, string $year, string $plot)
    {
        return Http::get(config('services.get_movie_endpoint_url'), [
            'title' => $title,
            'year'  => $year,
            'plot'  => $plot
        ]);
    }
}

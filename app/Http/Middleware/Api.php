<?php

namespace App\Http\Middleware;

use App\Exceptions\Api\Exception as ApiException;
use App\Exceptions\Api\NotFoundException;
use App\Models\ApiKey;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Api
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $debugMode = env('APP_DEBUG', false);

        $auth = $request->header('Authorization');
        if(!$auth || substr($auth, 0, 7) != 'KeyAuth') {
            return response('Malformed Authorization header.', 400);
        }

        list($key, $signature) = explode(':', substr($auth, 8));

        try {
            $apiKey = ApiKey::where('key', $key)->first();
        } catch(\Exception $e) {
            return response('Unauthorized.', 401);
        }

        $dataToSign = $request->method() . $request->getRequestUri();
        $signatureCheck = hash_hmac('sha256', $dataToSign, $apiKey->secret);
        if($signature !== $signatureCheck) {
            if($debugMode) {
                return response()->json([
                    'error' => 'Signatures don\'t match. Expected ' . $signatureCheck . ' but got ' . $signature,
                    'debug' => [
                        'method' => $request->method(),
                        'uri' => $request->getRequestUri(),
                        'data' => $dataToSign
                    ]
                ], 400);
            }
            return response('Unauthorized.', 401);   
        }

        try {
            return $next($request);
        } catch(NotFoundException $e) {
            return response($e->getMessage(), 404);
        } catch(ApiException $e) {
            return response($e->getMessage(), 400);
        } catch(\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorisationException extends Exception
{
    /**
     * Error Message
     *
     * @var string
     */
    protected $message;

    /**
     * Error Code
     *
     * @var int
     */
    protected $code;
    
    /**
     * Constructor
     *
     * @param string|null  $message
     * @param integer|null $code
     */
    public function __construct(
        ?string $message = null,
        ?int $code = 403
    ) {
        $this->message = $message;
        $this->code = $code;
    }

    /**
    * render the request
    *
    * @param  Request  $request
    * @return Response
    */
    public function render(Request $request)
    {
        return response([
            'error' => $this->getErrorMessage($this->message),
            'code' => $this->code,
            'status' => 'Error',
        ], $this->code);
    }

    /**
     * Gets the status text
     *
     * @param  string $message
     * @return void
     */
    public function getErrorMessage(?string $message = null)
    {
        if ($message) {
            return $message;
        }

        return Response::$statusTexts[$this->code];
    }
}

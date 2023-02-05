<?php
namespace App\Exceptions;


use Throwable;

class ResourceNotFound extends \Exception
{
    public $message;
    public int $errorCode;

    public function __construct($message = "Resource", $errorCode = 404, Throwable $previous = null)
    {
        $this->message = $message.' not found';
        $this->errorCode = $errorCode;

        parent::__construct($this->message, $this->errorCode, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'message' => $this->message
        ], $this->errorCode);
    }
}

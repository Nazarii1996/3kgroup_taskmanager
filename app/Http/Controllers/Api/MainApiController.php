<?php

namespace App\Http\Controllers\Api;
use App\eHealth\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainApiController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    public $status = 'success';

    public $errors = [];

    public $message = '';

    public $message_type = 'success';

    public $statusCode = 200;

    public $redirectTo = false;

    public $original_error = [];

    public $optionsParams = '';

    /**
     * MainController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $errors
     * @param int $statusCode
     * @param string $message
     * @return array
     */
    protected function errorResponse($errors, $statusCode = 400, $message = 'Validation Failed', $redirectTo = false)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'statusCode' => $statusCode,
            'redirectTo' => $redirectTo
        ];
    }

    /**
     * @param string $message
     * @param null $data
     * @param bool $redirectTo
     * @return array
     */
    protected function successResponse($message = '', $data = null, $redirectTo = false)
    {
        return [
            'status' => 'success',
            'statusCode' => 200,
            'message' => $message,
            'data' => $data,
            'redirectTo' => $redirectTo
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    protected function response($data = [])
    {
        return [
            'status' => $this->status,
            'statusCode' => $this->statusCode,
            'message' => $this->message,
            'message_type' => $this->message_type,
            'data' => $data,
            'redirectTo' => $this->redirectTo,
            'errors' => $this->errors,
            'original_error' => $this->original_error,
            'optionsParams' => $this->optionsParams,
        ];
    }

}

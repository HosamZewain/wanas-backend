<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IModelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ApiBaseController extends Controller
{
    public const RESPONSE_STATUS_OK = 200;
    public const RESPONSE_STATUS_ERROR = 400;

    protected $repo;

    protected $modelResource;

    protected $relations = [];

    protected $statusCode;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(
        IModelRepository $repo,
        $modelResource = JsonResource::class
    ) {
        ini_set('memory_limit', '2048M');

        $this->repo = $repo;
        $this->modelResource = $modelResource;

        // Include embedded data
        if (request()->has('embed')) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = 1;
        $limit = 0;
        $order = 'id';
        $applyOrder = true;
        $orderDir = "DESC";
        $filters = request()->all();

        if (request()->has('page')) {
            $page = request('page');
        }

        if (request()->has('limit')) {
            $limit = request('limit');
        }
        if (request()->has('applyOrder')) {
            $applyOrder = request('applyOrder');
        }

        if (request()->has('order')) {
            $order = request('order');
        }

        if (request()->has('orderDir')) {
            $orderDir = request('orderDir');
        }

        $models = $this->repo->search($filters, $this->relations, $applyOrder, $page, $limit, $order, $orderDir);

        return $this->respondWithCollection($models);
    }

    /**
     * @param $embed
     */
    protected function parseIncludes($embed)
    {
        $this->relations = explode(',', $embed);
    }

    /**
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode ?: self::RESPONSE_STATUS_OK;
    }

    /**
     * @param $resources
     * @param array $headers
     * @return mixed
     */
    protected function respond($resources, $headers = [])
    {
        return $resources
            ->additional(['status' => $this->getStatusCode()])
            ->response()
            ->setStatusCode($this->getStatusCode())
            ->withHeaders($headers);
    }

    /**
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithArray($data, $headers = [])
    {
        return response()->json($data, $data['status'], $headers);
    }

    /**
     * @param $collection
     * @param int|null $statusCode
     * @param array $headers
     * @return mixed
     */
    protected function respondWithCollection($collection, int $statusCode = null, array $headers = [])
    {
        $statusCode = $statusCode ?? self::RESPONSE_STATUS_OK;

        $resources = forward_static_call([$this->modelResource, 'collection'], $collection);

        return $this->setStatusCode($statusCode)->respond($resources, $headers);
    }

    /**
     * @param $model
     * @param int|null $statusCode
     * @param array $headers
     * @return mixed
     */
    protected function respondWithModel($model, int $statusCode = null, array $headers = [])
    {
        $statusCode = $statusCode ?? self::RESPONSE_STATUS_OK;

        $resource = new $this->modelResource($model);

        return $this->setStatusCode($statusCode)->respond($resource, $headers);
    }

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    protected function respondWithSuccess($message = 'messages.success', $data = [])
    {
        $response = [
            'status' => self::RESPONSE_STATUS_OK,
        ];
        if (!empty($message)) {
            $response['message'] = __($message);
        }
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $this->setStatusCode(self::RESPONSE_STATUS_OK)->respondWithArray($response);
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    protected function respondWithError($message)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for error on a 200...",
                E_USER_WARNING
            );
        }
        return $this->respondWithErrors($message, $this->statusCode);
    }

    /**
     * @param string $errors
     * @param null $statusCode
     * @param array $data
     * @param null $message
     * @return JsonResponse
     */
    protected function respondWithErrors($errors = 'messages.error', $statusCode = null, $data = [], $message = null)
    {
        $statusCode = !empty($statusCode) ? $statusCode : self::RESPONSE_STATUS_ERROR;
        if (is_string($errors)) {
            $errors = __($errors);
        }
        $response = ['status' => $statusCode, 'errors' => $errors];
        if (!empty($message)) {
            $response['message'] = __($message);
        }
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $this->setStatusCode($statusCode)->respondWithArray($response);
    }

    protected function respondWithBoolean($result)
    {
        return $result ? $this->respondWithSuccess() : $this->errorUnknown();
    }

    /***
     * *******************************************************************************************
     * *******************************************************************************************
     */

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return JsonResponse
     */
    public function errorUnknown($message = 'dashboard.unknown_error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }
}

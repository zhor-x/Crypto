<?php

namespace App\Http\Controllers;

use App\Helpers\ContentSourceConstant;
use App\Helpers\HttpConstant;
use App\Services\NewsContentSourceService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Log;


/**
 *
 */
class NewsSourceController extends Controller
{
    use ApiResponser;

    /**
     * @var \App\Services\NewsContentSourceService
     */
    private $sourceService;

    /**
     * @param \App\Services\NewsContentSourceService $sourceService
     */
    public function __construct(NewsContentSourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $content = $this->sourceService->index();
            if (!$content) {
                return $this->errorResponse(ContentSourceConstant::NOT_FOUND, HttpConstant::HTTP_NOT_FOUND);
            }
            return $this->successResponse($content);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::HTTP_BAD_REQUEST);
        }

    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->only('source');
            $this->authorize('change-permission');
            $validator = $this->checkValidation($data);
            if ($validator) {
                return $this->errorResponse($validator, HttpConstant::HTTP_UNPROCESSABLE_ENTITY);
            }
            $this->sourceService->store($data);
            return $this->successResponse(null,ContentSourceConstant::CREATED, HttpConstant::HTTP_CREATED);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::Ht);
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authorize('change-permission');
            $data = $request->only('source');
            $validator = $this->checkValidation($data);
            if ($validator) {
                return $this->errorResponse($validator, HttpConstant::HTTP_UNPROCESSABLE_ENTITY);
            }
            $this->sourceService->update($data, $id);
            return $this->successResponse(null,ContentSourceConstant::UPDATED, HttpConstant::HTTP_OK);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authorize('change-permission');

            $this->sourceService->destroy($id);
            return $this->successResponse(null,ContentSourceConstant::DELETED, HttpConstant::HTTP_OK);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::HTTP_NOT_FOUND);

        }
    }


    /**
     * @param $data
     *
     * @return null|array
     */
    private function checkValidation($data): ?array
    {
        $validator = \Validator::make($data, ContentSourceConstant::RULES);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        return null;
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ContentConstant;
use App\Helpers\HttpConstant;
use App\Services\NewsApiService;
use App\Services\NewsContentService;
use App\Services\NewsContentSourceService;
use App\Traits\ApiResponser;
use App\Traits\ContentValidation;
use Illuminate\Http\Request;
use Log;



class NewsController extends Controller
{
    use ApiResponser;
    use ContentValidation;

    /**
     * @var \App\Services\NewsContentService
     */
    private $newsContentSourceService;
    /**
     * @var \App\Services\NewsContentService
     */
    private $newsContentService;

    /**
     * @param \App\Services\NewsContentService $newsContentService
     */
    public function __construct(NewsContentService $newsContentService, NewsContentSourceService $newsContentSourceService)
    {
        $this->newsContentService = $newsContentService;
        $this->newsContentSourceService = $newsContentSourceService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        try {
            $groupBy = $request->groupBy;
            $content = $this->newsContentService->index($groupBy);
            if (!$content) {
                return $this->errorResponse(ContentConstant::NOT_FOUND, HttpConstant::HTTP_NOT_FOUND);
            }
            return $this->successResponse($content);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Get One Content News
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {

            $content = $this->newsContentService->show($id);
            if (!$content) {
                return $this->errorResponse(ContentConstant::NOT_FOUND, HttpConstant::HTTP_NOT_FOUND);
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
            $this->authorize('change-permission');
            $data = $request->all();
            $validator = $this->checkValidation($data);
            if ($validator) {
                return $this->errorResponse($validator, HttpConstant::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (isset($data['source'])) {
                $data['source_id'] = $this->newsContentSourceService->store(['source' => $data['source']]);
            }
            $this->newsContentService->store($data);
            return $this->successResponse(null,ContentConstant::CREATED, HttpConstant::HTTP_CREATED);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage(), HttpConstant::HTTP_BAD_REQUEST);
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
            $data = $request->all();
            $validator = $this->checkValidation($data, 'update');
            if ($validator) {

                return $this->errorResponse($validator, HttpConstant::HTTP_UNPROCESSABLE_ENTITY);

            }
            $this->newsContentService->update($data, $id);
            return $this->successResponse(null,ContentConstant::UPDATED, HttpConstant::HTTP_CREATED);

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

            $this->newsContentService->destroy($id);
            return $this->successResponse(ContentConstant::DELETED, HttpConstant::HTTP_OK);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return $this->errorResponse(ContentConstant::NOT_FOUND, HttpConstant::HTTP_NOT_FOUND);

        }
    }

}

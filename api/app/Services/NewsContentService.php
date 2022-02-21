<?php

namespace App\Services;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Interfaces\ContentInterface;

/**
 *
 */
class NewsContentService
{
    /**
     * @var \App\Interfaces\ContentInterface
     */
    private $content;

    /**
     * @param \App\Interfaces\ContentInterface $content
     */
    public function __construct(ContentInterface $content)
    {
        $this->content = $content;
    }

    /**
     * @param $groupBy
     *
     * @return \App\Http\Resources\NewsCollection|null
     */
    public function index($groupBy):?NewsCollection
    {
        $content = $this->content->index($groupBy);
        if ($content->isEmpty()) {
            return null;
        }
         return new NewsCollection($content);
    }

    /**
     * @param $id
     *
     * @return NewsResource
     */
    public function show($id):?NewsResource
    {
        $content = $this->content->show($id);
        return new NewsResource($content);
    }

    /**
     * @param $data
     * @param string $orderBy
     * @param string $position
     * @param $groupBy
     * @param string $count
     *
     * @return mixed
     */
    public function where($data, string $orderBy = 'id', string $position = 'asc', $groupBy = null, string $count = 'get')
    {
        return $this->content->where($data, $orderBy, $position, $groupBy, $count);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->content->store($data);
    }

    /**
     * @param $data
     * @param $id
     *
     * @return void
     */
    public function update($data, $id):void
    {
        $this->content->update($data, $id);
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function destroy($id):void
    {
        $this->content->destroy($id);
    }

}

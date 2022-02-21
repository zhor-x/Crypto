<?php

namespace App\Services;

use App\Http\Resources\NewsCollection;
use App\Interfaces\ContentInterface;
use App\Interfaces\ContentSourceInterface;

/**
 *
 */
class NewsContentSourceService
{
    /**
     * @var \App\Interfaces\ContentSourceInterface
     */
    private $contentSource;

    /**
     * @param \App\Interfaces\ContentSourceInterface $contentSource
     */
    public function __construct(ContentSourceInterface $contentSource)
    {
        $this->contentSource = $contentSource;
    }


    /**
     * @return mixed
     */
    public function index()
    {
        return $this->contentSource->index();
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->contentSource->store($data);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id):void
    {
        $this->contentSource->update($data, $id);
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function destroy($id):void
    {
        $this->contentSource->destroy($id);
    }
}

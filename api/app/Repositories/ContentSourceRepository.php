<?php

namespace App\Repositories;

 use App\Interfaces\ContentSourceInterface;
 use App\Models\ContentSource;


 /**
  *
  */
 class ContentSourceRepository implements ContentSourceInterface
{

     /**
      * @var \App\Models\ContentSource
      */
     private $contentSource;

     /**
      * @param \App\Models\ContentSource $contentSource
      */
     public function __construct(ContentSource $contentSource)
    {
         $this->contentSource = $contentSource;
    }


     /**
      * @return mixed
      */
     public function index()
     {
         return $this->contentSource->get();
      }


    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data)
    {
        $content = $this->contentSource->firstOrCreate($data);
        return $content->id;
    }

     /**
      * @param $data
      * @param $id
      *
      * @return void
      */
     public function update($data, $id): void
    {
        $content = $this->contentSource->findOrFail($id);
        $content->update($data);
    }

     /**
      * @param $id
      *
      * @return void
      */
     public function destroy($id): void
    {
        $this->contentSource->findOrFail($id)->delete();
    }


}

<?php

namespace App\Repositories;

use App\Helpers\ContentConstant;
use App\Interfaces\ContentInterface;
use App\Models\Content;
use Carbon\Carbon;

/**
 *
 */
class ContentRepository implements ContentInterface
{

    /**
     * @var \App\Models\Content
     */
    private $content;

    /**
     * @param \App\Models\Content $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
     }

    /**
     * @param $groupBy
     *
     * @return mixed
     */
    public function index($groupBy)
    {
        if ($groupBy) {
            if(strtotime($groupBy)){
               $published =  Carbon::make($groupBy)->format('Y-m-d');
               return $this->where([['published','like',$groupBy]]);
            }
            elseif (in_array("$groupBy", ContentConstant::THEME)) {
                return $this->where(['theme'=>$groupBy]);
            }
            else{
              return  $this->content->whereHas('source', function ($query) use ($groupBy){
                    $query->where('source', $groupBy);
                })->get();
            }
        }
        return $this->content->get();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function store($data)
    {
        return $this->content->firstOrCreate(['title' => $data['title'],'description' => $data['description'],'theme' => $data['theme']], $data);
     }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return $this->content->find($id);
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
        $content = $this->content->where($data);
        if ($groupBy) {
            $content->groupBy($groupBy);
        }
        if ($count == 'get') {
            return $content->get();
        }
        return $content->first();
    }

    /**
     * @param $data
     * @param $id
     *
     * @return void
     */
    public function update($data, $id): void
    {
        $content = $this->content->findOrFail($id);
        $content->update($data);
    }


    /**
     * @param $id
     *
     * @return void
     */
    public function destroy($id): void
    {
        $this->content->findOrFail($id)->delete();
    }


}

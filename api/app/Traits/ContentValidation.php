<?php

namespace App\Traits;

use Validator;

/**
 *
 */
trait ContentValidation
{
    /**
     * @var \string[][]
     */
    private $rules = [

        'title' => [
            'string',
            'min:2',
            'max:100',
        ],
        'theme' => [
            'string',
            'min:2',
            'max:100',
        ],
        'description' => [
            'string',
            'min:2',
            'max:100',
        ],
        'image' => [
            'string',
            'min:2',
            'max:100',
        ],
        'content' => [
            'string',
            'max:300',
        ],
        'published' => [
            'string'
        ],
        'source_id' => [
            'integer',
            'exists:content_sources,id',
        ],
        'source' => [
            'string',
            'min:2',
            'max:100',
        ],

    ];

    /**
     * @param $data
     * @param string $method
     *
     * @return mixed
     */
    public function checkValidation($data, string $method = 'insert')
    {
        if ($method === 'insert') {
            $this->addRequired();
        }
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
    }

    /**
     * @return void
     */
    private function addRequired()
    {
        array_unshift($this->rules['title'], 'required');
        array_unshift($this->rules['theme'], 'required');
        array_unshift($this->rules['description'], 'required');
        array_unshift($this->rules['image'], 'required');
        array_unshift($this->rules['content'], 'required');
        array_unshift($this->rules['published'], 'required');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    protected $fillable = [
        'author',
        'title',
        'description',
        'image',
        'published',
        'content',
        'url',
        'theme',
        'source_id',
    ];


    public function source(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ContentSource::class);
    }

    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = Carbon::make($value)->format('Y-m-d H:i:s');

    }
}

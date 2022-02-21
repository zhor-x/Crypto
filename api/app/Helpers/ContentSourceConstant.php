<?php

namespace App\Helpers;

class ContentSourceConstant
{
    const CREATED = 'News source created successfully';
    const UPDATED = 'News source updated successfully';
    const DELETED = 'News source deleted successfully';
    const NOT_FOUND = 'News source not found';
    const RULES = [ 'source'=> ['string','required'] ];
}

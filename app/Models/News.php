<?php

namespace App\Models;

class News extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'title_trigram',
        'description_trigram',
    ];
}

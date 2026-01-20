<?php

declare(strict_types=1);

use Modules\Geo\Models\Place;

return [
    'article' => 'Modules\Blog\Models\Article',
    'category' => 'Modules\Blog\Models\Category',
    'comment' => 'Modules\Blog\Models\Comment',
    'contact' => 'Modules\Blog\Models\Contact',
    'event' => 'Modules\Blog\Models\Event',
    'home' => 'Modules\Blog\Models\Home',
    'my_rating' => 'Modules\Rating\Models\MyRating',
    'photo' => 'Modules\Blog\Models\Photo',
    'place' => Place::class,
    'privacy' => 'Modules\Blog\Models\Privacy',
    'profile' => 'Modules\User\Models\Profile',
    'rating' => 'Modules\Rating\Models\Rating',
];

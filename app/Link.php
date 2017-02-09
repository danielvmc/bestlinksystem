<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['user_id', 'fake_link', 'real_link', 'link_basic', 'query_key', 'query_value', 'full_link'];
}

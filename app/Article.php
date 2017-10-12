<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $with = ['authors', 'editor', 'category'];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function editor()
    {
    	return $this->belongsTo('App\Manager');
    }

    public function authors()
    {
    	return $this->belongsToMany('App\Author');
    }

    public function path()
    {
        return "/breaks/{$this->category->slug}/{$this->id}";
    }

}

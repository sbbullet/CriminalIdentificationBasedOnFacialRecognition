<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'embedding' => 'array',
    ];
    public function admin()
    {
    	return $this->belongsToMany(Admin::class, 'admin_suspect', 'suspect_id', 'admin_id');
    }

    public function getPhotoPathAttribute()
    {
    	return "/storage/uploads/{$this->photo}";
    }
}

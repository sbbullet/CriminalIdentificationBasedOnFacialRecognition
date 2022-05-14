<?php

namespace App;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password', 'dp', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function suspects()
    {
        return $this->belongsToMany(Suspect::class, 'admin_suspect', 'admin_id', 'suspect_id')
                    ->withPivot(['created_at', 'updated_at','no_of_detections'])
                    ->withTimestamps();
    }

}

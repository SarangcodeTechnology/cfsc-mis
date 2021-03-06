<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function getDateAttribute(){
        return date("Y/m/d", strtotime($this->created_at));
    }

    protected $appends = ['date'];

}

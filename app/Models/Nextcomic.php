<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nextcomic extends Model
{
    use HasFactory;
    
    
    
    public function getByLimit(int $limit_count = 5)
    {
        return $this->orderBy('released_at', 'ASC')->limit($limit_count)->get();
    }
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        return $this->withcount('likes')->orderBy('released_at', 'ASC')->paginate($limit_count);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }
    
    public function isLikedBy($user): bool {
        return Like::where('user_id', $user->id)->where('comic_id', $this->id)->first() !==null;
        }
}
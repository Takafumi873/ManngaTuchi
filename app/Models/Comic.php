<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;
    
    public function getByLimit(int $limit_count = 2)
    {
        return $this->orderBy('created_at', 'ASC')->limit($limit_count)->get();
    }
    
    public function getPaginateByLimit(int $limit_count = 2)
    {
        return $this->orderBy('created_at', 'ASC')->paginate($limit_count);
    }
}
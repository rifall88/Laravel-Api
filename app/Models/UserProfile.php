<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;

class UserProfile extends Model
{
    use HasUuids;
    protected $fillable = [
        'full_name'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

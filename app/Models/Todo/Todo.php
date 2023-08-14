<?php

namespace App\Models\Todo;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * Table Name
     */
    protected $table = 'data_todos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get CreatedAt Attribute
     *
     * @param string
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        return date('M-d', strtotime($value));
    }
}

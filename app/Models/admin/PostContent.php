<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostContent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categories_id',
        'title',
        'slug',
        'description',
        'mata_title',
        'mata_description',
        'views',
        'image',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at',
    ];

    public function get_categories() {
        return $this->hasOne('App\Models\admin\Categorie', 'id', 'categories_id');
    }
}

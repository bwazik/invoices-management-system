<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $table = 'products';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
        'note',
        'section_id',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}

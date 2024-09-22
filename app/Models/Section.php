<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;

    protected $table = 'sections';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
        'note',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }
}

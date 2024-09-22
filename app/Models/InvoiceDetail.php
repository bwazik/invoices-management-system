<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Translatable\HasTranslations;

class InvoiceDetail extends Model
{
    // use HasTranslations;

    protected $table = 'invoices_details';

    protected $fillable = [
        'id',
        'number',
        'payment_date',
        'status',
        'invoice_id',
        'user_id',
        'product_id',
        'section_id',
        'note',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}

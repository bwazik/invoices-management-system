<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Invoice extends Model
{
    // use HasTranslations;
    use SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'id',
        'number',
        'date',
        'due_date',
        'collection_amount',
        'commission_amount',
        'discount',
        'vat',
        'vat_value',
        'total',
        'status',
        'note',
        'section_id',
        'product_id',
        'payment_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function detail(){
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}

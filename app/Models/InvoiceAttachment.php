<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Translatable\HasTranslations;

class InvoiceAttachment extends Model
{
    // use HasTranslations;

    protected $table = 'invoices_attachments';

    protected $fillable = [
        'id',
        'number',
        'file',
        'invoice_id',
        'user_id',
        'created_at',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

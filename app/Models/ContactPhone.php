<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class ContactPhone extends Model
{
    protected $table = 'contact_phones';
    protected $primaryKey = 'id';
    protected $fillable = ['contact_id', 'cellphone', 'created_at', 'updated_at'];
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

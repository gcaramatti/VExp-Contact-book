<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class ContactPhone extends Model
{
    public $timestamps = false;
    protected $table = 'contact_phones';
    protected $primaryKey = 'id';
    protected $fillable = ['contact_id', 'cellphone'];
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

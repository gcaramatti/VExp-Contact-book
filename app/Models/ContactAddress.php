<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class ContactAddress extends Model
{
    public $timestamps = false;
    protected $table = 'contacts_addresses';
    protected $primaryKey = 'id';
    protected $fillable = ['contact_id', 'address', 'district', 'number', 'complement', 'city', 'state'];
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

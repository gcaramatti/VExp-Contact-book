<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContactPhone;
use App\Models\ContactAddress;

class Contact extends Model
{
    protected $table = 'users_contact_book';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'category_id', 'created_at', 'updated_at'];

    public function phones()
    {
        return $this->hasMany(ContactPhone::class);
    }
    public function addresses()
    {
        return $this->hasMany(ContactAddress::class);
    }
}

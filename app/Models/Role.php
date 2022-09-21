<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'company_id',
    ];

    // add relation

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function responsibilities() {
        return $this->hasMany(Responsibility::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

}

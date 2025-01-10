<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "chat_groups";
    public $timestamps = true;

    protected $fillable = ["name"];
}

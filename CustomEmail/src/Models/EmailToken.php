<?php
namespace Leadingdots\CustomEmail\Models;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    protected $guarded = [];
    protected $table = 'email_token';
}
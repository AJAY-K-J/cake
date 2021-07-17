<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Transaction extends Model
{
    public function __construct() {
        $this->table = 'transactions_'.Auth::user()->company_id;
    }
}
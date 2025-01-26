<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

    public static $name = 'search';
    public static $permissions = ['read', 'export'];

    protected $table = 'search';
    public $lists = [
        'id',
        'key',
        'created_at',
    ];
}

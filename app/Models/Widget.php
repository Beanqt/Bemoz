<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'widget';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];

    protected $table = 'widget';
    public $lists = [
        'id',
        'title',
        'type'
    ];

    public function languages(){
        return $this->belongsTo(Languages::class,'lang','id');
    }
    public function scopeLang($query) {
        return $query->where('lang', app('LanguageService')->getLangId());
    }
}

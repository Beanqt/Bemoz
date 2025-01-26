<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translates extends Model {
    public static $name = 'translates';
    protected $table = 'translator_translations';

    protected $fillable = ['locale', 'group', 'item', 'text', 'unstable'];

    public function language()
    {
        return $this->belongsTo(Languages::class, 'locale', 'locale');
    }

    public function getCodeAttribute()
    {
        if ($this->namespace === '*' || !$this->namespace)
        {
            return "{$this->group}.{$this->item}";
        }

        return "{$this->namespace}::{$this->group}.{$this->item}";
    }

    public function flagAsReviewed()
    {
        $this->unstable = 0;
    }

    public function lock()
    {
        $this->locked = 1;
    }

    public function isLocked()
    {
        return (boolean) $this->locked;
    }
}

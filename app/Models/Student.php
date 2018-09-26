<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\StudentAddress');
    }
}

<?php

namespace Modules\SCORM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SCORM\Database\Factories\ScormProgressFactory;

class ScormProgress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): ScormProgressFactory
    // {
    //     // return ScormProgressFactory::new();
    // }
}

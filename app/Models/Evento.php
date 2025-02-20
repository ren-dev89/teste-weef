<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Evento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        "image_path",
        "date",
        "name",
        "owner",
        "city",
        "state",
        "address",
        "number",
        "complement",
        "phone",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [


    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];


    /**
     * Scope a query to order by the given parameter.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $orderBy
     * @return void
     */
    public function scopeOrdered(Builder $query, string $orderBy) : void
    {
        $orderParams = explode(",", $orderBy);
        $query->orderBy($orderParams[0], $orderParams[1]);
    }
}

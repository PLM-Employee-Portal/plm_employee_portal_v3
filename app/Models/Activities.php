<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

        // Just add the three below to make the login work.

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_activities';

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'activity_id';

      /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'bigint';

    protected $fillable = [
        'type',
        'title',
        'description',
        'poster',
        'date',
        'start',
        'end',
        'host',
        'visible_to_list',
        'is_featured',
    ];

    protected $casts = [
        'visible_to_list' => 'array',
    ];
    
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address',
        'crime_type', 'incident_date', 'incident_location',
        'description', 'attachments', 'witness_name', 'witness_contact',
        'allow_contact', 'consent'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'allow_contact' => 'boolean',
        'consent' => 'boolean',
        'attachments' => 'array',
        'incident_date' => 'date'
    ];
}
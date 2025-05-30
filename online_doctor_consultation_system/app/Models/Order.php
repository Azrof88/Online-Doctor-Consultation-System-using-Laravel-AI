<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // optional, Laravel guesses correctly

    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'address',
        'status',
        'transaction_id',
        'currency',
        'appointment_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true; // set to true if your table has created_at/updated_at
    public function appointment()
{
    return $this->belongsTo(App\Models\Appointment::class);
}

}

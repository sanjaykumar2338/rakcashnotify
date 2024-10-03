<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $fillable = [
        'user_id',
        'plan_id',
        'paypal_order_id',
        'paypal_plan_id',
        'paypal_subscr_id',
        'valid_from',
        'valid_to',
        'paid_amount',
        'currency_code',
        'subscriber_id',
        'subscriber_name',
        'subscriber_email',
        'status',
        'created',
        'modified'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->belongsTo(Plans::class);
    }
}

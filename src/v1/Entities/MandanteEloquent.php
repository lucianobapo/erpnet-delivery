<?php

namespace ErpNET\Models\v1\Entities;

class MandanteEloquent extends BaseEloquent
{

    protected $table = 'mandantes';

    protected $fillable = [];

    /**
     * Implement fields to be exposed
     * @return array
     */
    public function exposedFields()
    {
        return [
            'id'         => (int) $this->id,

            /* place your other model properties here */

//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at
            'posted_at' => $this->updated_at
        ];
    }

    /**
     * Get the status associated with the given order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
//    public function orderSharedStats() {
//        return $this->belongsToMany(SharedStatEloquent::class, 'order_shared_stat', 'order_id', 'shared_stat_id')
//            ->withTimestamps();
//    }
}

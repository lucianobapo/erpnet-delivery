<?php

namespace ErpNET\Models\v1\Entities;

class PostEloquent extends BaseEloquent
{

    protected $table = 'posts';

    /**
     * Get the status associated with the given order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderSharedStats() {
//        return $this->belongsToMany(SharedStatEloquent::class, 'order_shared_stat', 'order_id', 'shared_stat_id')
//            ->withTimestamps();
    }

    /**
     * Order can have many items.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(){
//        return $this->hasMany(ItemOrderEloquent::class, 'order_id');
    }

    /**
     * An Order belongs to a Partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() {
//        return $this->belongsTo(PartnerEloquent::class);
    }

    /**
     * A Post belongs to a Page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page() {
        return $this->belongsTo(PageEloquent::class);
    }
}

<?php

namespace ErpNET\Models\v1\Entities;

class ItemOrderEloquent extends BaseEloquent
{
    protected $table = 'item_orders';

    protected $fillable = [];

    /**
     * Implement fields to be exposed
     * @return array
     */
    public function exposedFields()
    {
        return [
//            'id'         => (int) $this->id,

            /* place your other model properties here */

//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at
            'quantidade' => $this->quantidade,
            'valor_unitario' => $this->valor_unitario,
            'product' => $this->product,
        ];
    }

    /**
     * An Item Order belongs to a Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo(ProductEloquent::class);
    }

}

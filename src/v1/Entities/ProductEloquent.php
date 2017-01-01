<?php

namespace ErpNET\Models\v1\Entities;

class ProductEloquent extends BaseEloquent
{
    protected $table = 'products';

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
            'nome' => $this->nome,
        ];
    }

}

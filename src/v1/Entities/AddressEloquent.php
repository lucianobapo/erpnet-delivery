<?php

namespace ErpNET\Models\v1\Entities;

class AddressEloquent extends BaseEloquent
{
    protected $table = 'addresses';

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
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'obs' => $this->obs,
        ];
    }
}

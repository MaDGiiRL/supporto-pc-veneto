<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SegnalazioneResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'created_at' => optional($this->created_at ?? $this->creata_il)->toIso8601String(),
            'tipologia'  => $this->tipologia ?? 'altro',
            'operatore'  => $this->operatore,
            'aree'       => $this->aree ?? [],
            'sintesi'    => $this->sintesi,
            'event_id'   => $this->evento_id ?? null,

            'coord' => [
                'status'              => $this->coord_status ?? 'queue',
                'assigned_to'         => $this->assigned_role_id, // id numerico; lo mappiamo client-side con SNAP.roles
                'assign_instructions' => $this->assign_instructions,
                'routed_by_id'        => $this->routed_by_id,
                'closed_by_id'        => $this->closed_by_id,
            ],
        ];
    }
}

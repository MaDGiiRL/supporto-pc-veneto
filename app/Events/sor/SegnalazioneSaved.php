<?php

// app/Events/Sor/SegnalazioneSaved.php
namespace App\Events\Sor;

use App\Models\SegnalazioneGenerica;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;

class SegnalazioneSaved implements ShouldBroadcast
{
    use InteractsWithSockets;

    public function __construct(public SegnalazioneGenerica $segnalazione) {}
    public function broadcastOn()
    {
        return new Channel('sor');
    }
    public function broadcastAs()
    {
        return 'segnalazione.saved';
    }
}

// app/Events/Sor/SegnalazioneDeleted.php (analogo)
// app/Events/Sor/ComunicazioneSaved.php / Deleted
// app/Events/Sor/EventoSaved.php / Toggled

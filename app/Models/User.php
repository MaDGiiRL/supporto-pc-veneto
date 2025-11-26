<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'organization',
        'phone',
        'email',
        'password',
        'is_active',
        'is_admin', // 👈 aggiunto
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'is_admin'          => 'boolean',   // 👈 aggiunto
        ];
    }

    /**
     * Relazione molti-a-molti con i ruoli.
     */
    public function roles()
    {
        // pivot 'role_user'
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Verifica se l'utente ha un ruolo specifico (per slug).
     */
    public function hasRole(string $slug): bool
    {
        return $this->roles()
            ->where('slug', $slug)
            ->exists();
    }

    /**
     * Verifica se l'utente ha almeno uno dei ruoli indicati.
     */
    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles()
            ->whereIn('slug', $slugs)
            ->exists();
    }

    /**
     * Verifica se l'utente può "smistare" (can_assign = true in almeno un ruolo).
     */
    public function canAssign(): bool
    {
        return $this->roles()
            ->where('can_assign', true)
            ->exists();
    }

    /**
     * Verifica se l'utente può "chiudere" (can_close = true in almeno un ruolo).
     */
    public function canClose(): bool
    {
        return $this->roles()
            ->where('can_close', true)
            ->exists();
    }

    /**
     * Helper: è amministratore globale?
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Ruolo logico usato dal Coordinamento SOR (frontend).
     *
     * Ritorna uno tra:
     *  - coordinamento
     *  - mezzi
     *  - volontariato
     *  - prociv
     * oppure null se non mappato.
     */
    public function sorCoordRole(): ?string
    {
        // Coordinatore SOR → vede tutto / può smistare
        if ($this->hasRole('sor-coordinatore')) {
            return 'coordinamento';
        }

        // Mezzi e materiali → ruolo "mezzi" nel frontend
        if ($this->hasRole('sor-mezzi-materiali')) {
            return 'mezzi';
        }

        // Volontariato
        if ($this->hasRole('ufficio-volontariato') || $this->hasRole('volontari')) {
            return 'volontariato';
        }

        // Tutto il resto lo mettiamo in "prociv" di default
        return 'prociv';
    }
}

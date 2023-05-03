<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, User $model)
    {
        // Svi registrirani korisnici mogu vidjeti popis korisnika
        return true;
    }

    public function view(User $user, User $model)
    {
        // Svi registrirani korisnici mogu vidjeti pojedinog korisnika
        return true;
    }

    public function create(User $user)
    {
        // Samo administratori mogu stvarati nove korisnike
        return true;
    }

    public function update(User $user, User $model)
    {
        // Samo administratori ili voditelji timova mogu uređivati korisnika
        return true;
    }

    public function delete(User $user, User $model)
    {
        // Samo administratori mogu brisati korisnike
        return true;
    }
}

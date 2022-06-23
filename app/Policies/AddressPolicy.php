<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        foreach($user->roles as $role){
            return $role->name === 'author' OR 'client'
                ? Response::deny('You do not have this permission, you cannot see this info.')
                :  Response::allow();
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Address $address)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create( User $user )
    {
        //

        foreach($user->roles as $role){
            return $role->name === 'author' OR 'client'
                ? Response::allow()
                : Response::deny('You do not have this permission, you cannot make this info.');
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Address $address)
    {
        //
        return $address->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this post, you cannot edit it.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Address $address)
    {
        //
        return $address->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this address, you cannot delete it.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Address $address)
    {
        //
        return $address->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this address, you cannot restore it.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Address $address)
    {
        //
    }
}

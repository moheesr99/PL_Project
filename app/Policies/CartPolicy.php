<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Cart $cart)
    {
        return $cart->user_id === $user->id;
    }
    public function delete(User $user, Cart $cart){
        return $cart->user_id === $user->id;
    }
}

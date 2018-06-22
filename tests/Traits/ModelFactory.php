<?php

namespace Tests\Traits;

use App\User;

trait ModelFactory
{
    /**
     * Generate a model factory builder and create the model.
     *
     * @param $class
     * @param array $attributes
     * @param null $times
     * @return mixed
     */
    protected function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }

    /**
     * Generate a model factory builder and make the model.
     *
     * @param $class
     * @param array $attributes
     * @param null $times
     * @return mixed
     */
    protected function make($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->make($attributes);
    }

    /**
     * Authenticates as a factory built (or specified) User.
     *
     * @param User|null $user
     * @return $this
     */
    protected function givenLoggedInUser (?User $user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $this;
    }
}
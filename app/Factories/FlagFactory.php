<?php

namespace App\Factories;

use App\Flag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class FlagFactory
{
    /** @var Model */
    protected $flaggable;

    /**
     * Sets the flaggable for this factory.
     *
     * @param Model $flaggable
     * @return $this
     */
    public function flaggable(Model $flaggable)
    {
        $this->flaggable = $flaggable;

        return $this;
    }

    /**
     * Creates a flag if the flaggable has not performed $type action since a given $threshold.
     *
     * @param string $type
     * @param Carbon $threshold
     * @return Flag|null
     */
    public function createIfLate(string $type, Carbon $threshold)
    {
        if ($this->isLate($type, $threshold) && $this->isNotFlagged($type)) {
            return $this->create($type);
        }

        return null;
    }

    /**
     * Unconditionally creates a flag for the currently set flaggalbe.
     *
     * @param string $type
     * @return Flag
     */
    public function create(string $type)
    {
        return $this->flaggable->flags()->create([
            'type' => $type,
        ]);
    }

    /**
     * Determines if a flaggable has performed a $type of action after a given $threshold.
     *
     * @param string $type
     * @param Carbon $threshold
     * @return bool
     */
    protected function isLate(string $type, Carbon $threshold)
    {
        return ! $this->flaggable->actions()
            ->whereType($type)
            ->whereDate('created_at', '>=', $threshold)
            ->exists();
    }

    /**
     * Determines if a flaggable already has a flag about a given situation.
     *
     * @param string $type
     * @return bool
     */
    protected function isFlagged(string $type)
    {
        return $this->flaggable->flags()
            ->whereType($type)
            ->whereNull('resolved_at')
            ->exists();
    }

    /**
     * Determines if a flaggable does not have an active flag about a given situation.
     *
     * @param string $type
     * @return bool
     */
    protected function isNotFlagged(string $type)
    {
        return !$this->isFlagged($type);
    }
}
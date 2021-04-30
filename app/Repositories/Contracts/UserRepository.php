<?php

namespace App\Repositories\Contracts;

use App\Models\User;

/**
 * Interface UserRepository.
 */
interface UserRepository extends BaseRepository
{
    /**
     * @param string $slug
     *
     * @return User
     */
    public function findBySlug($slug);

    /**
     * @param bool $confirmed
     *
     * @return mixed
     */
    public function store(array $input, $confirmed = false);

    /**
     * @return mixed
     */
    public function update(User $user, array $input);

    /**
     * @return mixed
     */
    public function destroy(User $user);

    /**
     * @return mixed
     */
    public function impersonate(User $user);

    /**
     * @return mixed
     */
    public function batchDestroy(array $ids);

    /**
     * @return mixed
     */
    public function batchEnable(array $ids);

    /**
     * @return mixed
     */
    public function batchDisable(array $ids);
}

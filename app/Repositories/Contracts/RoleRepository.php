<?php

namespace App\Repositories\Contracts;

use App\Models\Role;

/**
 * Interface RoleRepository.
 */
interface RoleRepository extends BaseRepository
{
    /**
     * @return mixed|Role
     */
    public function store(array $input);

    /**
     * @return mixed|Role
     */
    public function update(Role $role, array $input);

    /**
     * @return mixed
     */
    public function destroy(Role $role);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllowedRoles();
}

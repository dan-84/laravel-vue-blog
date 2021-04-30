<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\Contracts\RoleRepository;

class RoleController extends BackendController
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * Create a new controller instance.
     */
    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Show the application dashboard.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function search(Request $request)
    {
        $query = $this->roles->query();

        $requestSearchQuery = new RequestSearchQuery($request, $query);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'order',
                'display_name',
                'description',
                'created_at',
                'updated_at',
            ],
                [
                    __('validation.attributes.name'),
                    __('validation.attributes.order'),
                    __('validation.attributes.display_name'),
                    __('validation.attributes.description'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'roles');
        }

        return $requestSearchQuery->result([
            'roles.id',
            'name',
            'order',
            'display_name',
            'description',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * @return Role
     */
    public function show(Role $role)
    {
        return $role;
    }

    public function getPermissions()
    {
        return config('permissions');
    }

    /**
     * @return mixed
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create roles');

        $this->roles->store($request->input());

        return $this->redirectResponse($request, __('alerts.backend.roles.created'));
    }

    /**
     * @return mixed
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $this->authorize('edit roles');

        $this->roles->update($role, $request->input());

        return $this->redirectResponse($request, __('alerts.backend.roles.updated'));
    }

    /**
     * @return mixed
     */
    public function destroy(Role $role, Request $request)
    {
        $this->authorize('delete roles');

        $this->roles->destroy($role);

        return $this->redirectResponse($request, __('alerts.backend.roles.deleted'));
    }
}

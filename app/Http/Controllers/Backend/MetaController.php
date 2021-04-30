<?php

namespace App\Http\Controllers\Backend;

use App\Models\Meta;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use App\Http\Requests\StoreMetaRequest;
use App\Http\Requests\UpdateMetaRequest;
use App\Repositories\Contracts\MetaRepository;

class MetaController extends BackendController
{
    /**
     * @var MetaRepository
     */
    protected $metas;

    /**
     * Create a new controller instance.
     */
    public function __construct(MetaRepository $metas)
    {
        $this->metas = $metas;
    }

    /**
     * Show the application dashboard.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function search(Request $request)
    {
        $query = $this->metas->query();

        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'title',
            'description',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'route',
                'metable_type',
                'title',
                'description',
                'created_at',
                'updated_at',
            ],
                [
                    __('validation.attributes.route'),
                    __('validation.attributes.metable_type'),
                    __('validation.attributes.title'),
                    __('validation.attributes.description'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'metas');
        }

        return $requestSearchQuery->result([
            'metas.id',
            'route',
            'metable_type',
            'metable_id',
            'title',
            'description',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * @return Meta
     */
    public function show(Meta $meta)
    {
        return $meta;
    }

    /**
     * @return mixed
     */
    public function store(StoreMetaRequest $request)
    {
        $this->authorize('create metas');

        $this->metas->store($request->input());

        return $this->redirectResponse($request, __('alerts.backend.metas.created'));
    }

    /**
     * @return mixed
     */
    public function update(Meta $meta, UpdateMetaRequest $request)
    {
        $this->authorize('edit metas');

        $this->metas->update($meta, $request->input());

        return $this->redirectResponse($request, __('alerts.backend.metas.updated'));
    }

    /**
     * @return mixed
     */
    public function destroy(Meta $meta, Request $request)
    {
        $this->authorize('delete metas');

        $this->metas->destroy($meta);

        return $this->redirectResponse($request, __('alerts.backend.metas.deleted'));
    }

    /**
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function batchAction(Request $request)
    {
        $action = $request->get('action');
        $ids = $request->get('ids');

        switch ($action) {
            case 'destroy':
                $this->authorize('delete metas');

                $this->metas->batchDestroy($ids);

                return $this->redirectResponse($request, __('alerts.backend.metas.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}

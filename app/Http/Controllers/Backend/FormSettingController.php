<?php

namespace App\Http\Controllers\Backend;

use App\Models\FormSetting;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use App\Http\Requests\StoreFormSettingRequest;
use App\Http\Requests\UpdateFormSettingRequest;
use App\Repositories\Contracts\FormSettingRepository;

class FormSettingController extends BackendController
{
    /**
     * @var FormSettingRepository
     */
    protected $formSettings;

    /**
     * Create a new controller instance.
     */
    public function __construct(FormSettingRepository $formSettings)
    {
        $this->formSettings = $formSettings;
    }

    /**
     * Show the application dashboard.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $requestSearchQuery = new RequestSearchQuery($request, $this->formSettings->query());

        return $requestSearchQuery->result([
            'id',
            'name',
            'recipients',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * @return array
     */
    public function getFormTypes()
    {
        $formTypes = collect(config('forms'));

        $formTypes->transform(function ($item) {
            return __($item['display_name']);
        });

        return $formTypes;
    }

    /**
     * @return FormSetting
     */
    public function show(FormSetting $form_setting)
    {
        return $form_setting;
    }

    /**
     * @return mixed
     */
    public function store(StoreFormSettingRequest $request)
    {
        $this->authorize('create form_settings');

        $this->formSettings->store($request->input());

        return $this->redirectResponse($request, __('alerts.backend.form_settings.created'));
    }

    /**
     * @return mixed
     */
    public function update(FormSetting $formSetting, UpdateFormSettingRequest $request)
    {
        $this->authorize('edit form_settings');

        $this->formSettings->update($formSetting, $request->input());

        return $this->redirectResponse($request, __('alerts.backend.form_settings.updated'));
    }

    /**
     * @return mixed
     */
    public function destroy(FormSetting $formSetting, Request $request)
    {
        $this->authorize('delete form_settings');

        $this->formSettings->destroy($formSetting);

        return $this->redirectResponse($request, __('alerts.backend.form_settings.deleted'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Utils\RequestSearchQuery;
use App\Repositories\Contracts\FormSubmissionRepository;

class FormSubmissionController extends BackendController
{
    /**
     * @var FormSubmissionRepository
     */
    protected $formSubmissions;

    /**
     * Create a new controller instance.
     */
    public function __construct(FormSubmissionRepository $formSubmissions)
    {
        $this->formSubmissions = $formSubmissions;
    }

    public function getFormSubmissionCounter()
    {
        return $this->formSubmissions->query()->count();
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
        $requestSearchQuery = new RequestSearchQuery($request, $this->formSubmissions->query(), [
            'data',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'type',
                'data',
                'created_at',
                'updated_at',
            ],
                [
                    __('validation.attributes.form_type'),
                    __('validation.attributes.form_data'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'submissions');
        }

        return $requestSearchQuery->result([
            'id',
            'type',
            'data',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * @return FormSubmission
     */
    public function show(FormSubmission $form_submission)
    {
        return $form_submission;
    }

    /**
     * @return mixed
     */
    public function destroy(FormSubmission $form_submission, Request $request)
    {
        $this->authorize('delete form_submissions');

        $this->formSubmissions->destroy($form_submission);

        return $this->redirectResponse($request, __('alerts.backend.form_submissions.deleted'));
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
                $this->authorize('delete form_submissions');

                $this->formSubmissions->batchDestroy($ids);

                return $this->redirectResponse($request, __('alerts.backend.form_submissions.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}

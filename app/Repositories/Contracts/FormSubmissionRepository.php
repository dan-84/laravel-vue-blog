<?php

namespace App\Repositories\Contracts;

use App\Models\FormSubmission;

/**
 * Interface FormSubmissionRepository.
 */
interface FormSubmissionRepository extends BaseRepository
{
    /**
     * @param string $type
     *
     * @return mixed
     */
    public function store($type, array $input);

    /**
     * @return mixed
     */
    public function destroy(FormSubmission $formSubmission);

    /**
     * @return mixed
     */
    public function batchDestroy(array $ids);
}

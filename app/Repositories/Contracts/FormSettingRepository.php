<?php

namespace App\Repositories\Contracts;

use App\Models\FormSetting;

/**
 * Interface FormSettingRepository.
 */
interface FormSettingRepository extends BaseRepository
{
    /**
     * @param $name
     *
     * @return FormSetting
     */
    public function find($name);

    /**
     * @return mixed
     */
    public function store(array $input);

    /**
     * @return mixed
     */
    public function update(FormSetting $formSetting, array $input);

    /**
     * @return mixed
     */
    public function destroy(FormSetting $formSetting);
}

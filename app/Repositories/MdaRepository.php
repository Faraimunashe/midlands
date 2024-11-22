<?php

namespace App\Repositories;

use App\Models\Mda;
use Illuminate\Support\Facades\Auth;

class MdaRepository
{
    /**
     * Get the current user's MDA data.
     *
     * @return Mda|null
     */
    public function getCurrentUserMda()
    {
        return Mda::where('user_id', Auth::id())->first();
    }

    /**
     * Get the current user's department data.
     *
     * @return mixed|null
     */
    public function getCurrentUserDepartment()
    {
        $mda = $this->getCurrentUserMda();
        return $mda ? $mda->department : null;
    }

    /**
     * Get both MDA and department data for the current user.
     *
     * @return array|null
     */
    public function getCurrentUserMdaAndDepartment()
    {
        $mda = $this->getCurrentUserMda();
        if (!$mda) {
            return null;
        }

        return [
            'mda' => $mda,
            'department' => $mda->department,
        ];
    }
}

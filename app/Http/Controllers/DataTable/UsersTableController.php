<?php

namespace App\Http\Controllers\DataTable;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTableController extends DataTableController
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder
    {
        return User::query();
    }
}

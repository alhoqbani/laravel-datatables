<?php

namespace App\Http\Controllers\DataTable;

use App\User;
use Illuminate\Http\Request;
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

    public function getUpdatableColumns()
    {
        return [
            'name', 'email', 'created_at'
        ];
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required'
        ]);

        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }


}

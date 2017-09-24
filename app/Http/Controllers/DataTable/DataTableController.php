<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

abstract class DataTableController extends Controller
{

    abstract public function builder(): Builder;

    public function index()
    {

    }
}

<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

abstract class DataTableController extends Controller
{

    abstract public function builder(): Builder;

    /**
     * DataTableController constructor.
     */
    public function __construct()
    {
        $builder = $this->builder();

        if ( ! $builder instanceof Builder) {
            throw new \Exception('The DataTable builder must be instance of ' . Builder::class);
        }
    }

    public function index()
    {
        return $this->builder()->paginate();
    }
}

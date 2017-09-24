<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

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
        return response()->json([
           'displayableColumns' => $this->getDisplayableColumns(),
           'records' => $this->getRecords(),
        ]);
    }

    protected function getRecords()
    {
        return $this->builder()->get();
    }

    protected function getDisplayableColumns()
    {
        return Schema::getColumnListing();
    }


}

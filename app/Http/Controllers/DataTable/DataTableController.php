<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

abstract class DataTableController extends Controller
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

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
        $this->builder = $builder;
    }

    public function index()
    {
        return response()->json([
            'table' => $this->builder->getModel()->getTable(),
            'displayableColumns' => $this->getDisplayableColumns(),
            'updatable' => array_values($this->getUpdatableColumns()),
            'records'            => $this->getRecords(),
        ]);
    }

    protected function getRecords()
    {
        return $this->builder->limit(request()->limit)->get();
    }

    protected function getDisplayableColumns()
    {
        return array_diff($this->getColumns(), $this->getHiddenColumns());
    }

    protected function getHiddenColumns()
    {
        return $this->builder->getModel()->getHidden();
    }

    protected function getColumns()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    protected function getUpdatableColumns()
    {
        return $this->getDisplayableColumns();
    }

    public function update($id, Request $request)
    {
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
}

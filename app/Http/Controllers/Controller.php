<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function paginateCollection(Collection $collection, int $perPage, string $pageName): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage($pageName, $pageName);

        return new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage)->values(),
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'pageName' => $pageName,
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    protected function filterConfig(string $table): array
    {
        $config = [
            'field' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'contact' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'client' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
                'contact_id' => ['label' => 'Contact', 'refTable' => 'contact', 'refKey' => 'id', 'refDisplay' => ['display' => "first_name || ' ' || last_name"]],
            ],
            'calls' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
                'client_id' => ['label' => 'Client', 'refTable' => 'client', 'refKey' => 'id', 'refDisplay' => 'id'],
            ],
            'forms' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
                'view_id' => ['label' => 'View', 'refTable' => 'views', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'email_template' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
                'result_code_id' => ['label' => 'Result Code', 'refTable' => 'result_code', 'refKey' => 'id', 'refDisplay' => 'name'],
                'email_id' => ['label' => 'Email', 'refTable' => 'email', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'views' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'result_code' => [
                'project_id' => ['label' => 'Project', 'refTable' => 'project', 'refKey' => 'id', 'refDisplay' => 'name'],
                'type_id' => ['label' => 'Type', 'refTable' => 'types', 'refKey' => 'id', 'refDisplay' => 'key'],
                'outcome_id' => ['label' => 'Outcome', 'refTable' => 'result_code_outcome', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'user' => [
                'user_group_id' => ['label' => 'User Group', 'refTable' => 'user_group', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'project' => [
                'project_group_id' => ['label' => 'Project Group', 'refTable' => 'project_group', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'project_group' => [
                'parent_project_group_id' => ['label' => 'Parent Group', 'refTable' => 'project_group', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'attribute_forms' => [
                'attribute_id' => ['label' => 'Attribute', 'refTable' => 'attributes', 'refKey' => 'id', 'refDisplay' => 'key'],
                'form_id' => ['label' => 'Form', 'refTable' => 'forms', 'refKey' => 'id', 'refDisplay' => 'name'],
            ],
            'attributes' => [
                'type_id' => ['label' => 'Type', 'refTable' => 'types', 'refKey' => 'id', 'refDisplay' => 'key'],
            ],
            'settings' => [
                'property_id' => ['label' => 'Property', 'refTable' => 'property', 'refKey' => 'id', 'refDisplay' => 'property'],
                'attribute_id' => ['label' => 'Attribute', 'refTable' => 'attributes', 'refKey' => 'id', 'refDisplay' => 'key'],
                'type_id' => ['label' => 'Type', 'refTable' => 'types', 'refKey' => 'id', 'refDisplay' => 'key'],
            ],
        ];
        return $config[$table] ?? [];
    }

    protected function getFilterValues(string $connection, array $filterConfig): array
    {
        $values = [];
        foreach ($filterConfig as $col => $cfg) {
            $query = DB::connection($connection)->table($cfg['refTable'])->select($cfg['refKey']);
            if (is_array($cfg['refDisplay'])) {
                $alias = array_key_first($cfg['refDisplay']);
                $query->selectRaw($cfg['refDisplay'][$alias] . ' as ' . $alias);
                $query->orderBy($alias);
            } else {
                $query->addSelect($cfg['refDisplay'])->orderBy($cfg['refDisplay']);
            }
            $rows = $query->get();
            $values[$col] = $rows->map(function ($row) use ($cfg) {
                if (is_array($cfg['refDisplay'])) {
                    $alias = array_key_first($cfg['refDisplay']);
                    $label = $row->$alias;
                } else {
                    $label = $row->{$cfg['refDisplay']};
                }
                return ['value' => $row->{$cfg['refKey']}, 'label' => $label . ' (#' . $row->{$cfg['refKey']} . ')'];
            })->toArray();
        }
        return $values;
    }

    protected function applyFilters($query, array $filterConfig, Request $request, string $prefix)
    {
        foreach ($filterConfig as $col => $cfg) {
            $param = $prefix . '_' . $col;
            $query->when($request->filled($param), function ($q) use ($request, $param, $col) {
                $q->where($col, $request->input($param));
            });
        }
        return $query;
    }

    protected function getActiveFilters(Request $request, array $filterConfig, string $prefix): array
    {
        $active = [];
        foreach ($filterConfig as $col => $cfg) {
            $param = $prefix . '_' . $col;
            if ($request->filled($param)) {
                $active[$col] = $request->input($param);
            }
        }
        return $active;
    }
}

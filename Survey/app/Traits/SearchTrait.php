<?php

namespace App\Traits;

trait SearchTrait
{
    public function search($model, $columns)
    {
        foreach ($columns as $column) {


             return   $model->when($column['request'] != NULL, function ($q) use ($column) {

                    if($column['clause'] == 'where')
                    {
                        $q->where($column['column'], $column['operator'], $column['request']);
                    }// End Where

                    elseif($column['clause'] == 'orWhere')
                    {
                        $q->orWhere($column['column'], $column['operator'], $column['request']);
                    }// End orWhere

                    elseif($column['clause'] == 'whereBetween')
                    {
                        $q->whereBetween($column['column'], $column['value'] );
                    }// End whereBetween

                    elseif($column['clause'] == 'whereNotBetween')
                    {
                        $q->whereNotBetween($column['column'], $column['value'] );
                    }// End whereNotBetween

                    elseif($column['clause'] == 'whereNull')
                    {
                        $q->whereNull($column['column']);
                    }// End whereNull

                    elseif($column['clause'] == 'whereNotNull')
                    {
                        $q->whereNotNull($column['column']);
                    }// End whereNotNull

                    elseif($column['clause'] == 'whereIn')
                    {
                        $q->whereIn($column['column'], $column['value']);
                    }// End whereIn

                    elseif($column['clause'] == 'whereNotIn')
                    {
                        $q->whereNotIn($column['column'], $column['value']);
                    }// End whereNotIn

                    elseif($column['clause'] == 'whereDate')
                    {
                        $q->whereDate($column['column'], $column['operator'], $column['date']);
                    }// End whereDate


                });
            }
    }// End Search
}

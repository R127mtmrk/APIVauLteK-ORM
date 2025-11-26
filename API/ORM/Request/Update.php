<?php

/**
 * Génère une requête UPDATE SQL
 *
 * @param string $table
 * @param array  $data   Colonnes à modifier [col => val]
 * @param array  $where  Conditions WHERE : [[col, op, val], ...]
 *
 * @return array{query:string, params:array}
 */
function Update(string $table, array $data, array $where): array
{
    $params = [];
    $query = "UPDATE `$table` SET ";

    // SET column = ?
    $sets = [];
    foreach ($data as $col => $val) {
        $sets[] = "`$col` = ?";
        $params[] = $val;
    }

    $query .= implode(", ", $sets);

    // WHERE
    if ($where) {
        $parts = [];

        foreach ($where as $cond) {
            [$column, $operator, $value] = $cond;

            if (!in_array($operator, ["=", "!=", ">", "<", ">=", "<=", "LIKE"])) {
                throw new Exception("Invalid operator $operator");
            }

            $parts[] = "`$column` $operator ?";
            $params[] = $value;
        }

        $query .= " WHERE " . implode(" AND ", $parts);
    }
    $query .=';';

    return [
        "query"  => $query,
        "params" => $params
    ];
}

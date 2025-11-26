<?php

/**
 * @param string $table
 * @param array|null $fields
 * @param array|null $where
 * @param array|null $order
 * @param array|null $limit
 * @param array|null $group
 * @param array|null $joins
 * @param array|null $having
 *
 * @return array{query:string, params:array}
 * @throws Exception
 */
function Select(
    string $table,
    ?array $fields = null,
    ?array $where = null,
    ?array $order = null,
    ?array $limit = null,
    ?array $joins = null,
    ?array $group = null,
    ?array $having = null
): array {

    $params = [];
    $query  = "SELECT " . ($fields ? implode(", ", $fields) : "*");

    $query .= " FROM `$table`";

    if ($joins) {
        foreach ($joins as $join) {

            if (count($join) !== 4) {
                throw new Exception("Join format invalid. Expected: [type, table, leftField, rightField]");
            }

            [$type, $joinTable, $left, $right] = $join;

            $type = strtoupper($type);

            if (!in_array($type, ["INNER", "LEFT", "RIGHT", "FULL"])) {
                throw new Exception("Invalid JOIN type '$type'");
            }

            if ($type === "FULL") {
                $type = "LEFT";
            }

            $query .= " $type JOIN `$joinTable` ON $left = $right";
        }
    }

    if ($where) {
        $parts = [];

        foreach ($where as $cond) {
            [$column, $operator, $value] = $cond;

            switch ($operator) {
                case '=':
                case '!=':
                    $parts[] = "`$column` $operator ?";
                    $params[] = $value;
                    break;

                case 'like':
                    $parts[] = "`$column` LIKE ?";
                    $params[] = "%$value%";
                    break;

                case 'in':
                    if (!is_array($value)) {
                        throw new Exception("IN requires array value");
                    }
                    $placeholders = implode(", ", array_fill(0, count($value), "?"));
                    $parts[] = "`$column` IN ($placeholders)";
                    $params = array_merge($params, $value);
                    break;

                default:
                    throw new Exception("Invalid operator '$operator' in WHERE");
            }
        }

        $query .= " WHERE " . implode(" AND ", $parts);
    }

    if ($group) {
        $query .= " GROUP BY " . implode(", ", array_map(fn($col) => "`$col`", $group));
    }

    if ($having) {
        $havingParts = [];

        foreach ($having as $cond) {
            [$column, $operator, $value] = $cond;

            switch ($operator) {
                case '=':
                case '!=':
                case '>':
                case '>=':
                case '<':
                case '<=':
                    $havingParts[] = "$column $operator ?";
                    $params[] = $value;
                    break;

                case 'in':
                    if (!is_array($value)) {
                        throw new Exception("HAVING IN requires array");
                    }
                    $placeholders = implode(", ", array_fill(0, count($value), "?"));
                    $havingParts[] = "$column IN ($placeholders)";
                    $params = array_merge($params, $value);
                    break;

                default:
                    throw new Exception("Invalid operator '$operator' in HAVING");
            }
        }

        $query .= " HAVING " . implode(" AND ", $havingParts);
    }

    if ($order) {
        $query .= " ORDER BY ";
        $orders = [];

        foreach ($order as $col => $dir) {
            $dir = strtoupper($dir);
            if (!in_array($dir, ["ASC", "DESC"])) {
                throw new Exception("Invalid ORDER direction '$dir'");
            }
            $orders[] = "`$col` $dir";
        }

        $query .= implode(", ", $orders);
    }

    if ($limit) {
        if (isset($limit[0])) {
            $query .= " LIMIT " . (int)$limit[0];
        }
        if (isset($limit[1])) {
            $query .= " OFFSET " . (int)$limit[1];
        }
    }

    $query .= ";";

    return [
        "query"  => $query,
        "params" => $params
    ];
}
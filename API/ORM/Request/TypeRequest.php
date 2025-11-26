<?php

require 'Insert.php';
require 'Select.php';
require 'Delete.php';
require 'Update.php';
require 'Table/FieldsAndTables.php';

/**
 * @param string $type
 * @param string $table
 * @param array|null $data
 * @param array|null $where
 * @param array|null $fields
 * @param array|null $join
 * @param array|null $group
 * @param array|null $order
 * @param array|null $limit
 * @return array
 * @throws Exception
 */
function Request(string $type, string $table, ?array $data = null, ?array $where = null, ?array $fields = null,?array $join , ?array $group = null, ?array $order = null, ?array $limit = null): array {

    /** @var array<string,array> $schema */
    $schema = require __DIR__ . '/table/FieldsAndTables.php';

    if (!array_key_exists($table, $schema)) {
        throw new Exception("Table '$table' does not exist in schema.");
    }

    $type = strtolower($type);
    if ($type === 'select') {

        return Select(
            table: $table,
            fields: $fields,
            where: $where,
            group: $group,
            order: $order,
            joins: $join,
            limit: $limit
        );
    }
    if ($type === 'insert') {

        if (!$data) {
            throw new Exception("INSERT requires non-null data array.");
        }

        return Insert(
            table: $table,
            data: $data
        );
    }
    if ($type === 'update') {

        if (!$data) {
            throw new Exception("UPDATE requires data.");
        }
        if (!$where) {
            throw new Exception("UPDATE requires WHERE clause.");
        }

        return Update(
            table: $table,
            data: $data,
            where: $where
        );
    }
    if ($type === 'delete') {

        if (!$where) {
            throw new Exception("DELETE requires a WHERE clause.");
        }

        return Delete(
            table: $table,
            where: $where
        );
    }
    throw new Exception("Unknown request type '$type'");
}

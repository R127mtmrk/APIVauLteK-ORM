<?php

class UsersService
{
    public static function getAll(): array
    {
        global $pdo;

        $req = Request(
            type: "select",
            table: "users",
            fields: ["id_user", "email_user", "psd_user"]
        );

        $stmt = $pdo->prepare($req['query']);
        $stmt->execute($req['params']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOne($id): array
    {
        global $pdo;

        $req = Request(
            type: "select",
            table: "users",
            where: [["id_user", "=", $id]]
        );

        $stmt = $pdo->prepare($req['query']);
        $stmt->execute($req['params']);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(array $input): array
    {
        global $pdo;

        $req = Request(
            type: "insert",
            table: "users",
            data: [
                "email_user" => $input["email"],
                "psd_user"   => $input["psd"],
                "mdp_user"   => $input["mdp"]
            ]
        );

        $stmt = $pdo->prepare($req['query']);
        $stmt->execute($req['params']);

        return ["id" => $pdo->lastInsertId()];
    }

    public static function update(array $input): array
    {
        global $pdo;

        $req = Request(
            type: "update",
            table: "users",
            data: [
                "email_user" => $input["email"]
            ],
            where: [
                ["id_user", "=", $input["id"]]
            ]
        );

        $stmt = $pdo->prepare($req['query']);
        $stmt->execute($req['params']);

        return ["success" => true];
    }

    public static function delete($id): array
    {
        global $pdo;

        $req = Request(
            type: "delete",
            table: "users",
            where: [
                ["id_user", "=", $id]
            ]
        );

        $stmt = $pdo->prepare($req['query']);
        $stmt->execute($req['params']);

        return ["success" => true];
    }
}

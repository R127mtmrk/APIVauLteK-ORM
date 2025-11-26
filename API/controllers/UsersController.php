<?php

class UsersController
{
    public static function index()
    {
        $data = UsersService::getAll();
        Response::json($data);
    }

    public static function show()
    {
        $id = $_GET['id'] ?? null;
        $data = UsersService::getOne($id);
        Response::json($data);
    }

    public static function store()
    {
        $input = Http::body();
        $data = UsersService::create($input);
        Response::json($data);
    }

    public static function update()
    {
        $input = Http::body();
        $data = UsersService::update($input);
        Response::json($data);
    }

    public static function delete()
    {
        $id = $_GET['id'] ?? null;
        $data = UsersService::delete($id);
        Response::json($data);
    }
}

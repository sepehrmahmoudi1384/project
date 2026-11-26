<?php

namespace Admin;

use database\Database;

class Menu extends Admin
{
    public function index()
    {
        $db = new Database;
        $menus = $db
            ->select("SELECT menus.*, parentMenus.name parent_name
                FROM menus
                LEFT JOIN menus parentMenus ON menus.parent_id = parentMenus.id
                ORDER BY id DESC")
            ->fetchAll();
        require_once BASE_PATH . '/template/admin/menus/index.php';
    }

    public function create()
    {
        $db = new Database;
        $parentMenus = $db
            ->select("SELECT * FROM menus WHERE parent_id IS NULL")
            ->fetchAll();
        require_once BASE_PATH . '/template/admin/menus/create.php';
    }

    public function store(array $request)
    {
        $db = new Database;
        $request = array_filter($request);
        $db->insert('menus', array_keys($request), $request);
        $this->redirect('admin/menu');
    }

    public function edit(int $id)
    {
        $db = new Database;

        $menu = $db
            ->select('SELECT * FROM menus WHERE id=?', [$id])
            ->fetch();

        if(!$menu){
            $this->redirectBack();
        }

        $parentMenus = $db
            ->select("SELECT * 
                FROM menus 
                WHERE parent_id IS NULL AND id <> ?", [$menu['id']])
            ->fetchAll();

        require_once BASE_PATH . '/template/admin/menus/edit.php';
    }

    public function update(array $request, int $id)
    {
        $db = new Database;
        $request = array_filter($request);
        $db->update("menus", $id, array_keys($request), $request);   
        $this->redirect('admin/menu');
    }

    public function delete(int $id)
    {
        $db = new Database;
        $db->delete('menus', $id);
        $this->redirect('admin/menu');
    }
}

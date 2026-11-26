<?php

namespace Admin;

use database\Database;

class Menu extends Admin
{
    public function index()
    {
        $db = new Database;
        $menus = $db->select("SELECT * FROM menus ORDER BY id DESC");
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
        $category = $db
            ->select("SELECT * FROM categories WHERE id=?", [$id])
            ->fetch();

        if (!$category) {
            $this->redirect('admin/category');
        }

        require_once BASE_PATH . '/template/admin/categories/edit.php';
    }

    public function update(array $request, int $id)
    {
        $db = new Database;
        $db->update("categories", $id, array_keys($request), $request);
        $this->redirect('admin/category');
    }

    public function delete(int $id) {
        $db = new Database;
        $db->delete('categories', $id);
        $this->redirect('admin/category');
    }
}

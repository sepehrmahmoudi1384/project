<?php

namespace Admin;

use database\Database;

class Banner extends Admin
{
    public function index()
    {
        $db = new Database;
        $banners = $db->select("SELECT * FROM banners ORDER BY id DESC");
        require_once BASE_PATH . '/template/admin/banners/index.php';
    }

    public function create()
    {
        require_once BASE_PATH . '/template/admin/banners/create.php';
    }

    public function store(array $request)
    {
        $db = new Database;
        $request['image'] = $this->saveImage($request['image'], 'banner-image');
        if($request['image']){
            $db->insert('banners', array_keys($request), $request);
        }
        $this->redirect('admin/banner');
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

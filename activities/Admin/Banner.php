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
        if ($request['image']) {
            $db->insert('banners', array_keys($request), $request);
        }
        $this->redirect('admin/banner');
    }

    public function edit(int $id)
    {
        $db = new Database;
        $banner = $db
            ->select("SELECT * FROM banners WHERE id=?", [$id])
            ->fetch();

        if (!$banner) {
            $this->redirect('admin/banner');
        }

        require_once BASE_PATH . '/template/admin/banners/edit.php';
    }

    public function update(array $request, int $id)
    {
        $db = new Database;
        if ($request['image']['tmp_name']) {
            $banner = $db
                ->select('SELECT * FROM banners WHERE id=?', [$id])
                ->fetch();
            $request['image'] = $this->saveImage($request['image'], 'banner-image');
            $this->removeImage($banner['image']);
        } else {
            unset($request['image']);
        }
        $db->update("banners", $id, array_keys($request), $request);
        $this->redirect('admin/banner');
    }

    public function delete(int $id)
    {
        $db = new Database;
        $banner = $db
            ->select("SELECT * FROM banners WHERE id=?", [$id])
            ->fetch();

        if ($banner) {
            $this->removeImage($banner['image']);
            $db->delete('banners', $id);
        }

        $this->redirectBack();
    }
}

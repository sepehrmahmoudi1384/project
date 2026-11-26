<?php

namespace Admin;

use database\Database;

class Settings extends Admin
{
    public function index()
    {
        $db = new Database;

        $settings = $db
            ->select("SELECT * FROM settings LIMIT 1")
            ->fetch();

        if (!$settings) {
            $this->redirect('admin/settings/edit');
        }

        require_once BASE_PATH . '/template/admin/settings/index.php';
    }

    public function edit()
    {
        $db = new Database;

        $edit_mode = true;

        $settings = $db
            ->select("SELECT * FROM settings LIMIT 1")
            ->fetch();

        if (!$settings) {
            $edit_mode = false;
        }

        require_once BASE_PATH . '/template/admin/settings/edit.php';
    }

    public function update(array $request)
    {
        $db = new Database;

        if (!empty($request['logo']['tmp_name'])) {
            $request['logo'] = $this->saveImage(
                $request['logo'],
                'settings-image'
            );
        } else {
            unset($request['logo']);
        }

        if (!empty($request['icon']['tmp_name'])) {
            $request['icon'] = $this->saveImage(
                $request['icon'],
                'settings-image'
            );
        } else {
            unset($request['icon']);
        }

        $db->update("settings", 1, array_keys($request), $request);

        $this->redirect('admin/settings');
    }

    public function store(array $request)
    {
        $db = new Database;

        if (!empty($request['logo']['tmp_name'])) {
            $request['logo'] = $this->saveImage(
                $request['logo'],
                'settings-image'
            );
        } else {
            unset($request['logo']);
        }

        if (!empty($request['icon']['tmp_name'])) {
            $request['icon'] = $this->saveImage(
                $request['icon'],
                'settings-image'
            );
        } else {
            unset($request['icon']);
        }

        $db->insert("settings", array_keys($request), $request);

        $this->redirect('admin/settings');
    }
}

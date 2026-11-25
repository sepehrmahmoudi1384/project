<?php

namespace Admin;

use database\Database;

class User extends Admin
{
    public function index()
    {
        $db = new Database;
        $users = $db->select("SELECT * FROM users ORDER BY id DESC");
        require_once BASE_PATH . '/template/admin/users/index.php';
    }

    public function edit(int $id)
    {
        $db = new Database;
        $user = $db
            ->select("SELECT * FROM users WHERE id=?", [$id])
            ->fetch();

        if (!$user) {
            $this->redirect('admin/category');
        }

        require_once BASE_PATH . '/template/admin/users/edit.php';
    }

    public function update(array $request, int $id)
    {
        $allowedFields = ['username', 'permission'];
        $request = array_filter(
            $request,
            fn($key) => in_array($key, $allowedFields),
            ARRAY_FILTER_USE_KEY
        );
        $db = new Database;
        $db->update("users", $id, array_keys($request), $request);
        $this->redirect('admin/user');
    }

    public function permission(int $id)
    {
        $db = new Database;
        $post = $db
            ->select("SELECT * FROM users WHERE id=?", [$id])
            ->fetch();

        if (!$post) {
            $this->redirectBack();
        }

        if ($post['permission'] === 'user') {
            $db->update('users', $id, ['permission'], ['admin']);
        } elseif ($post['permission'] === 'admin') {
            $db->update('users', $id, ['permission'], ['user']);
        }

        $this->redirectBack();
    }

    public function delete($id)
    {
        $db = new Database;
        $db->delete('users', $id);
        $this->redirect('admin/category');
    }
}

<?php

namespace Admin;

use database\Database;

class Post extends Admin
{
    public function index()
    {
        $db = new Database;
        $posts = $db
            ->select(
                "SELECT p.*, u.username, c.name AS cat_name
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                JOIN categories c ON p.cat_id = c.id
                ORDER BY id DESC"
            )
            ->fetchAll();

        require_once BASE_PATH . '/template/admin/posts/index.php';
    }

    public function create()
    {
        $db = new Database;
        $categories = $db
            ->select("SELECT * FROM categories")
            ->fetchAll();

        require_once BASE_PATH . '/template/admin/posts/create.php';
    }

    public function store(array $request)
    {
        $realTimestamp = intval(substr($request['published_at'], 0, -3));
        $request['published_at'] = date('Y-m-d H:i:s', $realTimestamp);
        $db = new Database;
        if ($request['cat_id']) {
            $request['image'] = $this->saveImage($request['image'], 'post-image');
            if ($request['image']) {
                $request = array_merge($request, ['user_id' => 1]);
                $db->insert('posts', array_keys($request), $request);
            } else {
                $this->redirect('admin/post');
            }
        } else {
            $this->redirect('admin/post');
        }
    }
}

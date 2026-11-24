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
                $this->redirect('admin/post');
            } else {
                $this->redirect('admin/post');
            }
        } else {
            $this->redirect('admin/post');
        }
    }

    public function delete(int $id)
    {
        $db = new Database;
        $post = $db
            ->select('SELECT * FROM posts WHERE id=?', [$id])
            ->fetch();

        if ($post) {
            $this->removeImage($post['image']);
            $db->delete('posts', $id);
        }
        $this->redirectBack();
    }

    public function selected(int $id)
    {
        $db = new Database;
        $post = $db
            ->select('SELECT * FROM posts WHERE id=?', [$id])
            ->fetch();

        if (empty($post)) {
            $this->redirectBack();
        }

        if ($post['selected'] == 2) {
            $db->update('posts', $id, ['selected'], [1]);
        } else {
            $db->update('posts', $id, ['selected'], [2]);
        }

        $this->redirectBack();
    }

    public function breakingNews(int $id)
    {
        $db = new Database;
        $post = $db
            ->select('SELECT * FROM posts WHERE id=?', [$id])
            ->fetch();

        if (empty($post)) {
            $this->redirectBack();
        }

        if ($post['breaking_news'] == 2) {
            $db->update('posts', $id, ['breaking_news'], [1]);
        } else {
            $db->update('posts', $id, ['breaking_news'], [2]);
        }

        $this->redirectBack();
    }

    public function edit($id)
    {
        $db = new Database;
        $post = $db
            ->select("SELECT * FROM posts WHERE id = ?", [$id])
            ->fetch();
        $categories = $db
            ->select("SELECT * FROM categories")
            ->fetchAll();

        if (!$post) {
            $this->redirect('admin/post');
        }
        require_once BASE_PATH . '/template/admin/posts/edit.php';
    }

    public function update($request, $id)
    {
        $realTimestamp = intval(substr($request['published_at'], 0, -3));
        $request['published_at'] = date('Y-m-d H:i:s', $realTimestamp);
        $db = new Database;
        if ($request['cat_id']) {

            if ($request['image']['tmp_name'] != null) {
                $post = $db->select("SELECT * FROM posts WHERE id=?", [$id])->fetch();
                $this->removeImage($post['image']);
                $request['image'] = $this->saveImage($request['image'], 'post-image');
            } else {
                unset($request['image']);
            }

            $request = array_merge($request, ['user_id' => 1]);
            $db->update('posts', $id, array_keys($request), $request);
            $this->redirect('admin/post');
        } else {
            $this->redirect('admin/post');
        }
    }
}

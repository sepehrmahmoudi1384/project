<?php

namespace Admin;

use database\Database;

class Comment extends Admin
{
    public function index()
    {
        $db = new Database;

        $unseenComments = $db
            ->select("SELECT * FROM comments WHERE status = 'unseen'")
            ->fetchAll();

        foreach ($unseenComments as $comment) {
            if ($comment['status'] === 'unseen') {
                $db->update('comments', $comment['id'], ['status'], ['seen']);
            }
        }

        $comments = $db
            ->select('SELECT c.*, u.username, p.title post_title 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                JOIN posts p on c.post_id = p.id
                ORDER BY id DESC')
            ->fetchAll();

        require_once BASE_PATH . '/template/admin/comments/index.php';
    }

    public function changeStatus(int $id)
    {
        $db = new Database;
        $commment = $db
            ->select("SELECT * FROM comments WHERE id = ?", [$id])
            ->fetch();

        if (!$commment) {
            $this->redirectBack();
        }

        if ($commment['status'] === 'seen') {
            $db->update('comments', $id, ['status'], ['approved']);
        } elseif ($commment['status'] === 'approved') {
            $db->update('comments', $id, ['status'], ['seen']);
        }

        $this->redirectBack();
    }
}

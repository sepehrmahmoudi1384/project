<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Comments</h1>
</div>

<section class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of comments</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>username</th>
                <th>post</th>
                <th>comment</th>
                <th>status</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td>
                        <a href="">
                            <?= $comment['id'] ?>
                        </a>
                    </td>
                    <td>
                        <?= $comment['username'] ?>
                    </td>
                    <td>
                        <?= mb_substr($comment['post_title'], 0, 35) ?>...
                    </td>
                    <td>
                        <?= mb_substr($comment['comment'], 0, 35) ?>...
                    </td>
                    <td>
                        <?= $comment['status'] ?>
                    </td>
                    <td>
                        <?php if ($comment['status'] === 'approved'): ?>
                            <a role="button" class="btn btn-sm btn-warning text-white"
                                href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">click not to approved</a>
                        <?php elseif ($comment['status'] === 'seen'): ?>
                            <a role="button" class="btn btn-sm btn-success text-white"
                                href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">click to approved</a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>


<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
?>
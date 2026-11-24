<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Articles</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="<?= url('admin/post/create') ?>" class="btn btn-sm btn-success">create</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of posts</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>summary</th>
                <th>view</th>
                <th>status</th>
                <th>username</th>
                <th>category</th>
                <th>image</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($posts as $post): ?>
                <tr>
                    <td>
                        <?= $post['id'] ?>
                    </td>
                    <td>
                        <?= $post['title'] ?>
                    <td>
                        <?= $post['summary'] ?>
                    </td>
                    <td>
                        <?= $post['view'] ?>
                    </td>
                    <td>
                        <?php if ($post['breaking_news'] === 1): ?>
                            <span class="badge badge-success">#breaking_news</span>
                        <?php endif ?>

                        <?php if ($post['selected'] === 1): ?>
                            <span class="badge badge-dark">#editor_selected</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?= $post['username'] ?>
                    </td>
                    <td>
                        <?= $post['cat_name'] ?>
                    </td>
                    <td><img style="width: 80px;" src="" alt=""></td>
                    <td style="width: 25rem;">
                        <a role="button" class="btn btn-sm btn-warning btn-dark text-white" href="">
                            <?php
                            if ($post['breaking_news'] === 1) {
                                echo 'remove breaking news';
                            } else {
                                echo 'add breaking news';
                            }
                            ?>
                        </a>
                        <a role="button" class="btn btn-sm btn-warning btn-dark text-white" href="">
                            <?php
                            if ($post['selected'] === 1) {
                                echo 'remove selected';
                            } else {
                                echo 'add selected';
                            }
                            ?>
                        </a>
                        <hr class="my-1" />
                        <a role="button" class="btn btn-sm btn-primary text-white" 
                            href="<?= url('admin/post/edit/' . $post['id']) ?>">edit</a>
                        <a role="button" class="btn btn-sm btn-danger text-white" 
                            href="<?= url('admin/post/delete/' . $post['id']) ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>
<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Website Setting</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" class="btn btn-sm btn-success"
            href="<?= url('admin/settings/edit') ?>">set web setting</a>
    </div>
</div>
<section class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>Website setting</caption>
        <thead>
            <tr>
                <th>name</th>
                <th>value</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>title</td>
                <td>
                    <?= $settings['title'] ?>
                </td>
            </tr>
            <tr>
                <td>description</td>
                <td>
                    <?= $settings['description'] ?>
                </td>
            </tr>
            <tr>
                <td>key words</td>
                <td>
                    <?= $settings['key words'] ?? '' ?>
                </td>
            </tr>
            <tr>
                <td>Logo</td>
                <td>
                    <?php if (!empty($settings['logo'])): ?>
                        <img width="100px" height="100px"
                            src="<?= $settings['logo'] ?>"
                            alt="logo">
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td>Icon</td>
                <td>
                    <?php if (!empty($settings['icon'])): ?>
                        <img src="" alt="" width="100px" height="100px">
                    <?php endif ?>
                </td>
            </tr>
        </tbody>
    </table>
</section>


<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>
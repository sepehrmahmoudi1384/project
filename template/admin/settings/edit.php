<?php
require_once BASE_PATH . '/template/admin/layouts/header.php';
?>

<section class="pt-3 pb-1 mb-2 border-bottom">
    <h1 class="h5">Set Web Setting</h1>
</section>

<section class="row my-3">
    <section class="col-12">

        <form
            method="post"
            action="<?= url('admin/settings/update') ?>"
            enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="<?php if ($edit_mode) echo $settings['title'] ?>"
                    required autofocus>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    value="<?php if ($edit_mode) echo $settings['description'] ?>"
                    required autofocus>
            </div>

            <div class="form-group">
                <label for="keywords">Keywords</label>
                <input type="text" class="form-control" id="keywords" name="keywords"
                    value="<?php if ($edit_mode) echo $settings['keywords'] ?>" autofocus>
            </div>


            <div class="form-group">

                <?php if (!empty($settings['logo'])): ?>
                    <img style="width: 100px;"
                        src="<?= asset($settings['logo']) ?>" alt="logo">
                <?php endif ?>
                <hr />

                <label for="logo">Logo</label>
                <input type="file" id="logo" name="logo" class="form-control-file" autofocus>
            </div>

            <div class="form-group">

                <?php if (!empty($settings['icon'])): ?>
                    <img style="width: 100px;"
                        src="<?= asset($settings['icon']) ?>" alt="icon">
                <?php endif ?>
                <hr />

                <label for="icon">Icon</label>
                <input type="file" id="icon" name="icon" class="form-control-file" autofocus>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">set</button>
        </form>
    </section>
</section>

<?php
require_once BASE_PATH . '/template/admin/layouts/footer.php';
?>
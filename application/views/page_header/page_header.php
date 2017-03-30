<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= isset($title) ? $title : "Title" ?>
        <small><?= isset($description) ? $description : "Description" ?></small>
    </h1>
    <?= isset($breadcrumb) ? $breadcrumb : "" ?>
</section>
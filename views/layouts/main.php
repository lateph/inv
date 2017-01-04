<?php

/* @var $this \yii\web\View */
/* @var $content string */

// use Yii;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Inventory</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= Url::to(['site/logout']); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?= Yii::$app->homeUrl ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Master<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?= Url::to(['/satuan/index']); ?>">Satuan</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/kategoribarang/index']); ?>">Kategori Barang</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/barang/index']); ?>">Barang</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/project/index']); ?>">Project</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/unit/index']); ?>">Customer</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/user/index']); ?>">User</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/backuprestore']); ?>">Backup Restore</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Transaksi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?= Url::to(['/penerimaan/index']); ?>">Penerimaan Barang</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/distribusi/index']); ?>">Distribusi Barang</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/adjustment/index']); ?>">Adjustment</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Laporan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?= Url::to(['/laporanpenerimaan/index']); ?>">Laporan Penerimaan</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/laporandistribusi/index']); ?>">Laporan Distribusi</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/laporanadjustment/index']); ?>">Laporan Adjustment</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/laporanstokbarang/index']); ?>">Laporan Stok Barang</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/laporanstokmutasi/index']); ?>">Laporan Mutasi Stok</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/laporanstokwarning/index']); ?>">Laporan Stok Barang Warning</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" style="padding-top:20px">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

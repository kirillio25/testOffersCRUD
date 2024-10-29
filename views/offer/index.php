<?php
use app\assets\AppAsset;

AppAsset::register($this);
use yii\helpers\Html;

$this->title = 'Офферы';
?>

<div class="container mt-4">
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <!-- Фильтрация -->
    <div class="filter-section p-3 mb-4 bg-light rounded">
        <div class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="title-filter" class="form-control" placeholder="Поиск по названию оффера">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="text" id="email-filter" class="form-control" placeholder="Поиск по email представителя">
                </div>
            </div>
        </div>
    </div>


    <div id="notification" class="alert alert-success" style="display: none">
        <span id="notification-message"></span>
    </div>

    <!-- Офферы -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Дата добавления</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="offer-list">
                <?php foreach ($dataProvider->models as $offer): ?>
                    <tr data-id="<?= $offer->id ?>" class="clickable-row">
                        <td><?= Html::encode($offer->id) ?></td>
                        <td><?= Html::encode($offer->title) ?></td>
                        <td><?= Html::encode($offer->email) ?></td>
                        <td><?= Html::encode($offer->phone) ?></td>
                        <td><?= Html::encode($offer->created_at) ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <button class="btn btn-danger btn-sm delete-offer" data-id="<?= $offer->id ?>">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Пагинация -->
    <div id="pagination" class="d-flex justify-content-center">
        <?= $this->render('_pagination', ['dataProvider' => $dataProvider]) ?>
    </div>

    <!-- Модальное окно для редактирования -->
    <?= $this->render('_edit') ?>

    <!-- Модальное окно для удаления -->
    <?= $this->render('_delete') ?>
</div>
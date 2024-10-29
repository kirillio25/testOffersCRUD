<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Офферы';
?>

<div class="container mt-4">
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <!-- Форма для фильтрации -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="title-filter" class="form-control" placeholder="Название оффера">
        </div>
        <div class="col-md-4">
            <input type="text" id="email-filter" class="form-control" placeholder="Email представителя">
        </div>
        <div class="col-md-4">
            <button id="filter-button" class="btn btn-primary w-100">Фильтровать</button>
        </div>
    </div>

    <!-- Таблица с офферами -->

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
                    <tr data-id="<?= $offer->id ?>">
                        <td><?= Html::encode($offer->id) ?></td>
                        <td><?= Html::encode($offer->title) ?></td>
                        <td><?= Html::encode($offer->email) ?></td>
                        <td><?= Html::encode($offer->phone) ?></td>
                        <td><?= Html::encode($offer->created_at) ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <button class="btn btn-warning btn-sm edit-offer" data-id="<?= $offer->id ?>">
                                    Редактировать
                                </button>
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
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>

<!-- Модальное окно для редактирования оффера -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редактировать Оффер</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Название оффера</label>
                        <input type="text" class="form-control" id="edit-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email представителя</label>
                        <input type="email" class="form-control" id="edit-email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-phone" class="form-label">Телефон представителя</label>
                        <input type="text" class="form-control" id="edit-phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для подтверждения удаления -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Подтвердите удаление</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить этот оффер?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" id="confirm-delete" class="btn btn-danger">Удалить</button>
            </div>
        </div>
    </div>
</div>

<?php
// URL для AJAX-запроса
$editUrl = Url::to(['offer/edit']);

$deleteUrl = Url::to(['offer/delete']);
$this->registerJs("
// Открытие модального окна редактирования с заполнением данных оффера
// Открытие модального окна редактирования с заполнением данных оффера
$('.edit-offer').on('click', function() {
    var id = $(this).data('id');
    $.get('$editUrl', { id: id })
    .done(function(data) {
        if (data && data.success !== false) {
            $('#edit-id').val(data.id); // Загружаем ID в скрытое поле
            $('#edit-title').val(data.title);
            $('#edit-email').val(data.email);
            $('#edit-phone').val(data.phone);
            $('#editModal').modal('show');
        } else {
            alert('Не удалось загрузить данные для редактирования: ' + (data.message || 'Неизвестная ошибка'));
        }
    })
    .fail(function(jqXHR) {
        alert('Ошибка при загрузке данных: ' + jqXHR.responseText);
    });
});



// Обработка отправки формы редактирования
$('#edit-form').on('submit', function(e) {
    e.preventDefault();

    var id = $('#edit-id').val();
    var title = $('#edit-title').val();
    var email = $('#edit-email').val();
    var phone = $('#edit-phone').val();
$.ajax({
    url: '$editUrl',
    type: 'POST',
    data: {
        id: id,
        title: title,
        email: email,
        phone: phone
    },
    dataType: 'json', // Ожидаемый формат ответа от сервера
    success: function(response) {
        if (response.success) {
            $('#editModal').modal('hide');
            location.reload();
        } else {
            alert('Ошибка при сохранении: ' + (response.message || 'Неизвестная ошибка'));
        }
    },
    error: function(jqXHR) {
        alert('Ошибка при сохранении: ' + jqXHR.responseText);
    }
});






});




    // Открытие модального окна удаления
    $('.delete-offer').on('click', function() {
        var id = $(this).data('id');
        $('#confirm-delete').data('id', id);
        $('#deleteModal').modal('show');
    });

    // Подтверждение удаления оффера
    $('#confirm-delete').on('click', function() {
        var id = $(this).data('id');
        $.post('$deleteUrl', { id: id }, function() {
            $('#deleteModal').modal('hide');
            location.reload(); // обновляем страницу
        });
    });
");
?>

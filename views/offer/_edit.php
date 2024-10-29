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

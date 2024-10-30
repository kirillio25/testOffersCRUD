// Настройка CSRF-токена
$.ajaxSetup({
  headers: {
    "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
  },
});

// Функция для отображения уведомления об ошибках валидации
function showErrorMessages(errors) {
  let errorContainer = $("#validation-errors");
  errorContainer.html(""); 

  for (let field in errors) {
    errors[field].forEach(function (message) {
      errorContainer.append(
        '<div class="alert alert-danger">' + message + "</div>"
      );
    });
  }

  errorContainer.fadeIn().delay(5000).fadeOut();
}

// Функция для показа уведомлений
function showNotification(message) {
  $("#notification-message").text(message);
  $("#notification").fadeIn().delay(3000).fadeOut(); 
}

// Функция для загрузки данных (с фильтрацией и пагинацией)
function fetchOffers(pageUrl = "/offer/index") {
  $.ajax({
    url: pageUrl,
    type: "GET",
    data: {
      title: $("#title-filter").val(),
      email: $("#email-filter").val(),
    },
    success: function (data) {
      $("#offer-list").html($(data).find("#offer-list").html());
      $("#pagination").html($(data).find("#pagination").html());
    },
    error: function (jqXHR) {
      alert("Ошибка при загрузке данных: " + jqXHR.responseText);
    },
  });
}

// Функция с задержкой для запуска фильтрации
let filterTimeout;
$("#title-filter, #email-filter").on("input", function () {
  clearTimeout(filterTimeout);
  filterTimeout = setTimeout(fetchOffers, 500); 
});

// Обработчик для пагинации
$(document).on("click", "#pagination a", function (e) {
  e.preventDefault();
  var pageUrl = $(this).attr("href");
  fetchOffers(pageUrl);
});

// Открытие модального окна редактирования 
$(document).on("click", ".clickable-row", function (e) {

  if ($(e.target).closest(".delete-offer").length) return;

  var id = $(this).data("id");
  $.get("/offer/edit", { id: id })
    .done(function (data) {
      if (data && data.success !== false) {
        $("#edit-id").val(data.id);
        $("#edit-title").val(data.title);
        $("#edit-email").val(data.email);
        $("#edit-phone").val(data.phone);
        $("#editModal").modal("show");
      } else {
        alert(
          "Не удалось загрузить данные для редактирования: " +
            (data.message || "Неизвестная ошибка")
        );
      }
    })
    .fail(function (jqXHR) {
      alert("Ошибка при загрузке данных: " + jqXHR.responseText);
    });
});

// Обработка отправки формы редактирования
$("#edit-form").on("submit", function (e) {
  e.preventDefault();

  var id = $("#edit-id").val();
  var title = $("#edit-title").val();
  var email = $("#edit-email").val();
  var phone = $("#edit-phone").val();

  $.ajax({
    url: "/offer/edit",
    type: "POST",
    data: {
      id: id,
      title: title,
      email: email,
      phone: phone,
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $("#editModal").modal("hide");
        fetchOffers(); 
        showNotification("Оффер успешно обновлен");
      } else if (response.errors) {
        showErrorMessages(response.errors);
      } else {
        alert(
          "Ошибка при сохранении: " + (response.message || "Неизвестная ошибка")
        );
      }
    },
    error: function (jqXHR) {
      alert("Ошибка при сохранении: " + jqXHR.responseText);
    },
  });
});

// Открытие модального окна удаления
$(document).on("click", ".delete-offer", function (e) {
  e.preventDefault();
  var id = $(this).data("id");
  $("#confirm-delete").data("id", id);
  $("#deleteModal").modal("show");
});

// Подтверждение удаления оффера
$("#confirm-delete").on("click", function () {
  var id = $(this).data("id");
  $.post("/offer/delete", { id: id }, function (response) {
    if (response.success) {
      $("#deleteModal").modal("hide");
      fetchOffers();
      showNotification("Оффер успешно удален");
    } else {
      alert(
        "Ошибка при удалении: " + (response.message || "Неизвестная ошибка")
      );
    }
  }).fail(function (jqXHR) {
    alert("Ошибка при удалении: " + jqXHR.responseText);
  });
});

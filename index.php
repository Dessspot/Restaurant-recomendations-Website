<?php 
  $title_name = 'Главная'; 
  require "vendor/connect.php";
  require 'blocks/header.php';
?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=ВАШ_API_КЛЮЧ&lang=ru_RU" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 

<style>
    li.list-group-item:hover {
    background-color: #ccc; /* Цвет фона при наведении */
}
</style>

<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow" tabindex="-1" role="dialog" id="modalSignin">
    
    <div class="col-md-12 text-center"> 
        <h1>Добро пожаловать</h1>
        <h3>на рекомендационную систему ресторанов</h3>
    </div>
   

    <div class="d-flex justify-content-center">
        <div id="map" style="width: 600px; height: 200px;"></div>
    </div>

    <form class="text-center m-4" id="coordForm" action="vendor/coord.php" method="post">
        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required>
        <br>
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required>
        <br>
        <button type="submit" id="submitBtn">Отправить</button>
    </form>

<div style="display: flex; justify-content: center;">
    <div id="resultContainer" style="width: 700px; background: white; border-radius: 16px; "></div>
</div>

</div>

<script>
$(document).ready(function () {
    $("#coordForm").submit(function (event) {
        event.preventDefault();

        var formData = {
            longitude: $("#longitude").val(),
            latitude: $("#latitude").val()
        };

        $.ajax({
            type: "POST",
            url: "vendor/coord.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                // Обновление контейнера с результатами
                var recommendationsHtml = '</h6><h2 class="m-3">Рекомендации:</h2><ul style="padding: 20px; padding-top: 0;">';

                for (var i = 0; i < response.recommendations.length; i++) {
                    var restaurant = response.recommendations[i];
                  
                    recommendationsHtml += '<li class="list-group-item d-flex justify-content-between align-items-start">';
                    recommendationsHtml += '<div class="ms-2 me-auto">';
                    recommendationsHtml += '<div class="fw-bold">' + restaurant.name + '</div>';
                    recommendationsHtml += '<p>Адрес: ' + restaurant.address + '</p>';
                    recommendationsHtml += '</div>';
                    recommendationsHtml += '<span class="badge bg-primary rounded-pill">Rating: ' + restaurant.stars + '</span>';
                    recommendationsHtml += '<a href="restaurant_page.php?business_id=' + restaurant.business_id + '" class="stretched-link"></a>';
                    recommendationsHtml += '</li>';
                }

                recommendationsHtml += "</ul>";
                $("#resultContainer").html(recommendationsHtml);
            },
            error: function (error) {
                console.error("Ошибка при выполнении AJAX запроса:", error);
            }
        });
    });
});
</script>

<script>
    ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [39.3473, -98.1715], // Координаты центра карты
        zoom: 4 // Уровень масштабирования
    });

    myMap.events.add('click', function (e) {
        var coords = e.get('coords');
        
        // Обновление значений полей ввода
        document.getElementById('longitude').value = coords[1].toPrecision(6);
        document.getElementById('latitude').value = coords[0].toPrecision(6);

        // Отображение координат в блоке
        document.getElementById('coordinates').innerHTML = 'Координаты: ' + coords[0].toPrecision(6) + ', ' + coords[1].toPrecision(6);
    });
}

</script>
    
<?php require 'blocks/footer.php'; ?>
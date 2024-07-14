<?php 
$title_name = 'Карта'; 
require 'vendor/connect.php';
$statement = $connect->prepare("SELECT business_id, name, latitude, longitude, address, cluster FROM datta limit 10000");
$statement->execute();
$datta = $statement->fetchAll(PDO::FETCH_ASSOC);
require 'blocks/header.php';
?>
 
<div id="map" style="width: 100%; height: 610px;"></div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=a59df5ae-a050-44fd-b97d-cb3a12a806c0&lang=ru_RU" type="text/javascript"></script>
<script>
    ymaps.ready(init);

    function init() { 
        let myMap = new ymaps.Map("map", {
            center: [39.3473, -98.1715],
            zoom: 5
        });

        <?php foreach ($datta as $data): ?>
            (function() {
                let placemark = new ymaps.Placemark(
                    [<?= $data['latitude'] ?>, <?= $data['longitude'] ?>], {
                    balloonContent: <?= json_encode('<div class="balloon" style="display: flex; justify-content: space-between;"><a href="restaurant_page.php?business_id=' . $data['business_id'] . '"><div><h4>Название: ' . $data['name'] . '</h4></div><div><p>Адрес: ' . $data['address'] . '</p><p>Кластер: ' . $data['cluster'] . '</p></div></a></div>') ?>


                }, {
                    iconLayout: 'default#image',
                    iconImageHref: 'https://cdn-icons-png.flaticon.com/128/10238/10238858.png',
                    iconImageSize: [64, 64],
                    iconImageOffset: [-32, -64]
                });

                myMap.geoObjects.add(placemark);
            })();
        <?php endforeach; ?>
    }
</script>
<?php require 'blocks/footer.php'; ?>
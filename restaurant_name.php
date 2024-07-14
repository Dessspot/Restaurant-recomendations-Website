<?php 
    require 'vendor/connect.php';
    $business_id = $_GET['business_id'];

    $cluster = $_GET['cluster']; 


    $clusterNames = [
        0 => 'Сент-Питерсберг',
        1 => 'Гарден-Сити',
        2 => 'Филадельфия',
        3 => 'Нэшвилл',
        4 => 'Тусон',
        5 => 'Эдмонтон',
        6 => 'Новый Орлеан',
        7 => 'Сент-Луис',
        8 => 'Санта-Барбара',
        9 => 'Индианаполис',
        10 => 'Рино',
    ];

    $statment = $connect->prepare("SELECT * from datta where business_id = :business_id");
    $statment->bindparam(':business_id', $business_id);
    $statment->execute();
    $Restaurant = $statment->fetchAll(PDO::FETCH_ASSOC);

    // $statment2 = $connect->prepare("SELECT * from revrev where business_id = :business_id");
    // $statment2->bindparam(':business_id', $business_id);
    // $statment2->execute();
    // $reviews = $statment2->fetchAll(PDO::FETCH_ASSOC);
    
    $statment3 = $connect->prepare("SELECT count(*) from revrev where business_id = :business_id");
    $statment3->bindparam(':business_id', $business_id);
    $statment3->execute();
    $count = $statment3->fetch(PDO::FETCH_ASSOC);

    $statment4 = $connect->prepare("SELECT * from users join revrev on users.user_id = revrev.user_id where business_id = :business_id limit 40");
    $statment4->bindparam(':business_id', $business_id);
    $statment4->execute();
    $reviews = $statment4->fetchAll(PDO::FETCH_ASSOC);

    $clusterName = isset($clusterNames[$_GET['cluster']]) ? $clusterNames[$_GET['cluster']] : 'Неизвестный город';

    $title_name = 'Название ресторана';  
    require 'blocks/header.php';
?> 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=a59df5ae-a050-44fd-b97d-cb3a12a806c0&lang=ru_RU" type="text/javascript"></script>


<div class="bg-body-secondary">
<?php foreach ($Restaurant as $name): ?>
    <h5 class="" style="margin-bottom: -1rem; padding-top: 35px; padding-left: 40px;">
        <a href="index.php" style="text-decoration: none;">Главная</a> 
        <span style="color: blue;">/</span> 
        <a href="restaurants.php" style="text-decoration: none;">Рестораны</a>
        <span style="color: blue;">/</span> 
        <a href="restaurants_city.php?cluster=<?= $cluster; ?>" style="text-decoration: none;">
        <?= $clusterName; ?> 
        </a>
        <span style="color: blue;">/</span> 
        <?= $name['name'];?>
    </h5>
<?php endforeach; ?>
</div>

<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow d-flex flex-nowrap" tabindex="-1" role="dialog" id="modalSignin">

    <div class="" style="width: -webkit-fill-available; max-width: 1150px; margin-right: 25px;">
        <div class="d-flex" style="max-width: 1050px; margin-bottom: 20px;">

            <div class="card">
                <svg class="bd-placeholder-img card-img" width="500" height="260" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Card image" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
            </div>
            
            <div class="m-4">
                <?php foreach ($Restaurant as $name): ?>
                    <h1><?= $name['name'];?></h1>
                    <h5>Город: <?= $clusterName;?></h5>
                    <h5>Адрес: <?= $name['address'];?></h5>
                    <p><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20" aria-hidden="true" height="18" width="18" xmlns="http://www.w3.org/2000/svg" style="color: rgb(255, 209, 46);"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Рейтинг: <?= $name['stars'];?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-bottom: 60px; max-width: 1050px;">
            <?php foreach ($Restaurant as $name): ?>
                <h3>Кухня: <?= $name['categories'];?></h3>
                <h5>Время работы: <?= $name['hours'];?></h5>
            <?php endforeach; ?>
        </div>
        <div style="display: flex; flex-direction: row-reverse; max-width: 1050px;">
            <div id="map" style="width: 400px; height: 260px; margin-bottom: 60px;"></div>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm" style="max-width: 1050px;">

            <?php foreach ($count as $coun): ?>
                <h4 class="border-bottom pb-2 mb-0"><?= $coun; ?> комментария</h4>
            <?php endforeach; ?>

            <?php foreach ($reviews as $review): ?>
                <div class="d-flex text-body-secondary pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    <strong class="d-block text-gray-dark" style="font-size: larger; padding-bottom: 5px;">@<?= $review['name'];?> <span style="padding-left: 15px; font: -webkit-control;"><?= $review['date'];?></span></strong>
                    <?= $review['text'];?>
                </p>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
    
    
    <div id="resultContainer"></div>

</div>
<script>
    $(document).ready(function () {
        // Получаем значение business_id из PHP
        var business_id = <?= json_encode($business_id); ?>;

        // Отправляем запрос при загрузке страницы
        $.ajax({
            type: "POST",
            url: "vendor/sim_rest.php",
            data: { business_id: business_id },
            dataType: "json",
            success: function (response) {
                // Обновление контейнера с результатами
                var rest_data_html = '<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary" style="width: 380px;">';
                rest_data_html += '<p class="d-flex align-items-center justify-content-center flex-shrink-0 p-3 mb-0 link-body-emphasis text-decoration-none border-bottom">';
             
                rest_data_html += '<svg class="bi me-2" width="45" height="45">';
                rest_data_html += '<foreignObject width="100%" height="100%">';
                rest_data_html += '<img class="rounded-circle" width="45" height="45" src="img/RR-logo2-copy.jpg" />';
                rest_data_html += '</foreignObject>';
                rest_data_html += '</svg>';
               
                rest_data_html += '<span class="fs-5 fw-semibold">Похожие рестораны</span>';
                rest_data_html += '</p>';
                rest_data_html += '<div class="list-group list-group-flush border-bottom scrollarea">';

                for (var i = 0; i < response.rest_data.length; i++) {
                    var restaurant = response.rest_data[i];
                
                    rest_data_html += '<a href="restaurant_page.php?business_id=' + restaurant.business_id + '" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">';
                    rest_data_html += '<div class="d-flex w-100 align-items-center justify-content-between">';
                    rest_data_html += '<strong class="mb-1">' + restaurant.name + '</strong>';
                    rest_data_html += '<small>state: ' + restaurant.state + '</small>';
                    rest_data_html += '</div>';
                    rest_data_html += '<div class="col-10 mb-1 small">Адрес ' + restaurant.address + '</div>';
                    rest_data_html += '</a>';
                }

                rest_data_html += '</div></div>';
                $("#resultContainer").html(rest_data_html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Ошибка при выполнении AJAX запроса:", textStatus, errorThrown);
            }
        });
    });
</script>

<script>
    ymaps.ready(init);

    function init() { 
        <?php foreach ($Restaurant as $data): ?>
        let myMap = new ymaps.Map("map", {
            center: [<?= $data['latitude'] ?>, <?= $data['longitude'] ?>],
            zoom: 10
        });

        
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

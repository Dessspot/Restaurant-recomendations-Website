<?php 
    require 'vendor/connect.php';

    $statment=$connect->prepare("SELECT datta.business_id, datta.name, datta.stars, datta.address, COALESCE(COUNT(revrev.business_id), 0) as comment_count
    FROM datta
    LEFT JOIN revrev ON datta.business_id = revrev.business_id
    GROUP BY datta.business_id, datta.name, datta.stars, datta.address
    HAVING COALESCE(COUNT(revrev.business_id), 0) > 20
    ORDER BY datta.stars DESC, comment_count DESC limit 500");
    $statment->execute();
    $restaurants=$statment->fetchAll(PDO::FETCH_ASSOC);


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

    $statment2 = $connect->prepare("SELECT DISTINCT cluster FROM datta");
    $statment2->execute();
    $city=$statment2->fetchAll(PDO::FETCH_ASSOC);

    $title_name = "Рестораны";
    require 'blocks/header.php';
?>
 
<div class="bg-body-secondary">
    <h5 class="" style="margin-bottom: -1rem; padding-top: 35px; padding-left: 40px;">
        <a href="index.php" style="text-decoration: none;">Главная</a> 
        <span style="color: blue;">/</span> 
        Рестораны
    </h5>
</div>
    
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow" tabindex="-1" role="dialog" id="modalSignin">    
    <div class="d-flex">
        <div class="d-flex flex-column">
            <input style="margin-bottom: 15px;" type="search" class="form-control form-control-dark" id="search-item2" placeholder="Поиск по городу..." onkeyup="search('button', 'search-item2')" aria-label="Search" >

            <?php foreach ($city as $gorod): ?>
                <?php
                // Получаем название кластера из массива
                $clusterName = isset($clusterNames[$gorod['cluster']]) ? $clusterNames[$gorod['cluster']] : 'Неизвестный город';
                ?>
                <a href="restaurants_city.php?cluster=<?= $gorod['cluster']; ?>">
                    <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;"><?= $clusterName; ?></button>
                </a>
            <?php endforeach; ?>
        </div>

        <div style="margin-left: 200px;">
            <ul class="list-group" style="width: 700px;">
                <input style="margin-bottom: 15px;" type="search" class="form-control form-control-dark" id="search-item" placeholder="Поиск ресторана..." onkeyup="search('.for_search', 'search-item')" aria-label="Search" >
                <?php foreach ($restaurants as $name): ?>
                    <div class="for_search">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $name['name'];?></div>
                                <p>Адрес: <?= $name['address'];?></p>
                            </div>
                            <span class="badge bg-primary rounded-pill">rating: <?= $name['stars'];?></span>
                            <a href="restaurant_page.php?business_id=<?= $name['business_id'];?>" class="stretched-link"></a>
                        </li>
                    </div>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    const search = (itemsSelector, searchboxId) => {
        const searchbox = document.getElementById(searchboxId).value.toUpperCase();
        const productItems = document.querySelectorAll(itemsSelector);

        for (let i = 0; i < productItems.length; i++) {
            let product = productItems[i];
            let pname = product.textContent || product.innerHTML;

            if (pname.toUpperCase().indexOf(searchbox) > -1) {
                product.style.display = "";
            } else {
                product.style.display = "none";
            }
        }
    }
</script>

<?php require 'blocks/footer.php'; ?>

<?php 
require 'vendor/connect.php';

$cluster = $_GET['cluster'];  
$categoria = $_GET['categoria'];  

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

$statment2 = $connect->prepare("SELECT datta.business_id, datta.name, datta.cluster, datta.categories, datta.stars, datta.address, COALESCE(COUNT(revrev.business_id), 0) as comment_count
FROM datta
LEFT JOIN revrev ON datta.business_id = revrev.business_id
WHERE datta.cluster = :cluster and datta.categories like '%$categoria%'
GROUP BY datta.business_id, datta.name, datta.cluster, datta.categories, datta.stars, datta.address
HAVING COALESCE(COUNT(revrev.business_id), 0) >= 0 
ORDER BY datta.stars DESC, comment_count desc");
$statment2->bindParam(':cluster', $cluster);
$statment2->execute();
$categories = $statment2->fetchAll(PDO::FETCH_ASSOC);

$title_name = "Рестораны по городам";

$clusterName = isset($clusterNames[$cluster]) ? $clusterNames[$cluster] : 'Неизвестный город';

require 'blocks/header.php';
?>

<div class="bg-body-secondary">
    <h5 class="" style="margin-bottom: -1rem; padding-top: 35px; padding-left: 40px;">
        <a href="index.php" style="text-decoration: none;">Главная</a> 
        <span style="color: blue;">/</span> 
        <a href="restaurants.php" style="text-decoration: none;">Рестораны</a> 
        <span style="color: blue;">/</span> 
        <a href="restaurants_city.php?cluster=<?= $cluster; ?>" style="text-decoration: none;">
            <?= $clusterName; ?>
        </a> 
        <span style="color: blue;">/</span> 
        <?= $categoria ?>
    </h5>
</div>
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow" tabindex="-1" role="dialog" id="modalSignin">    
    <div class="d-flex justify-content-center">
        <div>
            <ul class="list-group" style="width: 700px;">
            <h3>Рестораны по городу <?= $clusterName;?> и по кухню <?= $categoria;?></h3>
                <input style="margin-bottom: 15px;" type="search" class="form-control form-control-dark" id="search-item" placeholder="Поиск ресторана..." onkeyup="search('.for_search', 'search-item')" aria-label="Search" >
                <?php foreach ($categories as $name): ?>
                    <div class="for_search">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $name['name'];?></div>
                                <p>Адрес: <?= $name['address'];?></p>
                            </div>
                            <span class="badge bg-primary rounded-pill">rating: <?= $name['stars'];?></span>
                            <a href="restaurant_name_categoria.php?business_id=<?= $name['business_id'];?>&cluster=<?= $cluster; ?>&categoria=<?= $categoria; ?>" class="stretched-link"></a>
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
<?php 
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

require 'vendor/connect.php';
    $statment=$connect->prepare("SELECT datta.business_id, datta.name, datta.stars, datta.address, COALESCE(COUNT(revrev.business_id), 0) as comment_count
    FROM datta
    LEFT JOIN revrev ON datta.business_id = revrev.business_id
    WHERE datta.cluster = :cluster
    GROUP BY datta.business_id, datta.name, datta.stars, datta.address
    HAVING COALESCE(COUNT(revrev.business_id), 0) > 20
    ORDER BY datta.stars DESC, comment_count DESC
    LIMIT 800");
    $statment->bindparam(':cluster', $cluster);
    $statment->execute();
    $Restaurant=$statment->fetchAll(PDO::FETCH_ASSOC);


    $title_name = "Рестораны по городам";
    require 'blocks/header.php';
?>

<?php
    $clusterName = isset($clusterNames[$_GET['cluster']]) ? $clusterNames[$_GET['cluster']] : 'Неизвестный город';
?>

<div class="bg-body-secondary">
        <h5 class="" style="margin-bottom: -1rem; padding-top: 35px; padding-left: 40px;">
            <a href="index.php" style="text-decoration: none;">Главная</a> 
            <span style="color: blue;">/</span> 
            <a href="restaurants.php" style="text-decoration: none;">Рестораны</a> 
            <span style="color: blue;">/</span> 
            <?= $clusterName; ?>
        </h5>
</div>
    
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow" tabindex="-1" role="dialog" id="modalSignin">    
    <div class="d-flex">
        <div class="d-flex flex-column">
        
            <input style="margin-bottom: 15px;" type="search" class="form-control form-control-dark" id="search-item2" placeholder="Поиск кухням..." onkeyup="search('button', 'search-item2')" aria-label="Search" >
            
            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Japanese">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Japanese</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Korean">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Korean</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Italian">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Italian</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Chinese">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Chinese</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Canadian">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Canadian</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Asian Fusion">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Asian Fusion</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Fast Food">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Fast Food</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Coffee & Tea">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Coffee & Tea</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Mexican">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Mexican</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Burgers">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Burgers</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=American (New)">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">American (New)</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Pizza">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Pizza</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Sandwiches">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Sandwiches</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Vietnamese">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Vietnamese</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Chicken Wings">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Chicken Wings</button>
            </a>

            <a href="restaurants_categories.php?cluster=<?= $cluster;?>&categoria=Indian">
                <button type="submit" class="btn btn-secondary mb-1" style="width: 100%;">Indian</button>
            </a>
        </div>

        <div style="margin-left: 200px;">
            <ul class="list-group" style="width: 700px;">

                
                <h2>Рестораны по городу <?= $clusterName;?></h2>
                
                <input style="margin-bottom: 15px;" type="search" class="form-control form-control-dark" id="search-item" placeholder="Поиск ресторана..." onkeyup="search('.for_search', 'search-item')" aria-label="Search" >
                
                <?php foreach ($Restaurant as $name): ?>
                    <div class="for_search">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $name['name'];?></div>
                                <p>Адрес: <?= $name['address'];?></p>
                            </div>
                            <span class="badge bg-primary rounded-pill">rating: <?= $name['stars'];?></span>
                            <a href="restaurant_name.php?business_id=<?= $name['business_id']; ?>&cluster=<?= $cluster; ?>" class="stretched-link"></a>
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

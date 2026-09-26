<ul>
    <?php
    if(!isset($subcategories)) {
        $subcategories = load_categories(0);
    }
    else {
        $subcategories = load_categories($subcategories["categories"][0]['parent_id']);
    }
    
    foreach($subcategories["categories"] as $category): ?>
        <li><a href="index.php?page=category&id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
        <?php 
            $subcategories = load_categories($category['id']);
            if(!empty($subcategories["categories"])) {
                include "menu.php";
        }?>
    <?php endforeach; ?>
</ul>
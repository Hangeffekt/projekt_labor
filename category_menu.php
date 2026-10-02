<ul>
    <?php
    if(!isset($subcategories)) {
        $subcategories = load_categories(0);
    }
    else {
        $subcategories = load_categories($subcategories["categories"][0]['parent_id']);
    }
    
    foreach($subcategories["categories"] as $category): ?>
        <li class="category-item"><a href="index.php?page=category&id=<?=$category['id'] ?>" class="category-tabs"><?= $category['name'] ?></a>
            <?php 
                $children = load_categories($category['id']);
                if(!empty($children["categories"])): ?>
                    <button
                        class="category-toggle"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#cat<?= $category['id'] ?>">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="collapse" id="cat<?= $category['id'] ?>">
                        <div class="new-container padding-values">
                           <?php
                            $subcategories = $children;
                            include "category_menu.php";
                            ?>
                        </div>
                    </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
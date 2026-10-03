<?php

function get_category_by_id($id) {
    $categories = load_categories(0);
    foreach ($categories["categories"] as $category) {
        if ($category['id'] == $id) {
            return $category;
        }
        $result = find_category($category, $id);
        if ($result !== null) {
            return $result;
        }
    }
    return null;
}

function find_category($category, $id) {
    $children = load_categories($category['id']);
    foreach ($children["categories"] as $child) {
        if ($child['id'] == $id) {
            return $child;
        }
        $result = find_category($child, $id);
        if ($result !== null) {
            return $result;
        }
    }
    return null;
}

function get_breadcrumbs($category_id) {
    $breadcrumbs = [];
    while ($category_id != 0) {
        $category = get_category($category_id);
        if (!$category) {
            break;
        }
        array_unshift($breadcrumbs, $category);
        $category_id = $category['parent_id'];
    }
    return $breadcrumbs;
}
?>

<nav aria-label="breadcrumb" class="breadcrumb">
    <a href="index.php?page=main">Kezdőlap</a>
    <?php
    if (isset($_GET['id']) && $_GET['page'] === 'category'):
        $breadcrumbs = get_breadcrumbs((int) $_GET['id']);
        foreach ($breadcrumbs as $index => $category):
    ?>
        <span class="breadcrumb-separator">
            <i class="bi bi-chevron-right"></i>
        </span>
        <?php if ($index === array_key_last($breadcrumbs)): ?>
            <span class="active">
                <?= htmlspecialchars($category['name']) ?>
            </span>
        <?php else: ?>
            <a href="index.php?page=category&id=<?= (int)$category['id'] ?>">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endif; ?>
    <?php
        endforeach;

    elseif (isset($_GET['id']) && $_GET['page'] === 'product'):
        $product_data = product_details((int) $_GET['id']);
        $product = $product_data['product'];
        if ($product):
            $breadcrumbs = get_breadcrumbs((int) $product['catalog_id']);
            foreach ($breadcrumbs as $category):
        ?>
        <span class="breadcrumb-separator">
            <i class="bi bi-chevron-right"></i>
        </span>
        <a href="index.php?page=category&id=<?= (int)$category['id'] ?>">
            <?= htmlspecialchars($category['name']) ?>
        </a>
        <?php
        endforeach;
        ?>
        <span class="breadcrumb-separator">
            <i class="bi bi-chevron-right"></i>
        </span>
        <span class="active">
            <?= htmlspecialchars($product['brand_name'] . ' ' . $product['product_name']) ?>
        </span>
    <?php endif;
    endif;
    ?>
</nav>
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require __DIR__ . '../../../database/db_connect.php';

// Fetch all navigation items
function fetchNavigationItems($conn)
{
    try {
        $sql = "SELECT * FROM navigation ORDER BY parent_id, id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}


function buildTree($items, $parent_id = 0)
{
    $tree = [];
    foreach ($items as $item) {
        if ($item['parent_id'] == $parent_id) {
            $children = buildTree($items, $item['id']);
            if ($children) {
                $item['children'] = $children;
            }
            $tree[] = $item;
        }
    }
    return $tree;
}

function renderNavigation($items, $is_dropdown = false)
{
    if (empty($items)) return '';

    $class = $is_dropdown ? 'dropdown-menu' : 'navbar-nav';
    $html = "<ul class='$class'>";

    foreach ($items as $item) {
        $hasChildren = isset($item['children']) && !empty($item['children']);

        if ($hasChildren) {
            // Parent with children (dropdown)
            $html .= "<li class='nav-item dropdown'>";
            $html .= "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
            $html .= htmlspecialchars($item['name']);
            $html .= "</a>";
            $html .= renderNavigation($item['children'], true);
            $html .= "</li>";
        } else {
            // Regular link
            $itemClass = $is_dropdown ? 'dropdown-item' : 'nav-link';
            $html .= "<li class='" . ($is_dropdown ? '' : 'nav-item') . "'>";
            $html .= "<a class='$itemClass' href='" . htmlspecialchars($item['url']) . "'>";
            $html .= htmlspecialchars($item['name']);
            $html .= "</a>";
            $html .= "</li>";
        }
    }

    $html .= "</ul>";
    return $html;
}

$navItems = fetchNavigationItems($conn);
$navTree = buildTree($navItems);


$stmt = $conn->query($cteQuery);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

function buildTreeFromCTE($rows) {
    $map = [];
    $tree = [];

    foreach ($rows as $row) {
        $row['children'] = [];
        $map[$row['id']] = $row;
    }

    foreach ($map as $id => &$node) {
        if ($node['parent_id'] == 0) {
            $tree[] = &$node;
        } else {
            $map[$node['parent_id']]['children'][] = &$node;
        }
    }

    return $tree;
}

$navTree = buildTreeFromCTE($rows);

function renderNavigation($items, $isDropdown = false) {
    if (!$items) return '';

    $ulClass = $isDropdown ? 'dropdown-menu' : 'navbar-nav';
    $html = "<ul class='$ulClass'>";

    foreach ($items as $item) {
        $hasChildren = !empty($item['children']);

        if ($hasChildren) {
            $liClass   = $isDropdown ? 'dropdown-submenu' : 'nav-item dropdown';
            $linkClass = $isDropdown ? 'dropdown-item dropdown-toggle' : 'nav-link dropdown-toggle';

            $html .= "<li class='$liClass'>";
            $html .= "<a href='#' class='$linkClass' data-bs-toggle='dropdown'>";
            $html .= htmlspecialchars($item['name']);
            $html .= "</a>";
            $html .= renderNavigation($item['children'], true);
            $html .= "</li>";
        } else {
            $itemClass = $isDropdown ? 'dropdown-item' : 'nav-link';

            $html .= "<li class='" . ($isDropdown ? '' : 'nav-item') . "'>";
            $html .= "<a class='$itemClass' href='{$item['url']}'>";
            $html .= htmlspecialchars($item['name']);
            $html .= "</a>";
            $html .= "</li>";
        }
    }

    $html .= "</ul>";
    return $html;
}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">

    <a class="navbar-brand" href="/">MySite</a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <?php echo renderNavigation($navTree); ?>
    </div>

  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

.dropdown-submenu {
  position: relative;
}

.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: .1rem;
}

.dropdown-submenu:hover > .dropdown-menu {
  display: block;
}


?>



<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php echo renderNavigation($navTree); ?>
        </div>
    </div>
</nav>

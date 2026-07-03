<?php
/*
    CARDPAY SUITE - Docs sidebar (single source of truth).
    Every docs/*.php page includes this instead of copy-pasting the nav.
    Set $activeDoc before including to highlight the current page, e.g.:

        <?php $activeDoc = 'iso8583'; include '../includes/docs-sidebar.php'; ?>

    Valid $activeDoc keys: index, lifecycle, iso8583, emv-tlv, glossary.
    Add a new docs page by adding one <a> below — updates all pages at once.
*/
$activeDoc = isset($activeDoc) ? $activeDoc : '';
$docsNav = array(
    'Fundamentals' => array(
        array('key' => 'index',     'href' => 'index.php',                 'icon' => 'fa-book-open', 'label' => 'Introduction'),
        array('key' => 'lifecycle', 'href' => 'transaction-lifecycle.php', 'icon' => 'fa-route',     'label' => 'Transaction Flow'),
    ),
    'Technical Standards' => array(
        array('key' => 'iso8583', 'href' => 'iso8583.php', 'icon' => 'fa-code',      'label' => 'ISO 8583 Standard'),
        array('key' => 'emv-tlv', 'href' => 'emv-tlv.php', 'icon' => 'fa-microchip', 'label' => 'EMV & TLV Logic'),
    ),
    'Reference' => array(
        array('key' => 'glossary', 'href' => 'glossary.php', 'icon' => 'fa-list', 'label' => 'Glossary of Terms'),
    ),
);
?>
<aside class="docs-sidebar glass-panel">
    <div class="sidebar-header">
        <h3>Learning Center</h3>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($docsNav as $groupTitle => $items): ?>
            <div class="nav-group">
                <span class="group-title"><?php echo $groupTitle; ?></span>
                <?php foreach ($items as $item): ?>
                    <a href="<?php echo $item['href']; ?>" class="nav-item<?php echo ($activeDoc === $item['key']) ? ' active' : ''; ?>">
                        <i class="fa-solid <?php echo $item['icon']; ?>"></i> <?php echo $item['label']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </nav>
</aside>

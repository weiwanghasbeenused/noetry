<?php 
// require_once __DIR__ . '/../static/php/getHomeListItems.php';

// $list_items = getHomeListItems($db);
?>
<div id="home" class="page">
    <div style="display:flex; justify-content: space-between;">
        <h1 class="regular bold">心雜音 demo</h1>
        <button onclick="window.location.reload();" style="font-size: 0.8em; padding: 0.8em; border-radius: 8px; border: 1px solid; color: #000;">Refresh</button>
    </div>
    <div id="home-body" class="medium">
    <?php 
        echo $item['body'];
    ?>
    </div>
</div>
<style>

</style>
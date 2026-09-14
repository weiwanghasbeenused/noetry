<?php 
    function renderNavButton($data){
        $active = isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === $data['link'];
        $icon = $data['icon'] ? '<div class="icon"><img src="'.$data['icon'].'"></div>' : '<div class="placeholder-icon icon"></div>';
        $link_inner = $icon . '<div class="nav-section-name small">'.$data['display'].'</div>';
        $link = $data['link'] && ! $active ? '<a class="nav-button button" href="'.$data['link'].'">' . $link_inner . '</a>' : '<div class="nav-button button">' . $link_inner . '</div>';
        return '<div class="nav-left nav-section">' . $link . '</div>';
    }

    $nav_buttons = [
        [
            'slug' => 'diary',
            'display' => '雜音',
            'link' => '/diary',
            'icon' => ''
        ],
        [
            'slug' => 'essays',
            'display' => '篇章',
            'link' => '/essays',
            'icon' => ''
        ]
    ];
?>

<div id="main-nav" class="full-vw fixed" data-fixed-align="bottom">
    <?php foreach($nav_buttons as $nav_button) {
        echo renderNavButton($nav_button);
    }?>
</div>
<?php

function renderMask(){
    return '<div id="mask" class="full-vw full-vh fixed" data-hidden="1"></div>';
}
?>
<style>
    #mask {
        background-color: rgba(0, 0, 0, 0.5);
        top: 0;
        left: 0;
        z-index: 1050;
        transition: opacity 0.3s ease-in-out;
    }
    #mask[data-hidden="1"] {
        opacity: 0;
        pointer-events: none;
    }
</style>
<?php
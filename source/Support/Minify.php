<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minifyCss = new \MatthiasMullie\Minify\CSS();
    $minifyCss->add(__DIR__ . "/../../assets/styles/styles.css");
    $minifyCss->add(__DIR__ . "/../../assets/styles/boot.css");

    $cssDirectory = scandir(__DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/css");

    foreach ($cssDirectory as $css) {
        $cssFile = __DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/css/{$css}";

        if(is_file($cssFile) && pathinfo($cssFile)['extension'] == "css") {
            $minifyCss->add($cssFile);
//            echo "{$cssFile}<br>";
        }
    }

    $minifyCss->minify(__DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/style.css");

    /**
     * JS
     */
    $minifyJs = new \MatthiasMullie\Minify\JS();
    $minifyJs->add(__DIR__ . "/../../assets/scripts/jquery.min.js");
    $minifyJs->add(__DIR__ . "/../../assets/scripts/jquery-ui.js");

    $jsDirectory = scandir(__DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/js");

    foreach ($jsDirectory as $js) {
        $jsFile = __DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/js/{$js}";

        if(is_file($jsFile) && pathinfo($jsFile)['extension'] == "js") {
            $minifyJs->add($jsFile);
//            echo "{$jsFile}<br>";
        }
    }

    $minifyJs->minify(__DIR__ . "/../../themes/" . CONFIG_VIEW_THEME . "/assets/script.js");
}
<?php
    if(isset($_SESSION['username']))
        $USERNAME = $_SESSION['username'];
    else
        $USERNAME = null;
?>

<div class="header">
    <div id="header-content">
        <div id="left">
            <div id="nav" onclick="hamburger_menu()">
                <span id="s1"></span>
                <span id="s2"></span>
                <span id="s3"></span>
            </div>
            <a id="logo-a" href="<?=$GLOBALS['apppath']?>"><img id="logo-img" src="<?=$GLOBALS['apppath']?>images/logo.svg" width="154"></a>
            <div id="menu">
                <a href="movie?filter=popular">Movies</a>
                <a href="tv?filter=popular">TV Shows</a>
            </div>
        </div>
        <div id="right">
            <a id="search-bar-btn" style="color: var(--sec-header-color); font-size: 18px;"><i class="fa-solid fa-magnifying-glass"></i></a>
        </div>
    </div>
</div>
<div id="slider-menu">
    <div><a href="<?=$GLOBALS['apppath']?>movie?filter=popular">Movies</a></div>
    <div><a href="<?=$GLOBALS['apppath']?>tv?filter=popular">TV Shows</a></div>
</div>
<div id="header-search-bar">   
    <div id="header-search-bar-wrapper">
        <form id="search-form" method="GET" action="<?=$GLOBALS['apppath']?>search">
            <label>
            <span>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search for a movie, TV show, person..." name="query">
            </span>
            </label>
        </form>
    </div>
</div>
<script src="<?=$GLOBALS['apppath']?>js/search_bar.js"></script>
<script src="<?=$GLOBALS['apppath']?>js/hamburger.js"></script>

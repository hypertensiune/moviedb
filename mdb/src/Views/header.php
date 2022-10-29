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
            <a id="logo-a" href="/mdb"><img id="logo-img" src="/mdb/images/logo.svg" width="154"></a>
            <div id="menu">
                <a href="/mdb/movie?filter=popular">Movies</a>
                <a href="/mdb/tv?filter=popular">TV Shows</a>
            </div>
        </div>
        <div id="right">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="/mdb/u/<?=$_SESSION['username']?>"><i class="fa-regular fa-user"></i></a>
                <a href="/mdb/logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            <?php else: ?>
                <a style="text-decoration: none;" href="/mdb/login">Login</a>
            <?php endif ?>
            <a id="search-bar-btn" style="color: var(--sec-header-color); font-size: 18px;"><i class="fa-solid fa-magnifying-glass"></i></a>
        </div>
    </div>
</div>
<div id="slider-menu">
    <div><a href="/mdb/movie?filter=popular">Movies</a></div>
    <div><a href="/mdb/tv?filter=popular">TV Shows</a></div>
</div>
<div id="header-search-bar">   
    <div id="header-search-bar-wrapper">
        <form id="search-form" method="GET" action="/mdb/search">
            <label>
            <span>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search for a movie, TV show, person..." name="query">
            </span>
            </label>
        </form>
    </div>
</div>
<script src="/mdb/js/search_bar.js"></script>
<script src="/mdb/js/hamburger.js"></script>

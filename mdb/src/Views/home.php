<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Database</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>

</head>
<body>
    <?php include 'src/Views/header.html'; ?>

    <div id="welcome-content">
        <div id="welcome-wrapper">
            <div id="welcome-center">
                <div id="title">
                    <h2 style="font-weight: 700; font-size: 3em;">Welcome</h2>
                    <h3 style="font-weight: 600; font-size: 2em;">Millions of movies, TV shows and people to discover. Explore Now</h3>
                </div>  
                <div id="search-bar">
                    <form method="GET" action="./search">
                        <input type="text" placeholder="Search for a movie, tv show, person..." name="query">
                        <input type="submit" value="Search">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

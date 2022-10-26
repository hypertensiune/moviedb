<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERVER ERROR</title>

    <link rel="stylesheet" href="/mdb/css/global.css">
    <link rel="stylesheet" href="/mdb/css/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        #content{
            text-align: center;
            top: 50px;
            position: relative;
            font-size: 20px;
        }

        @media only screen and (max-width: 560px) {
            #content{
                top: 113px;
            }
        }
    </style>

</head>

<body>
    <?php include 'src/Views/header.html'; ?>

    <div id="content">
        The page you requested doesn't exist.
    </div>

    <?php include 'src/Views/footer.html'; ?>
    <style>
        .footer {
            position: fixed;
            top: unset;
            bottom: 0;
        }
    </style>

</body>

</html>
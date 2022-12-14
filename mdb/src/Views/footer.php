<div class="footer">
    <style id="footer-css">
        .footer {
            position: relative;
            top: 150px;
            background-color: var(--main-header-color);
            width: 100%;
            height: 330px;
            color: white;
        }

        #footer-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin-left: 20px;
            margin-right: 20px;
        }

        .footer h3 {
            margin: 0 0 4px 0;
            font-size: 1.2em;
        }

        @media only screen and (max-width: 660px) {
            #footer-container {
                flex-direction: column;
            }

            .footer h3 {
                font-size: 1em;
            }

            #footer-text {
                margin-top: 30px;
            }
        }
    </style>
    <div id="footer-container">
        <div style="float: left;">
            <img id="logo-img" src="<?=$GLOBALS['apppath']?>images/logo2.svg" width=130>
        </div>
        <div id="footer-text" style="float: right; margin-left: 50px;">
            <h3>This is not <a style="text-decoration: underline; color: white;"
                    href="https://www.themoviedb.org/">themoviedb.org</a>.</h3>
            <h3>This is a clone created for learning purposes.</h3>
            <h3>This website uses data from 
                <a style="text-decoration: underline; color: white;" href="https://developers.themoviedb.org/3/getting-started">TMDB Api.</a>
            <h3>
        </div>
    </div>
    <script>
        
    </script>
</div>
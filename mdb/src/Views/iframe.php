<?php
    if($TYPE == "MOVIE")
        $VIDEOS = Movie::getIframe($movie_id)['results'];
    else
        $VIDEOS = TV::getIframe($movie_id)['results'];

    $link = null;
    foreach ($VIDEOS as $video) {
        if ($video['type'] == 'Trailer') {
            $link = $video['key'];
            break;
        }
    }
    echo $link;
?>

<style>
    #trailer_iframe_container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        background-color: black;
        z-index: 8;
    }

    #trailer_iframe_container iframe {
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    @media only screen and (max-width: 1400px) {
        #trailer_iframe_container {
            width: 90%;
        }
    }
</style>

<script>

    window.addEventListener('resize', () => {
        let w = $("#trailer_iframe_container").css('width');
        $("#trailer_iframe").css('height', w.slice(0, -2) / 1.77777778);
    });

</script>

<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.5; background-color: black; z-index: 8;"></div>
<div id="trailer_iframe_container">
    <div style="padding: 16px;">
        <span style="color: white; font-size: 20px; cursor: default;">Play Trailer</span>
        <span id="trailer_close" style="font-size: 20px; color: white; float: right;" onclick=close_trailer()><i class="fa-solid fa-xmark"></i></span>
    </div>
    <div id="trailer_iframe" style="width: 100%;">
        <iframe src="https://www.youtube.com/embed/<?=$link?>?autoplay=1&modestbranding=1&fs=1" title="YouTube video player" frameborder="0" autoplay="1" allowfullscreen></iframe>
    </div>
</div>

<?php
/** The index file of the video controller
 *  @todo       This currently shows an overview of movies, rewrite to something more generic for movies, and move this part to other file.
 *  @package    Views
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      09-04-2014
 */
?>
<img id="fanart" />

<div id="coverflow_top">
    <div id="search">
        <form action="<?php echo WWWBASE ?>video/search/" autocomplete="off" method="post">
            <label>Search:
                <input type="text" name="searchfor" />
            </label>
        </form>
    </div>
</div>

<div id="imageflow_wrapper">
    <div id="imageflow" class="imageflow">
        <?php $i = 0; foreach($movies AS $key => $movie) : ?>
            <?php if(in_array($movie['c00'], $searchedMovies)) : ?>
                <img src="<?php echo $movie['thumb'] ?>" alt="<?php echo utf8_encode($movie['c00']) ?>" longdesc="video/movie/<?php echo $movie['idMovie'] ?>"
                     rel="<?php echo $movie['fanart'] ?>" title="<?php echo utf8_encode($movie['c00']) ?>" />
            <?php else : ?>
                <span class="hidden" src="<?php echo $movie['thumb'] ?>" id="span_<?php echo $i ?>" alt="<?php echo utf8_encode($movie['c00']) ?>"
                      longdesc="video/movie/<?php echo $movie['idMovie'] ?>" rel="<?php echo $movie['fanart'] ?>" title="<?php echo utf8_encode($movie['c00']) ?>"></span>
            <?php endif ?>
        <?php $i++; endforeach ?>
    </div>
</div>

<a id="fancyboxtrigger" class="hidden" href="http://google.com">Fancybox trigger</a>
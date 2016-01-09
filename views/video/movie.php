<?php
/** Shows the details for a movie
 *  @package    Views
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */
?>

<div id="header_wrapper">
    <h1><?php echo utf8_encode($movie['c00']) ?></h1>
    <p><?php echo utf8_encode($movie['c03']) ?></p>
</div>

<div id="trailer_wrapper">
    <?php if(!empty($trailer)) : ?>
        <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $trailer ?>" frameborder="0" allowfullscreen></iframe>
    <?php else : ?>
        <p>Sorry, no trailer found</p>
    <?php endif ?>
</div>

<table cellpadding="0" cellspacing="0" id="moviedetails">
    <tr>
        <th colspan="2">Details</th>
    </tr>
    <tr>
        <td class="label">Plot</td>
        <td>
            <p class="hidden" id="plot"><?php echo $movie['c01'] ?></p>
            <a href="#" id="toggleCompleteOutline">Show</a>
        </td>
    </tr>
    <tr class="even">
        <td class="label">Rating</td>
        <td><?php echo round($movie['c05'], 1) ?></td>
    </tr>
    <tr>
        <td class="label">Genre</td>
        <td><?php echo $movie['c14'] ?></td>
    </tr>
    <tr class="even">
        <td class="label">Year</td>
        <td><?php echo $movie['c07'] ?></td>
    </tr>
    <tr>
        <td class="label">Director</td>
        <td><?php echo $movie['c15'] ?></td>
    </tr>
    <tr class="even">
        <td class="label">Writers</td>
        <td><?php echo $movie['c06'] ?></td>
    </tr>
    <tr>
        <td class="label">Studio</td>
        <td><?php echo $movie['c18'] ?></td>
    </tr>
    <tr class="even">
        <td class="label">Country</td>
        <td><?php echo $movie['c21'] ?></td>
    </tr>
</table>

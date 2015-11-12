<?php /** @var \RedDevil\Collections\TodoCollection $model */ ?>

<h1>All Todos:</h1>
<ul>
    <?php
    $model->each(function ($item) {
        echo "<li>" . $item->getText() . "</li>";
    })
    ?>
</ul>
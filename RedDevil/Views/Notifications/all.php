<?php /** @var \RedDevil\ViewModels\NotificationViewModel[] $model */?>

<div class="col-md-9">
    <h2>Notifications</h2>
    <?php foreach ($model as $notification) : ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <strong>Date: </strong>
                <?php
                echo $notification->getCreatedOn();
                ?> <br/>
                <strong>Text: </strong>
                <?php
                echo $notification->getContent();
                ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php
    if (count($model) == 0) {
        echo "<p>You don't have notifications at the moment.</p>";
    }
    ?>
</div>
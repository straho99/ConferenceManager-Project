<?php /** @var \RedDevil\ViewModels\NotificationViewModel[] $model */
use RedDevil\ViewHelpers\ActionLink; ?>

<div class="col-md-9">
    <h2>Notifications</h2>
        <?php
        ActionLink::create()
            ->setAttribute('href', '/notifications/markAllAsRead')
            ->setAttribute('class', 'btn btn-warning')
            ->setData('Mark all as read')
            ->render();
        ?>
    <br/>
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
        echo "<p>You don't have any unread notifications at the moment.</p>";
    }
    ?>
</div>
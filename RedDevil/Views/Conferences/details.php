<?php /** @var \RedDevil\ViewModels\ConferenceDetailsViewModel $model */
use RedDevil\ViewHelpers\ActionLink; ?>
<div class="col-md-9">
    <div class="jumbotron">
        <h1>
            <?php
            echo $model->getTitle();
            ?>
        </h1>
        <p>
            <strong>Starts on: </strong>
            <?php
            $dt = new DateTime($model->getStartDate());
            echo $dt->format('d/M/Y');
            ?>
        </p>
        <p>
            <strong>Ends on: </strong>
            <?php
            $dt = new DateTime($model->getEndDate());
            echo $dt->format('d/M/Y');
            ?>
        </p>
        <p>
            <strong>Organizer: </strong>
            <?php
            ActionLink::create()
                ->setAttribute('href', '/users/' . $model->getOwnerUsername())
                ->setData($model->getOwnerUsername())
                ->render();
            ?>
        </p>
    </div>
    <h3>
        Lectures
    </h3>
    <?php foreach ($model->getLectures() as $lecture) : ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php
                    echo $lecture->getTitle();
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="media">
                    <div class="media-body">
                        <strong>Speaker: </strong>
                        <?php
                        ActionLink::create()
                            ->setAttribute('href', '/users/' . $lecture->getSpeakerId())
                            ->setData($lecture->getSpeakerUsername())
                            ->render();
                        ?>
                        <strong>Start: </strong>
                        <?php
                        $lecture->getStartDate();
                        ?>
                        <strong>End: </strong>
                        <?php
                        $lecture->getEndDate();
                        ?>
                        <strong>Participants: </strong>
                        <?php
                        echo $lecture->getParticipantsCount();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php
    if (count($model->getLectures()) == 0) {
        echo 'This conference have no lectures at the moment.';
    }
    ?>
</div>
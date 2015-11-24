<?php /** @var \RedDevil\ViewModels\ConferenceDetailsViewModel $model */
use RedDevil\View;
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
            echo $model->getStartDate();
            ?>
        </p>
        <p>
            <strong>Ends on: </strong>
            <?php
            echo $model->getEndDate();
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
        <p>
            <strong>Venue: </strong>
            <?php
            $venue = $model->getVenue() == null ? '(not available)' :
                $model->getVenue();
            if ($model->getVenue() == null) {
                \RedDevil\ViewHelpers\ActionLink::create()
                    ->setAttribute('href', '#')
                    ->setData($venue)
                    ->render();
            } else {
                \RedDevil\ViewHelpers\ActionLink::create()
                    ->setAttribute('href', '/venues/details/' . $model->getVenueId())
                    ->setData($venue)
                    ->render();
            }
            ?>
        </p>

        <?php
        new View("Conferences", "_ConferenceMenu", $model, null);
        ?>

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
                        if ($lecture->getSpeakerId() == '') {
                            echo $lecture->getSpeakerUsername();
                            echo "<br/>";
                        } else {
                            ActionLink::create()
                                ->setAttribute('href', '/users/' . $lecture->getSpeakerId())
                                ->setData($lecture->getSpeakerUsername())
                                ->render();
                        }
                        ?>
                        <strong>At hall: </strong>
                        <?php
                        echo $lecture->getHallTitle();
                        ?>
                        <br/>
                        <strong>Start: </strong>
                        <?php
                        echo $lecture->getStartDate();
                        ?>
                        <br/>
                        <strong>End: </strong>
                        <?php
                        echo $lecture->getEndDate();
                        ?>
                        <br/>
                        <strong>Participants: </strong>
                        <?php
                        echo $lecture->getParticipantsCount();
                        ?>
                        <br/>
                        <?php
                        new View("Conferences", "_LectureMenu", $lecture, null);
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
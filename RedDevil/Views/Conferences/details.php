<?php /** @var \RedDevil\ViewModels\ConferenceDetailsViewModel $model */
use RedDevil\Core\HttpContext;
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
                ->setAttribute('href', '/users/' . $model->getOwnerUsername() . '/info')
                ->setData($model->getOwnerUsername())
                ->render();
            ?>
        </p>
        <p>
            <strong>Venue: </strong>
            <?php
            if ($model->getVenueId() != null && $model->getVenueRequestStatus() == 1) {
                \RedDevil\ViewHelpers\ActionLink::create()
                    ->setAttribute('href', '/venues/details/' . $model->getVenueId())
                    ->setNewLineAfter(false)
                    ->setData($model->getVenue())
                    ->render();
                echo " <span class='label label-success'>confirmed</span>";
            } else if ($model->getVenueId() != null && $model->getVenueRequestStatus() == 0) {
                \RedDevil\ViewHelpers\ActionLink::create()
                    ->setAttribute('href', '/venues/details/' . $model->getVenueId())
                    ->setNewLineAfter(false)
                    ->setData($model->getVenue())
                    ->render();
                echo " <span class='label label-warning'>not confirmed</span>";
            } else {
                echo '(not available)';
            }
            ?>
        </p>

        <?php
        if ($model->getOwnerId() == HttpContext::getInstance()->getIdentity()->getUserId()) {
            new View("Conferences", "_ConferenceMenu", $model, null);
        }
        ActionLink::create()
            ->setAttribute('href', '/conferences/autoSchedule/' . $model->getId())
            ->setAttribute('class', 'btn btn-info pull-right')
            ->setNewLineAfter(false)
            ->setData('Auto Schedule')
            ->render();
        if (HttpContext::getInstance()->getIdentity()->isInRole('admin') &&
            $model->getOwnerId() != HttpContext::getInstance()->getIdentity()->getUserId()) {
            ActionLink::create()
                ->setAttribute('href', '/conferences/' . $model->getId() . '/delete/confirm')
                ->setAttribute('class', 'btn btn-danger')
                ->setNewLineAfter(false)
                ->setData('Delete Conference')
                ->render();
        }
        ?>

    </div>
    <h3>
        Lectures
    </h3>
    <?php foreach ($model->getLectures() as $lecture) : ?>
        <div class="panel panel-info">
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
                        if ($lecture->getSpeakerId() != null && $lecture->getSpeakerRequestStatus() == 1) {
                            \RedDevil\ViewHelpers\ActionLink::create()
                                ->setAttribute('href', '/users/' . $lecture->getSpeakerUsername() . '/info')
                                ->setNewLineAfter(false)
                                ->setData($lecture->getSpeakerUsername())
                                ->render();
                            echo " <span class='label label-success'>confirmed</span>";
                        } else if ($lecture->getSpeakerId() != null && $lecture->getSpeakerRequestStatus() == 0) {
                            \RedDevil\ViewHelpers\ActionLink::create()
                                ->setAttribute('href', '/users/' . $lecture->getSpeakerUsername() . '/info')
                                ->setNewLineAfter(false)
                                ->setData($lecture->getSpeakerUsername())
                                ->render();
                            echo " <span class='label label-warning'>not confirmed</span>";
                        } else {
                            echo '(not available)';
                        }
                        ?>
                        <br/>
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
                        if ($model->getOwnerId() == HttpContext::getInstance()->getIdentity()->getUserId()) {
                            new View("Conferences", "_LectureMenu", $lecture, null);
                        }
                        ?>
                        <?php
                        if ($lecture->getHallId() !== '') {
                            if ($lecture->getIsParticipating() == false && $lecture->getCanParticipate() == true) {
                                ActionLink::create()
                                    ->setAttribute('href', '/lectures/' . $lecture->getId() . '/participate')
                                    ->setAttribute('class', 'btn btn-success pull-right')
                                    ->setNewLineAfter(false)
                                    ->setData('Join')
                                    ->render();
                            } else {
                                echo "<a class='btn btn-success pull-right' disabled>Join</a>";
                            }
                        }
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
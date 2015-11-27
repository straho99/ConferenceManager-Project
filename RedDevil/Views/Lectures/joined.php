<?php /** @var \RedDevil\ViewModels\LectureViewModel[] $model */
use RedDevil\ViewHelpers\ActionLink;
?>

<div class="col-md-9">
    <h3>
        Lectures you have subscribed to participate
    </h3>
    <?php foreach ($model as $lecture) : ?>
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
                            ActionLink::create()
                                ->setAttribute('href', '/users/' . $lecture->getSpeakerUsername() . '/info')
                                ->setNewLineAfter(false)
                                ->setData($lecture->getSpeakerUsername())
                                ->render();
                            echo " <span class='label label-success'>confirmed</span>";
                        } else if ($lecture->getSpeakerId() != null && $lecture->getSpeakerRequestStatus() == 0) {
                            ActionLink::create()
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
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php
    if (count($model) == 0) {
        echo 'You have not subscribed to any lectures at the moment.';
    }
    ?>
</div>

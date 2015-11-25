<?php /** @var \RedDevil\ViewModels\SpeakerInvitationViewModel[] $model */
use RedDevil\ViewHelpers\ActionLink;

?>
<div class="col-md-9">
    <h3>
        Pending Speaker Invitations
    </h3>
    <?php foreach ($model as $invitation) : ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php
                    echo "Invitation for conference: " . $invitation->getConferenceTitle();
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="media">
                    <div class="media-body">
                        <strong>Lecture: </strong>
                        <?php
                        echo $invitation->getLectureTitle()
                        ?>
                        <br/>
                        <strong>Starts on: </strong>
                        <?php
                        echo $invitation->getStartDate();
                        ?>
                        <br/>
                        <strong>Ends on: </strong>
                        <?php
                        echo $invitation->getEndDate();
                        ?>
                        <br/>
                        <br/>
                        <?php
                        ActionLink::create()
                            ->setAttribute('href', '/users/approveinvitation/' . $invitation->getId())
                            ->setAttribute('class', 'btn btn-success')
                            ->setNewLineAfter(false)
                            ->setData('Approve')
                            ->render();
                        ?>
                        <?php
                        ActionLink::create()
                            ->setAttribute('href', '/users/rejectinvitation/' . $invitation->getId())
                            ->setAttribute('class', 'btn btn-danger')
                            ->setNewLineAfter(false)
                            ->setData('Reject')
                            ->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php
    if (count($model) == 0) {
        echo "You don't have any pending venue requests at the moment.";
    }
    ?>
</div>
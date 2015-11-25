<?php /** @var \RedDevil\ViewModels\OwnerVenueRequestViewModel[] $model */
use RedDevil\ViewHelpers\ActionLink;

?>
<div class="col-md-9">
    <h3>
        Pending Venue Requests
    </h3>
    <?php foreach ($model as $request) : ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php
                    echo "Request for venue: " . $request->getVenueName();
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="media">
                    <div class="media-body">
                        <strong>Conference: </strong>
                        <?php
                        echo $request->getConferenceTitle()
                        ?>
                        <br/>
                        <strong>Starts on: </strong>
                        <?php
                        echo $request->getStartDate();
                        ?>
                        <br/>
                        <strong>Ends on: </strong>
                        <?php
                        echo $request->getEndDate();
                        ?>
                        <br/>
                        <br/>
                        <?php
                        ActionLink::create()
                            ->setAttribute('href', '/venues/approverequest/' . $request->getId())
                            ->setAttribute('class', 'btn btn-success')
                            ->setNewLineAfter(false)
                            ->setData('Approve')
                            ->render();
                        ?>
                        <?php
                        ActionLink::create()
                            ->setAttribute('href', '/venues/rejectrequest/' . $request->getId())
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
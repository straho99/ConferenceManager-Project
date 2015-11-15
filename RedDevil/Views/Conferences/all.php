<?php /** @var \RedDevil\ViewModels\ConferenceSummaryViewModel[] $model */?>
<div class="col-md-7 col-md-offset-1">
<?php foreach ($model as $conference) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php
                echo $conference->getName();
                ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-body">
                    <strong>Starts on: </strong>
                    <?php
                    echo $conference->getStartDate();
                    ?>
                    <br />
                    <strong>Ends on:</strong>
                    <?php
                    echo $conference->getEndDate();
                    ?>
                    <br />
                    <strong>Venue:</strong>
                    <?php
                    echo $conference->getVenue() == null ? '(not available)' : $conference->getVenue();
                    ?>
                    <br />
                    <strong>Organizer:</strong>
                    <?php
                    echo $conference->getOwnerUsername();
                    ?>
                    <br />
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
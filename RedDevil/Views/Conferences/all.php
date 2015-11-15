<?php /** @var \RedDevil\ViewModels\ConferenceSummaryViewModel[] $model */?>
<div class="col-md-7 col-md-offset-1">
<?php foreach ($model as $conference) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php
                \RedDevil\ViewHelpers\ActionLink::create()
                    ->setAttribute('href', '/conferences/details' . $conference->getId())
                    ->setData($conference->getName())
                    ->render();
                ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-body">
                    <strong>Starts on: </strong>
                    <?php
                    $dt = new DateTime($conference->getStartDate());
                    echo $dt->format('d/M/Y');
                    ?>
                    <br />
                    <strong>Ends on:</strong>
                    <?php
                    $dt = new DateTime($conference->getEndDate());
                    echo $dt->format('d/M/Y');
                    ?>
                    <br />
                    <strong>Venue:</strong>
                    <?php
                    \RedDevil\ViewHelpers\ActionLink::create()
                        ->setAttribute('href', '/venues/details/' . $conference->getVenueId())
                        ->setData($conference->getVenue())
                        ->render();
                    ?>
                    <strong>Organizer:</strong>
                    <?php
                    \RedDevil\ViewHelpers\ActionLink::create()
                        ->setAttribute('href', '/users/' . $conference->getOwnerUsername())
                        ->setData($conference->getOwnerUsername())
                        ->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
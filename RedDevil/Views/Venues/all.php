<?php /** @var \RedDevil\ViewModels\VenueSummaryViewModel[] $model */?>
<div class="col-md-9">
    <h2>All venues</h2>
    <?php foreach ($model as $venue) : ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php
                    \RedDevil\ViewHelpers\ActionLink::create()
                        ->setAttribute('href', '/venues/details/' . $venue->getId())
                        ->setData($venue->getTitle())
                        ->render();
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="media">
                    <div class="media-body">
                        <strong>Address: </strong>
                        <?php
                        echo $venue->getAddress();
                        ?>
                        <br />
                        <strong>Owner:</strong>
                        <?php
                        \RedDevil\ViewHelpers\ActionLink::create()
                            ->setAttribute('href', '/users/' . $venue->getOwnerUsername() . '/info')
                            ->setData($venue->getOwnerUsername())
                            ->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
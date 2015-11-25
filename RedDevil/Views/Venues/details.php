<?php /** @var \RedDevil\ViewModels\VenueDetailsViewModel $model */
use RedDevil\ViewHelpers\ActionLink; ?>
<div class="col-md-9">
<div class="jumbotron">
    <h1>
        <?php
        echo $model->getTitle();
        ?>
    </h1>
    <p>
        <?php
        echo $model->getDescription();
        ?>
    </p>
    <p>
        <?php
        echo $model->getAddress();
        ?>
    </p>
    <p>
        <strong>Owner: </strong>
        <?php
        ActionLink::create()
            ->setAttribute('href', '/users/' . $model->getOwnerUsername() . '/info')
            ->setData($model->getOwnerUsername())
            ->render();
        ?>
    </p>
</div>
<h3>
    Halls
    <?php
    ActionLink::create()
        ->setAttribute('href', '/venues/' . $model->getId() . '/addhall')
        ->setAttribute('class', 'btn btn-success')
        ->setData('Add Hall')
        ->render();
    ?>
</h3>
<?php foreach ($model->getHalls() as $hall) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php
                echo $hall->getTitle();
                ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-body">
                    <strong>Capacity: </strong>
                    <?php
                    echo $hall->getCapacity();
                    ActionLink::create()
                        ->setAttribute('href', '/venues/' . $model->getId() . '/deletehall/' . $hall->getId())
                        ->setAttribute('class', 'btn btn-danger pull-right')
                        ->setData('Delete')
                        ->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
    <?php
    if (count($model->getHalls()) == 0) {
        echo 'No halls for this venue are available at the moment.';
    }
    ?>
</div>
<?php /** @var \RedDevil\ViewModels\VenueDetailsViewModel $model */?>
<div class="col-md-9">
<div class="jumbotron">
    <h1>
        <?php
        echo $model->getName();
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
        \RedDevil\ViewHelpers\ActionLink::create()
            ->setAttribute('href', '/users/' . $model->getOwnerUsername())
            ->setData($model->getOwnerUsername())
            ->render();
        ?>
    </p>
</div>
<h3>Halls</h3>
<?php foreach ($model->getHalls() as $hall) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php
                echo $hall->getName();
                ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-body">
                    <strong>Capacity: </strong>
                    <?php
                    echo $hall->getCapacity();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
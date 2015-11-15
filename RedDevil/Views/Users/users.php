<?php /** @var \RedDevil\ViewModels\UserInfoModel $model */?>
<div class="col-md-7 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php
                echo $model->getFullname();
                ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-body">
                    <strong>Username: </strong>
                    <?php
                    echo $model->getFullname();
                    ?>
                    <br />
                    <strong>Email:</strong>
                    <?php
                    echo $model->getEmail();
                    ?>
                    <br />
                    <strong>Telephone:</strong>
                    <?php
                    echo $model->getTelephone();
                    ?>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
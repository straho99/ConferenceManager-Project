<div class="col-md-7">
    <form method="POST" action="<?php echo '/venues/' . $model['venueId'] . '/deletehall/' . $model['hallId']; ?>">
        <?php
        \RedDevil\ViewHelpers\CSFRToken::create()->setAttribute('name', 'ValidationToken')->render();
        ?>
        <h4>Are you sure you want to delete the hall?</h4>
        <input type="submit" class="btn btn-danger" value="Delete"/>
        <a href="<?php echo '/venues/details/' . $model['venueId']; ?>" class="btn btn-info">Cancel</a>
    </form>
</div>
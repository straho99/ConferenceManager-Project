<div class="col-md-7">
    <form action="<?php echo '/venues/' . $model . '/delete'; ?>" method="POST">
        <?php
        \RedDevil\ViewHelpers\CSFRToken::create()->setAttribute('name', 'ValidationToken')->render();
        ?>
        <h4>Are you sure you want to delete the venue?</h4>
        <input type="submit" class="btn btn-danger" value="Delete"/>
        <a href="<?php echo '/venues/details/' . $model; ?>" class="btn btn-info">Cancel</a>
    </form>
</div>
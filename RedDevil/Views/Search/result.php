<?php /** @var \RedDevil\ViewModels\SearchResultViewModel $model */ ?>
<div class="col-md-9">
    <h2>Search Results</h2>

    <div class="list-group">
        <a href="#" class="list-group-item active">
            Searching in users, conferences and venues.
            Found 
            <?php
            echo count($model->getResults());
            ?>
            result(s)...
        </a>
        <?php foreach ($model->getResults() as $result): ?>
            <a href="<?php echo $result->getResultUrl(); ?>" class="list-group-item"><?php echo $result->getResultText()?></a>
        <?php endforeach; ?>
        <?php if (count($model->getResults()) == 0): ?>
            <p style="margin-top:1%">
                <strong><em>Nothing found...</em></strong>
            </p>
        <?php endif; ?>
    </div>
</div>

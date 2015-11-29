<?php
namespace RedDevil\Services;

abstract class SearchResult
{
    public abstract function getResultText() : string;

    public abstract function getResultUrl() : string;
}

?>
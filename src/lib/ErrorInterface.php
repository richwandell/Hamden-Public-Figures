<?php

namespace csc545\lib;

interface ErrorInterface
{
    public function getErrorMessage();

    public function setErrorMessage($message);
}
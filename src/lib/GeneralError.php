<?php 
namespace csc545\lib;

class GeneralError implements ErrorInterface
{
    private $errorMessage;

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }
}
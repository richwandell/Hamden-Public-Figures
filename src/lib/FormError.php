<?php
namespace csc545\lib;

class FormError implements ErrorInterface
{
    private $errorMessage;

    private $formField;

    public function __construct($form_field = "")
    {
        $this->formField = $form_field;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getFormField()
    {
        return $this->formField;
    }

    /**
     * @param mixed $formField
     */
    public function setFormField($formField)
    {
        $this->formField = $formField;
    }

}
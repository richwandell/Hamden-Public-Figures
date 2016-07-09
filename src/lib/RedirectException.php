<?php 

namespace csc545\lib;

use Exception;

class RedirectException extends Exception
{
    /**
     * RedirectException constructor.
     * @param string $redirect The path to redirect to
     * @param int $message The error message array to display
     * @param array $form_state The form state array to save
     */
    function __construct($redirect, $errors, $form_state = false)
    {
        parent::__construct("redirect exception", 0, null);
        foreach($errors as $m){
            Flash::addErrorMessage($m->getErrorMessage());
            if($m instanceof FormError){
                Flash::saveFormError($m->getFormField());
            }
        }
        if(is_array($form_state)) {
            Flash::saveFormState($form_state);
        }
        header("Location: " . $redirect);
    }
}
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Throwable;

/**
 * Class GeneralException.
 */
class GeneralException extends Exception
{
    /**
     * @var
     */
    public $message;

    /**
     * GeneralException constructor.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        //
    }


    /**
     * @param $request
     * @return RedirectResponse
     */
    public function render($request)
    {
        // All instances of GeneralException redirect back with a flash message to show a bootstrap alert-error
        return redirect()
            ->back()
            ->withInput()
            ->with('danger',$this->message);
    }
}

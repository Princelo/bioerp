<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/31/17
 * Time: 11:05 PM
 */

include_once('application/services/IService.php');
class InitiationService implements IService
{
    private $processor;

    public function __construct($processor)
    {
        $this->processor = $processor;
    }

    function process($data)
    {
        $user_id = substr($data, 0, strpos($data, '-'));
        return $this->processor->initialize($user_id);
    }
}
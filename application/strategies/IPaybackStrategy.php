<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 3:57 PM
 */

interface IPaybackStrategy
{
    function payback($user_id, $purchase_amount);
}
<?php
/**
 * Created by PhpStorm.
 * User: menakafernando
 * Date: 7/12/18
 * Time: 10:35 AM
 */

include 'template.php';

$Stuff = array(
            array("Thing" => "roses", "Desc"  => "red"),
            array("Thing" => "violets", "Desc" =>  "blue"),
            array("Thing" => "you", "Desc" =>  "able to solve this"),
            array("Thing" => "we", "Desc" =>  "interested in you"),
            );
$Name = 'Menaka';


$template = new Template('template');
$template->assign('Name', $Name);
$template->assign('Stuff', $Stuff);
$template->render();

echo '<br>';

$extra = new Template('extra');
$extra->assign('Name', $Name);
$extra->assign('Stuff', $Stuff);
$extra->render();




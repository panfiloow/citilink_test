<?php
/**
 * Задание 3
 * 
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 * PHP version 8
 * 
 * @category Test_Class3
 * @package  Test_Class3
 * @author   Author Ilya Panfilov <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 * @charset  UTF-8
 */

abstract class Carrier
{
    protected $name;
    
    public function __construct($name) 
    {
        $this->name = $name;
    }
    
    abstract public function calculateShippingCost($weight);
}

class RussianPost extends Carrier
{
    public function calculateShippingCost($weight) {
        if ($weight <= 10) {
            return 100;
        } else {
            return 1000;
        }
    }
}

class DHL extends Carrier
{
    public function calculateShippingCost($weight) {
        return $weight * 100;
    }
}

$russianPost = new RussianPost('Почта России');
$shippingCost = $russianPost->calculateShippingCost(1); // 100

$dhl = new DHL('DHL');
$shippingCost = $dhl->calculateShippingCost(2); // 200
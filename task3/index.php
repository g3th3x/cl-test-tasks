<?php

/**
 * @charset UTF-8
 *
 * Задание 3
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
 */

# Использовать данные:
# любые

abstract class Carrier {
    abstract public function print_company();
    abstract public function delivery_price(int $weight);
}

class CarrierRussianPost extends Carrier {
    public function print_company() {
        return 'Почта России';
    }

    public function delivery_price($weight) {
        if($weight < 10){
            return 100;
        }
        return 1000;
    }
}

class CarrierDHL extends Carrier {
    public function print_company() {
        return 'DHL';
    }

    public function delivery_price($weight) {
        return $weight * 100;
    }
}

// Новый перевозчик
class CarrierSDEK extends Carrier {
    public function print_company() {
        return 'СДЕК';
    }

    public function delivery_price($weight) {
        if($weight < 10){
            return $weight * 9;
        } elseif ($weight < 100) {
            return $weight * 90;
        } else {
            return $weight * 150;
        }
    }
}


// For debugging
for($i=1; $i<=20; $i++){

$carriers = array(); 

    echo("Step {$i}<hr><br>");

    $carriers[] = new CarrierRussianPost();
    $carriers[] = new CarrierDHL();
    $carriers[] = new CarrierSDEK();

    foreach($carriers as $carrier) {
        $weight = mt_rand(1, 150);
        $price = $carrier->delivery_price($weight);
        $company = $carrier->print_company();
        echo ("Cost calculation for {$company}:<br> weight: {$weight}, price: {$price}<br><br>");
    }

}

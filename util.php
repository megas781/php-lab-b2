<?
//Подсчет выражения без скоробк
function calculate($val)
{
//    echo '($val: ' . $val . ')';
    if (!$val) return 'error';
    if (isnum($val)) {
//if (is_numeric($val)){
//        echo 'why not here??';
        return $val;
    };


    //Сложение

    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
            $sum += calculate($args[$i]);
        }
        return $sum;
    }

    //Вычитание
    $args = explode('-', $val);
    if (count($args) > 1) {
        $subtraction = $args[0];

        for ($i = 1; $i < count($args); $i++) {
            $subtraction -= calculate($args[$i]);
        }
        return $subtraction;
    }

    //Умножение
    $args = explode('*', $val);
    if (count($args) > 1) {
        $sup = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = $args[$i];

            $sup *= calculate($arg);
//            if (isnum($arg)) {
//                $sup *= calculate($arg);
//            } else {
//                return 'Неправильная форма числа';
//            }

        }
        return $sup;
    }

    //Деление знаком "/"
    $args = explode('/', $val);
    if (count($args) > 1) {
        $quotient = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];
            $quotient /= calculate($arg);


        }
        return $quotient;
    }
    //Деление знаком ":"
    $args = explode(':', $val);
    if (count($args) > 1) {
        $quotient = $args[0];
        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];
            if (isnum($arg)) {
                $quotient /= calculate($arg);
            } else {
                return 'Неправильная форма числа';
            }

        }
        return $quotient;
    }

    //Если дошли до сюда, то строка неисправна
    return 'error';
}

// Подсчет выражения со скобками на основе готовой функции calculate
function calculateSq()
{

}

function isnum($x): bool
{
    $x = (string)$x;
//    Аргумент должен существовать
    if (!$x) return false;
//  Аргумент не должен начинаться с разделителя или нуля
    if ($x[0] == '.' || $x[0] == '0') return false;
//  Аргумент не должен оканчиваться разделителем
    if ($x[strlen($x) - 1] == '.') return false;
//    Перебираем все символы аргумента
    for ($i = 0, $point_count = false; $i < strlen($x); $i++) {
        $char = $x[$i];
        if (
            $char == '0' ||
            $char == '1' ||
            $char == '2' ||
            $char == '3' ||
            $char == '4' ||
            $char == '5' ||
            $char == '6' ||
            $char == '7' ||
            $char == '8' ||
            $char == '9' ||
            $char == '.'
        ) {
            if ($char == '.') {
                //Если точка встречаласть до этого
                if ($point_count) {
                    //слишком много точке
                    return false;
                } else {
                    $point_count = true;
                }
            }
        } else {
            //посторонний символ
            return false;
        }
    }
//    Все символы удовлетворяют требованиям. Возвращаем true
    return true;
}

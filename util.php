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

    $args = explode('+', $val);

    if (count($args) > 1) {
        $sum = 0;

//        echo 'sum';
//        print_r($args);
        for ($i = 0; $i < count($args); $i++) {

            $arg = calculate($args[$i]);

//            echo 'arg' . $i . ': ' . $arg;

            if (isnum($arg)) {
                $sum += $arg;
            } else {
                echo '($sum:' . calculate($arg) . ')';
                $sum += calculate($arg);
            }
        }
//        echo '(return $sum: ' . $sum . ')';
        return $sum;
    }

//    здесь у нас по идеи простая форма "числа и знак умножения"
    $args = explode('*', $val);
    if (count($args) > 1) {
//        echo'multi';
//        print_r($args);
        $sup = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = $args[$i];
//            echo '(($arg'. $i .') = ' . $arg . ')';
//            echo '('. (isnum($arg) ? 'равен три' : 'не равен, бред') .')';
            if (isnum($arg)) {
                $sup *= $arg;
            } else {
                return 'Неправильная форма числа';
            }

        }
//        echo '(return $sup: ' . $sup . ')';
        return $sup;
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

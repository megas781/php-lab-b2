<?

//Подсчет выражения без скоробк
function calculate($val)
{

//    echo '$val';
//    var_dump($val);

    if (!$val) return 'error 1';
    if (isnum($val)) {
        return (string)$val[0] == '!' ? - (float) substr($val, 1) : (float) $val;
    };

    if (!isInputValid($val)) return 'error 2';

    //СЛОЖЕНИЕ
    $args = explode('+', $val);
    foreach ($args as $arg) {
        if ($arg === '') {
            return 'error 11';
        }
    }
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
//            var_dump($args[$i]);
            $sum += calculate($args[$i]);
        }
        return (float) $sum;
    }


    //ВЫЧИТАНИЕ
    $args = explode('-', $val);
    foreach ($args as $arg) {
        if ($arg === '') {
            return 'error 12';
        }
    }
    if (count($args) > 1) {
//        echo '$args[1]:' . $args[1];
        $subtraction = calculate($args[0]);
        for ($i = 1; $i < count($args); $i++) {


            $subtraction -= calculate($args[$i]);
        }
        return (float) $subtraction;
    }

    //Умножение
    $args = explode('*', $val);
    foreach ($args as $arg) {
        if ($arg === '') {
            return 'error 13';
        }
    }
    if (count($args) > 1) {
        $sup = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = $args[$i];
//            echo "(args[$i]:" . $args[$i] . ')';
            $sup *= calculate($arg);

        }
        return (float) $sup;
    }

    //Деление знаком "/"
    $args = explode('/', $val);
    foreach ($args as $arg) {
        if ($arg === '') {
            return 'error 14';
        }
    }
    if (count($args) > 1) {

        $quotient = calculate($args[0]);
        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];
            $quotient /= calculate($arg);
        }
        return (float) $quotient;
    }

    //Деление знаком ":"
    $args = explode(':', $val);
    foreach ($args as $arg) {
        if ($arg === '') {
            return 'error 15';
        }
    }
    if (count($args) > 1) {
        $quotient = calculate($args[0]);
        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];
            $quotient /= calculate($arg);
        }
        return (float) $quotient;
    }

    //Если дошли до сюда, то строка неисправна
    return 'error 3';
}

// Подсчет выражения со скобками на основе готовой функции calculate
function calculateSq($val)
{
//    echo '$valsq:';
//    var_dump($val);
//    var_dump($val);
    if (!$val) return 'error 1';
    if (!sqValidator($val)) return 'error 4';
    if (!isInputValid($val)) return 'error 5';

    if (isnum($val)) {
//        echo 'fjf';
        return (string)$val[0] == '!' ? - (float) substr($val, 1) : $val;
    };

    //template (-1)
    if ($val[0] == '(' && $val[strlen($val)-1] == ')' && isnum(substr($val, 1))) {
        $numbb = substr($val, 1, strlen($val)-2);
        return $numbb < 0 ? '!' : '' . abs($numbb);
    }

    //
    $start = strpos($val, '(');

    if ($start === false) {
        return calculate($val);
    }

    //Ищем соответствующую закрывающую скобку
    $end = $start + 1; //первое место поиска
    $open = 1;

    //Цикл пока скобка не найдена либо не дошли до конца строки
    while ($open && $end < strlen($val)) {
        if ($val[$end] == '(') {
            $open++;
        } elseif ($val[$end] == ')') {
            $open--;
        }
        $end++;
    }

    //формируем новое выражение путем замены содержимого скобок на вычисленное

    //left side before '('
    $newVal = substr($val, 0, $start);

//    var_dump($val);
    $inBracketsValue = calculateSq(substr($val, $start+1, $end - $start - 2));

//    echo 'asdf):';
//    var_dump($inBracketsValue);

    $newVal .= (/* sign */ $inBracketsValue < 0 ? '!' : '') . abs($inBracketsValue);

    //right side after ')'
    $newVal .= substr($val, $end); //need +1

//    echo '$newval:';
//    var_dump($newVal);

    return calculateSq($newVal);
}

function sqValidator($val) {
    $open=0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $open++;
        } elseif ($val[$i]==')') {
            $open--;
            if ($open < 0) {
                return false;
            }
        }
    }
    if ($open !== 0) {
        return false;
    } else {
        return true;
    }
}

function isnum($x): bool
{
    $x = (string)$x;
//    Аргумент должен существовать
    if (!$x) return false;
//  Аргумент не должен начинаться с разделителя или нуля
    if ($x[0] == '.' || ($x[0] == '0' && $x[1] != '.')) return false;
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
            $char == '.' ||
//            $char == '+' && $i == 0 ||
//            $char == '-' && $i == 0 ||
            $char == '!' && $i == 0
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


function isInputValid($val) {
    if (
        strpos($val, '++') !== false ||
//        strpos($val, '+-') !== false ||
        strpos($val, '+*') !== false ||
        strpos($val, '+/') !== false ||
        strpos($val, '+:') !== false ||

        strpos($val, '--') !== false ||
        strpos($val, '-+') !== false ||
        strpos($val, '-*') !== false ||
        strpos($val, '-/') !== false ||
        strpos($val, '-:') !== false ||

        strpos($val, '**') !== false ||
        strpos($val, '*+') !== false ||
//        strpos($val, '*-') !== false ||
        strpos($val, '*/') !== false ||
        strpos($val, '*:') !== false ||

        strpos($val, '//') !== false ||
        strpos($val, '/+') !== false ||
//        strpos($val, '/-') !== false ||
        strpos($val, '/*') !== false ||
        strpos($val, '/:') !== false ||

        strpos($val, '::') !== false ||
        strpos($val, ':+') !== false ||
//        strpos($val, ':-') !== false ||
        strpos($val, ':*') !== false ||
        strpos($val, ':/') !== false
    ) {
        return false;
    } else {
        return true;
    }
}


//echo '<pre>';


//echo 'result: ' . calculateSq('(!16+1)/!3');

//var_dump(calculateSq('(!2)'));
//var_dump(calculate("5"));

//var_dump(calculateSq('1.4*!10'));
//$qwe = 1;
//$qwe *= 1.4;
//var_dump($qwe);
//var_dump(calculateSq('4+3'));
//var_dump(calculateSq('(1.4*!10):!7'));


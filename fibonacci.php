<?php

/**
 * Вычисляет сумму чисел Фибоначчи расположенных
 * по диагонали от правого верхнего угла квадрата,
 * до нижнего левого ([0][n]) ([n][0]).
 *
 * @param int $n - Ширина стороны квадрата.
 * @return int
 */
function fibonacciDiagonalSum(int $n): int
{
    // Получаем массив-последовательность Фибоначчи
    $square = pow($n, 2);
    $makeFibSet = function ($i, $acc) use (&$square, &$makeFibSet) {
        if ($i === $square) {
            return $acc;
        }
        $acc[] = $acc[$i - 1] + $acc[$i - 2];
        return $makeFibSet($i + 1, $acc);
    };
    $fibSet = $makeFibSet(2, [1, 1]);

    // Строим двумерный массив как в задании
    $fibArray = array_map(null, ...array_chunk($fibSet, $n));

    // Собственно получаем сумму
    $count = $n - 1;
    return array_reduce($fibArray, function ($acc, $item) use (&$count) {
        $acc += $item[$count];
        $count--;
        return $acc;
    }, 0);
}

echo fibonacciDiagonalSum(6);
<?php

namespace App;

class Score
{

    public static function getTotalScore($ingredients, $calorieCheck=null): array
    {
        $assocIngredientArray = [];
        //Converting to assoicative array
        foreach($ingredients as $row) {
            $rowKey = $row['name'];
            unset($row['name']);
            $assocIngredientArray[$rowKey] = $row;
        }
        $ingredients = $assocIngredientArray;

        $maxScore = 0;
        $ingredientsNames = array_keys($ingredients);
        $ingredientCount = count($ingredientsNames);

        for ($i=1; $i<101-$ingredientCount; $i++){
            $capacityTotal = $durabilityTotal = $flavorTotal = $textureTotal = $calorieTotal = 0;
            $tempCount[0] = $tempCountSum = $i;
            for ($j=1; $j < $ingredientCount; $j++) {
                $tempCountSum += $j;
                $tempCount[$j] = 101 - $tempCountSum;
            }

            foreach (array_combine($ingredientsNames, $tempCount) as $k => $v) {
                $capacityTotal   += $v*$ingredients[$k]['capacity'];
                $durabilityTotal += $v*$ingredients[$k]['durability'];
                $flavorTotal     += $v*$ingredients[$k]['flavor'];
                $textureTotal    += $v*$ingredients[$k]['texture'];
                if ($calorieCheck) {
                    $calorieTotal += $v*$ingredients[$k]['calories'];
                }
            }
            if ($capacityTotal <= 0 || $durabilityTotal <= 0 || $flavorTotal <= 0 || $textureTotal <= 0) continue;
            if ($calorieTotal != $calorieCheck) continue;
            $currentScore = $capacityTotal * $durabilityTotal * $flavorTotal * $textureTotal;
            if ($maxScore < $currentScore) {
                $maxScore = $currentScore;
                $finalCount = $tempCount;
            }
        }

        return ['Score' => $maxScore, 'finalCounts' => array_combine($ingredientsNames, $finalCount)];
    }
}

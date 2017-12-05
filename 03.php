<?php

    /**
     * Manhattan (aka "Taxicab") distance metric between two vectors
     *
     * The Manhattan (or Taxicab) distance is defined as the sum of the
     * absolute differences between the vector coordinates, and akin to
     * the type of path that one takes when walking around a city block.
     *
     * This distance is defined as
     * D = SUM( ABS(vector1(i) - vector2(i)) )    (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Manhattan_distance
     * - http://xlinux.nist.gov/dads/HTML/manhattanDistance.html
     * - http://mathworld.wolfram.com/TaxicabMetric.html
     *
     * @param array $vector1 first vector
     * @param array $vector2 second vector
     *
     * @return double The Manhattan distance between vector1 and vector2
     */
    function distance($vector1, $vector2)
    {
        $n = count($vector1);
        $sum = 0;

        for ($i = 0; $i < $n; $i++) {
            $sum += abs($vector1[$i] - $vector2[$i]);
        }

        return $sum;
    }

    // https://stackoverflow.com/a/6633113/622843
    // A few constants.
    define('DOWN', 0);
    define('LEFT', 3);
    define('RIGHT', 1);
    define('UP', 2);

    function getSpiral($size, $inputForTwo) {
        $spiral = [];
        $spiral2 = [];

        // The initial number.
        $number = 1;

        // The initial direction.
        $direction = RIGHT;

        // The distance and number of points remaining before switching direction.
        $remain = $distance = 1;

        // The initial "x" and "y" point.
        $y = $x = round($size / 2);
        $origin = [$x, $y];

        // The dimension of the spiral.
        $dimension = $size * $size;

        $number2 = 1;
        $partTwoDone = false;

        // Loop
        for ( $count = 0; $count < $dimension; $count++ )
        {
          // Add the current number to the "x" and "y" coordinates.
          $spiral[$x][$y] = $number;

          if (!$partTwoDone) {
            $spiral2[$x][$y] = $number2;
          }

          // Depending on the direction, set the "x" or "y" value.
          switch ( $direction )
          {
            case LEFT: $y--; break;
            case UP: $x++; break;
            case DOWN: $x--; break;
            case RIGHT: $y++; break;
          }

          // If the distance remaining is "0", switch direction.
          if ( --$remain == 0 )
          {
            switch ( $direction )
            {
              case DOWN:
                $direction = LEFT;
                $distance++;

                break;
              case UP:
                $distance++;

              default:
                $direction--;

                break;
            }

            // Reset the distance remaining.
            $remain = $distance;
          }

          $number++;

          if (!$partTwoDone) {
            $number2 = getNumber2($spiral2, $x, $y);

            if ($number2 > $inputForTwo) {
              echo 'Result2: '.$number2."\n";

              $partTwoDone = true;
            }
          }
        }

        // Sort by "x" numerically.
        ksort($spiral, SORT_NUMERIC);

        foreach ( $spiral as &$x )
        {
          // Sort by "y" numerically.
          ksort($x, SORT_NUMERIC);

          /*foreach ( $x as $ykey => $y )
            // Output the number.
            echo str_pad($y, 6, ' ', STR_PAD_LEFT) . ' ';

          // Skip a line.
          echo '<br>';*/
        }

        return [
            $spiral,
            $origin,
        ];
    }

    function getNumber2($spiral, $x, $y) {
      $number2 = 0;

      $number2 += !empty($spiral[$x - 1][$y]) ? $spiral[$x - 1][$y] : 0;
      $number2 += !empty($spiral[$x - 1][$y - 1]) ? $spiral[$x - 1][$y - 1] : 0;
      $number2 += !empty($spiral[$x][$y -1]) ? $spiral[$x][$y -1] : 0;
      $number2 += !empty($spiral[$x + 1][$y]) ? $spiral[$x + 1][$y] : 0;
      $number2 += !empty($spiral[$x + 1][$y + 1]) ? $spiral[$x + 1][$y + 1] : 0;
      $number2 += !empty($spiral[$x][$y + 1]) ? $spiral[$x][$y + 1] : 0;
      $number2 += !empty($spiral[$x - 1][$y + 1]) ? $spiral[$x - 1][$y + 1] : 0;
      $number2 += !empty($spiral[$x + 1][$y - 1]) ? $spiral[$x + 1][$y - 1] : 0;

      return $number2;
    }

    /**
     * Renvoie les coordonnées du nombre demandé dans la spirale.
     *
     * @param int $number Nombre recherché
     * @param array $spiral Le spirale de nombres
     *
     * @return array
     */
    function getCoordinates($number, $spiral) {
        foreach ($spiral as $x => $row) {
            foreach ($row as $y => $value) {
                if ($number === $value) {
                    return [$x, $y];
                }
            }
        }

        return null;
    }

    $input = (int) trim(file_get_contents('./inputs/03.txt'));
    $spiralData = getSpiral(550, $input);
    list($spiral, $origin) = $spiralData;

    $coordinates = getCoordinates($input, $spiral);

    echo 'Result: '.distance($origin, $coordinates)."\n";

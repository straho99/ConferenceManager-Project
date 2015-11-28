<?php

namespace RedDevil\Services;


class LongestLecturesSequence {
    const NO_PREVIOUS = -1;

    private static $seq = [];
    private static $len = [];
    private static $prev = [];

    public static function getSequence($sequence)
    {
        self::$seq = $sequence;

        $bestIndex = self::calculateLongestIncreasingSubsequence(self::$seq, self::$len);

        return self::printLongestIncreasingSubsequence(self::$seq, self::$prev, $bestIndex);
    }

	private static function calculateLongestIncreasingSubsequence($seq, $len)
	{
        $bestLen = 0;
		$bestIndex = 0;
		for ($x = 0; $x < count($seq); $x++)
		{
            $len[$x] = 1;
            self::$prev[$x] = self::NO_PREVIOUS;
			for ($i = 0; $i <= $x - 1; $i++)
			{
                if ($seq[$i] < $seq[$x] && 1 + $len[$i] > $len[$x])
				{
                    $len[$x] = 1 + $len[$i];
                    self::$prev[$x] = $i;
					if ($len[$x] > $bestLen)
					{
                        $bestLen = $len[$x];
						$bestIndex = $x;
					}
				}
			}
		}
		return $bestIndex;
	}

	private static function printLongestIncreasingSubsequence($seq, $prev, $index)
	{
        $lis = [];
		while ($index != self::NO_PREVIOUS)
        {
            $lis[] = $seq[$index];
			$index = $prev[$index];
		}

        array_reverse($lis);
        return $lis;
	}
}
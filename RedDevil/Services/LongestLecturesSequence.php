<?php

namespace RedDevil\Services;


use DateTime;
use RedDevil\ViewModels\LectureViewModel;

class LongestLecturesSequence {
    const NO_PREVIOUS = -1;

    private static $seq = [];
    private static $len = [];
    private static $prev = [];

    public static function getSequence($sequence) : array
    {
        self::$seq = $sequence;

        $bestIndex = self::calculateLongestIncreasingSubsequence(self::$seq, self::$len);

        return [self::printLongestIncreasingSubsequence(self::$seq, self::$prev, $bestIndex)];
    }

	private static function calculateLongestIncreasingSubsequence(array $seq, array $len) : int
	{
        $bestLen = 0;
		$bestIndex = 0;
		for ($x = 0; $x < count($seq); $x++)
		{
            $len[$x] = 1;
            self::$prev[$x] = self::NO_PREVIOUS;
			for ($i = 0; $i <= $x - 1; $i++)
			{
                if (self::compareTo($seq[$i], $seq[$x]) < 0 && 1 + $len[$i] > $len[$x])
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

	private static function printLongestIncreasingSubsequence(array $seq, array $prev, integer $index)
	{
        $lis = [];
		while ($index != self::NO_PREVIOUS)
        {
            $lis[] = $seq[$index];
			$index = $prev[$index];
		}

        $lis = array_reverse($lis);
        return $lis;
	}

    public static function compareTo(IDateTimeInterval $first, IDateTimeInterval $second) : bool
    {
        $test = $first->getStartDate();
        $firstStartDate = (new DateTime($first->getStartDate()))->getTimestamp();
        $firstEndDate = (new DateTime($first->getEndDate()))->getTimestamp();

        $secondStartDate = (new DateTime($second->getStartDate()))->getTimestamp();
        $secondEndDate = (new DateTime($second->getEndDate()))->getTimestamp();

        if ($firstEndDate < $secondStartDate) {
            return -1;
        } else if($firstStartDate > $secondEndDate) {
            return 1;
        } else {
            return 0;
        }
    }
}
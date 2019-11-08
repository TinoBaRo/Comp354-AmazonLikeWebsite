<?php  
	error_reporting(0);

	function getRating ($itemid) {
		$rating_sum = 0;
		//compute item's rating in stars
		$reviews = file("database/reviews.txt", FILE_IGNORE_NEW_LINES);
		$num_reviews = count($reviews);
		$reviews_this_item = 0;		
		
		for ($j = 0; $j < $num_reviews; $j++) {
			$datas = explode(":", $reviews[$j]); //split the line by colon		
			list($_, $itemid_FK, $_, $stars, $_) = $datas;

			if ($itemid_FK == $itemid) {
				$reviews_this_item += 1;
				$rating_sum += $stars;
			}
		}
		$rating_stars = $rating_sum / $reviews_this_item;
		$rating_stars = number_format($rating_stars, 1, '.', '');
		return $rating_stars;
	}
?>

<?php

define("ROOT", "http://localhost/sportsgear/");

//define("ROOT", "http://www.example.com/sportsgear/");

define("productRecord", 15);

//have no idea where this function should go
function paginationLinks($pagination)
{
	$num_records = $pagination->total;
	$currentPage = $pagination->currentPage;
	$limit       = $pagination->limit;
	$sportTypeName = $pagination->sport;
	$gearTypeName  = $pagination->gear;

	$pages = ceil($num_records / $limit);

	echo '<ul class="pagination pagination-sm">';

	if($currentPage != 1)
	{
		echo '<li><a href="'.ROOT.'product/'.$sportTypeName.'/'.$gearTypeName.'/'.($currentPage-1).'">&laquo;</a></li>';
	}

	for($i=1; $i<=$pages; $i++)
	{
		if($currentPage == $i)
		{
			echo '<li class="active"><a href="'.ROOT.'product/'.$sportTypeName.'/'.$gearTypeName.'/'.$i.'">';
		}
		else
		{
			echo '<li><a href="'.ROOT.'product/'.$sportTypeName.'/'.$gearTypeName.'/'.$i.'">';
		}

		echo $i.'</a></li>';	
	}

	if($currentPage < $pages)
	{
		echo '<li><a href="'.ROOT.'product/'.$sportTypeName.'/'.$gearTypeName.'/'.($currentPage+1).'">&raquo;</a></li>';
	}


	echo '</ul>';
}
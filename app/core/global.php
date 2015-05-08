<?php

define("ROOT", "http://localhost/sportsgear/");

//define("ROOT", "http://www.example.com/sportsgear/");


//have no idea where this function should go
function paginationLinks($pagination)
{
	$num_records = $pagination->total;
	$currentPage = $pagination->currentPage;
	$limit       = $pagination->limit;
	$controller  = $pagination->controller;
	$function    = $pagination->function;
	$param       = $pagination->param;

	$pages = ceil($num_records / $limit);

	echo '<ul class="pagination pagination-sm">';

	if($currentPage != 1)
	{
		echo '<li><a href="'.ROOT.$controller.'/'.$function.'/'.$param.'/'.($currentPage-1).'">&laquo;</a></li>';
	}

	/*
	*when we have lots of pages, we will have problem to print all links out
	*/
	for($i=1; $i<=$pages; $i++)
	{
		if($currentPage == $i)
		{
			echo '<li class="active"><a href="'.ROOT.$controller.'/'.$function.'/'.$param.'/'.$i.'">';
		}
		else
		{
			echo '<li><a href="'.ROOT.$controller.'/'.$function.'/'.$param.'/'.$i.'">';
		}

		echo $i.'</a></li>';	
	}

	if($currentPage < $pages)
	{
		echo '<li><a href="'.ROOT.$controller.'/'.$function.'/'.$param.'/'.($currentPage+1).'">&raquo;</a></li>';
	}


	echo '</ul>';
}
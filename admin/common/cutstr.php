<?php
	//中文字符串截取（UTF-8标准）
	function cut_str($sourcestr,$cutlength)
	{
	   $returnstr='';
	   $i=0;
	   $n=0;
	   $str_length=strlen($sourcestr);
	   while (($n<$cutlength) and ($i<=$str_length))
	   {
	      $temp_str=substr($sourcestr,$i,1);
	      $ascnum=Ord($temp_str);
	      if ($ascnum>=224)
	      {
			 $returnstr=$returnstr.substr($sourcestr,$i,3);
	         $i=$i+3;
	         $n++;
	      }
	      elseif ($ascnum>=192)
	      {
	         $returnstr=$returnstr.substr($sourcestr,$i,2);
	         $i=$i+2;
	         $n++;
	      }
	      elseif ($ascnum>=65 && $ascnum<=90)
	      {
	         $returnstr=$returnstr.substr($sourcestr,$i,1);
	         $i=$i+1;
	         $n++;
	      }
	      else
	      {
	         $returnstr=$returnstr.substr($sourcestr,$i,1);
	         $i=$i+1;
	         $n=$n+0.5;
	      }
	   	  }
	         if ($str_length>$i){
	          $returnstr = $returnstr . "...";
	   }
	   return $returnstr;
	}
?>
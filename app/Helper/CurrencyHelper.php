<?php 


function getRs($number)
{
    $number = number_format($number,2,'.','');
    list($whole, $decimal) = explode('.', $number);
    return $whole;
}

function getPs($number)
{
    $number = number_format($number,2,'.','');
    list($whole, $decimal) = explode('.', $number);
    return $decimal;
}


function decimal_to_words($x)
{
    $x = str_replace(',','',$x);
    $pos = strpos((string)$x, ".");

    if ($pos !== false) { 
        $decimalpart= getPs($x);
        $x = substr($x,0,$pos); 
    }

    $tmp_str_rtn = number_to_words ($x).' Rupees';

    if(!empty($decimalpart) && $decimalpart > 0){
        $tmp_str_rtn .= ' and '  . number_to_words (ltrim($decimalpart,'0')) . ' paise  '.'Only';
    }else{
        $tmp_str_rtn .= ' Only';
    }
    return   $tmp_str_rtn;
} 

function number_to_words($x)
{

   $nwords = array(  "", "One", "Two", "Three", "Four", "Five", "Six", 
    "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
    "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
    "Nineteen", "Twenty", 30 => "Thirty", 40 => "Fourty",
    50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eigthy",
    90 => "Ninety" );

   if(!is_numeric($x))
   {
       $w = '#';
   }else if(fmod($x, 1) != 0)
   {
       $w = '#';
   }else{
       if($x < 0)
       {
           $w = 'minus ';
           $x = -$x;
       }else{
           $w = '';
       }
       if($x < 21)
       {
           $w .= $nwords[$x];
       }else if($x < 100)
       {
           $w .= $nwords[10 * floor($x/10)];
           $r = fmod($x, 10);
           if($r > 0)
           {
               $w .= ' '. $nwords[$r];
           }
       } else if($x < 1000)
       {

           $w .= $nwords[floor($x/100)] .' hundred';
           $r = fmod($x, 100);
           if($r > 0)
           {
               $w .= ' '. number_to_words($r);
           }
       } else if($x < 100000)
       {
          $w .= number_to_words(floor($x/1000)) .' thousand';
          $r = fmod($x, 1000);
          if($r > 0)
          {
           $w .= ' ';
           if($r < 100)
           {
               $w .= ' ';
           }
           $w .= number_to_words($r);
       }
   } else {
       $w .= number_to_words(floor($x/100000)) .' lacs';
       $r = fmod($x, 100000);
       if($r > 0)
       {
           $w .= ' ';
           if($r < 100)
           {
               $w .= ' ';
           }
           $w .= number_to_words($r);
       }
   }
}
return $w;
}

function moneyFormatIndia($amount) {
    list($num, $decimal) = explode('.', number_format($amount, 2, '.', ''));
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        $thecash = $thecash.'.'.$decimal;
        return $thecash; // writes the final format where $currency is the currency symbol.
    }



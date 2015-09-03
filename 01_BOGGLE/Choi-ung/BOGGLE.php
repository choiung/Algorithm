<?
    $board_size = 5;
    
    $stack = array();
    $here = array(1,0);
    $entry = array(1,0);
    
    $board = array();
    $target = array();
    
    
    $idx_of_target = 0;
    $idx_of_word = 0;
    
    

    function search_loc($x, $y, $alpha)
    { 
    	global $board_size, $board;
    	
    	if($x < 0 || $y < 0 )
    		return -1;
    	
    	if($x > $board_size-1 || $y > $board_size-1 )
    		return -1;	
    	
    	
    	if($board[$x][$y] == $alpha)
    		return 1;
    		
    	else
    		return 0;
    }
    
    $board[0][] = "U";
    $board[0][] = "R";
    $board[0][] = "L";
    $board[0][] = "P";
    $board[0][] = "M";
    
    
    $board[1][] = "X";
    $board[1][] = "P";
    $board[1][] = "R";
    $board[1][] = "E";
    $board[1][] = "T";
    
    $board[2][] = "G";
    $board[2][] = "I";
    $board[2][] = "A";
    $board[2][] = "E";
    $board[2][] = "T";
    
    $board[3][] = "X";
    $board[3][] = "T";
    $board[3][] = "N";
    $board[3][] = "Z";
    $board[3][] = "Y";
    
    $board[4][] = "X";
    $board[4][] = "O";
    $board[4][] = "Q";
    $board[4][] = "R";
    $board[4][] = "S";


    $target[0][] = "P";
    $target[0][] = "R";
    $target[0][] = "E";
    $target[0][] = "T";
    $target[0][] = "T";
    $target[0][] = "Y";
    
    $target[1][] = "G";
    $target[1][] = "I";
    $target[1][] = "R";
    $target[1][] = "L";
    
    $target[2][] = "R";
    $target[2][] = "E";
    $target[2][] = "P";
    $target[2][] = "E";
    $target[2][] = "A";
    $target[2][] = "T";
    
    $target[3][] = "K";
    $target[3][] = "A";
    $target[3][] = "R";
    $target[3][] = "A";
    
    $target[4][] = "P";
    $target[4][] = "A";
    $target[4][] = "N";
    $target[4][] = "D";
    $target[4][] = "O";
    $target[4][] = "R";
    $target[4][] = "A";
    
    $target[5][] = "G";
    $target[5][] = "I";
    $target[5][] = "A";
    $target[5][] = "Z";
    $target[5][] = "A";
    $target[5][] = "P";
    $target[5][] = "X";
    
    
    foreach($target as $word_arr)
    {
    	$try = 0;
	    foreach($board as $x_idx => $arr)
	    {
	    	foreach($arr as $y_idx => $board_alpha)
	    	{
	    		//첫글자를 배열에서 찾는다
	    		if($word_arr[0] == $board_alpha)
	    		{
	    			$try++;
	    			
	    			echo $try."차 시작 ... ".$word_arr[0]." ";
	    			$result = 1;
	    			
    				$tmp = array();
		    		$tmp[0] = $x_idx;
		    		$tmp[1] = $y_idx;
		    		$tmp[2] = 1;
		    		$stack[] = $tmp;
		    		
		    		
	    			for($i = 1 ; $i < count($word_arr) ; $i++)
	    			{
	    				$pivot_x = $stack[count($stack)-1][0];
    					$pivot_y = $stack[count($stack)-1][1];
    					//$dir = $stack[count($stack)-1][2];
    					
	    				// -1 : 범위 초과
	    				// 0 : 못찾음
	    				// 1 : 찾음
	    				//echo "$pivot_x , $pivot_y , $dir \n";
	    				
	    				for($dir ; $dir <= 8 ; $dir++)
	    				{
	    					$x = $pivot_x;
	    					$y = $pivot_y;
	    					switch($dir)
					    	{
                                case 1: $x--; $y--; break;
                                case 2: $x--;		break;
                                case 3: $x--; $y++; break; 
                                case 4: $y--; 		break; 
                                case 5: $y++; 		break; 
                                case 6: $x++; $y--; break; 
                                case 7: $x++; 		break; 
                                case 8: $x++; $y++; break; 
					    	}
					    	
					    	
	    					$search_return = search_loc($x, $y, $word_arr[$i]);	
	    					//echo "pivot_x : ".$pivot_x.", pivot_y : ".$pivot_y."\n";
	    					//echo "A : ".$word_arr[$i].", X : ".$x.",\tY : ".$y.",\tdir : ".$dir." , search_return: ". $search_return." , result : ".$result ."\n\n";
	    					if($search_return == -1)
	    						continue;
	    					else if($search_return == 1)
	    					{
	    						
					    		$tmp = array();
					    		$tmp[0] = $x;
					    		$tmp[1] = $y;
					    		$tmp[2] = $dir;
					    		
					    		$stack[] = $tmp;
					    		
	    						$result++;
	    						
	    						//print_r($stack);
	    						break;
	    					}
	    					else
	    					{
	    						//8방향 못찾음?
	    						if($dir == 8)
	    						{
	    							//$result--;
	    							array_pop($stack); //이전 좌표로 돌아가
	    						}
	    					}
	    				}
	    				
	    				
	    				echo "$word_arr[$i] ";
	    			}
	    			if($result == count($word_arr)-1)
	    				echo "성공 \n";
	    			else 
	    				echo "실패 \n";
	    		}
	    		else
	    			continue;
	    	}
	    }
	  }
	  
    
?>

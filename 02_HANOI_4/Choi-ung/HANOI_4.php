
<?
//HANOI_4.php
//
    define ("_TRUE",1);
	define ("_FALSE",0);
	define ("_NODES",300);
	define ("_INF",9999);
	class HANOI
	{
		public $name;	
		public $num;
	}

	

	function print_distance()
	{
	    global $distance;
		for($i = 0 ; $i < _NODES ; $i++)
		{
            echo $distance[$i];
		}
		echo "<br><br>";
	}
	
	function choose($n)
	{
	    global $distance, $found;
		
		$min = INT_MAX;
		$minpos = -1;
		for($i = 0 ; $i < $n ; $i++)
		{
			if( $distance[$i]< $min && ! $found[$i] )
			{
				$min = $distance[$i];
				$minpos = $i;
			}
		}
		return $minpos;
	}
	
	function shortest_path($start, $n) 
	{  
	    global $distance, $found, $cost, $path;
		
		for($i = 0 ; $i < $n ; $i++)
		{
			$distance[$i] = $cost[$start][$i];
			$path[$i] = $start;
			$found[$i] = _FALSE;
		}
		$found[$start] = _TRUE;
		$distance[$start] = 0;
		
		for($i = 0 ; $i < $n ; $i++)
		{
			//print_distance();
			$u = choose($n);
			$found[$u] = _TRUE;			
			for($w = 0 ; $w < $n ; $w++)
			{
				if($found[$w] == _FALSE)
				{
					if( $distance[$u]+$cost[$u][$w] < $distance[$w] )
					{
						$distance[$w] = $distance[$u]+$cost[$u][$w];	
						$path[$w] = $u;
					}
				}
			}
		}
	}
	
	function print_path($start, $end)
	{
	    global $hanoi, $path;
		if( $path[$end] != $start)
			print_path($start, $path[$end]);
		else if($path[$end] > 0 && $end)
		    echo $hanoi[$path[$end]]->name."->".$hanoi[$end]->name ."<br>";
		else 
		    echo "오류";
	}
	
	
    function fole_to_string()
    {
        global $pole, $disk_cnt;
        
        $string = "";
        
        for($i = 1; $i <= $disk_cnt; $i++)
            $string .= find_disk_pos($i)+1;
        
        
        
        return $string;
    }
    function find_disk_pos($disk_num)
    {
        global $pole;
        $disk_pos = -1;
        
        foreach( $pole as $pole_idx => $arr)
            foreach( $arr as $disk)
                if( $disk == $disk_num)
                    return $pole_idx;
    }
    function find_map_pos($string)
    {
        global $mapname;
        
        foreach($mapname as $idx => $name)
            if($string == $name)
                return $idx;
    }
    function find_map_name($idx)
    {
        global $mapname;
        
        return $mapname[$idx];
    }


    

    echo _TRUE."<br>";
    echo _FALSE."<br>";
    echo _NODES."<br>";
    echo _INF."<br>";
    
    $hanoi = array();
	$cost = array();
	$distance = array();
	$path = array();
	$found = array();
	
    $mapname = array();
    $map = array();
    
    
    $pole = array();
    $disk_cnt = 3;
    $pole_cnt = 3;
    $pole_idx = 0;
    
    $start = 1;
    
    for($i = 1; $i < $disk_cnt ; $i++)
    {
        $start = $start * 10;
        $start += 1;        
    }
    
    $end = $start * $pole_cnt;
    
    for($i = $start; $i <= $end ; $i++)
    {
        $_tmp = 1;
        for($j = 1; $j <= $disk_cnt ; $j++)
        {
            if((($i / $_tmp) % 10) > $pole_cnt  ||  (($i / $_tmp) % 10) == 0)
                continue 2;
            $_tmp = $_tmp * 10;
        }
        $mapname[] = $i;        
    }
    
    echo "<pre>";
    print_r($mapname);
    echo "</pre>";
            
    foreach($mapname as $map_idx => $disk_pos)
    {        
        $pole = array();
        for($i = 0; $i < $pole_cnt ; $i++)
            $pole[] = array();
        
        $disk_num = $disk_cnt;
        $_tmp = 1;
        for($i = 1; $i <= $disk_cnt ; $i++)
        {
            $pole_idx = (($disk_pos / $_tmp) % 10);
            
            $pole[$pole_idx-1][] = $disk_num--;
            $_tmp = $_tmp * 10;
        }
        
        for($i = 0; $i < $pole_cnt ; $i++)
        {
            
            //폴에 디스크가 있다면
            if(count($pole[$i]) > 0)
            {

        
                $pop_disk = array_pop($pole[$i]);
                for($j = 0; $j < $pole_cnt ; $j++)
                {
                    if( $i == $j)
                        continue;
                    
                    if( count($pole[$j]) == 0  || $pole[$j][count($pole[$j])-1] > $pop_disk)
                    {
                        $pole[$j][] = $pop_disk;
                        $map[$map_idx][find_map_pos(fole_to_string())] = 1;
                        array_pop($pole[$j]);
                    }
                }
                $pole[$i][] = $pop_disk;
            }
            
        }
    }
    
//    echo "<pre>". $map_idx ." : ";
//    print_r($map);
//    echo "</pre>";


    for($i = 0 ; $i < count($map) ; $i++)
        $hanoi[$i] =  new HANOI();
        
	for($i = 0; $i < count($map); $i++)
	{
		$hanoi[$i]->name = NULL;
		$hanoi[$i]->num  = 0;

		for($j = 0; $j < count($mapname); $j++)
		{
			$cost[$i][$j] = _INF;
		}
	}
	
	
	for($i = 0; $i < count($map) ; $i++)
    {
        foreach($map[$i] as $pos => $val)
        {
            $hanoi[$pos]->num = $pos;
    		$hanoi[$pos]->name = find_map_name($i);
    		    		
    		$cost[$i][$pos] = 1;
    		$cost[$pos][$i] = 1;
		
        }
    }
//    echo "<pre>";
//    print_r($map);
//    echo "</pre>";
//$distance, $found, $cost, $path
    
    
    
	shortest_path(1,  26);    
	
    //echo "<pre>";
    //print_r($path);
    //echo "</pre>";
    
    
	//echo $hanoi[$path[$end]]->name."->".$hanoi[14]->name ."<br>";
	print_path(1,14);
?>

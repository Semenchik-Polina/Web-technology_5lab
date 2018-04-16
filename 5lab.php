<html>
    
<head>
<title>Lab5_11</title>
</head>
    
<body>
    
<?php
    
    function get_year_inf($year)
    {
        $link_animal = new mysqli('localhost', 'Polina', '','oriental_calendar');
        
        if ($link_animal->connect_errno) 
        {
            printf("Соединение не удалось: %s\n", $link_animal->connect_error);
            exit();
        }    
        
        if ((($year % 2) == 1)||(($year % 2) == -1)) 
        {
            $remainder_col = (($year-1)/2) % 5;
        }
        else
        {
            $remainder_col = ($year/2) % 5;
        }
        $remainder_animal = $year % 12;
        
        if ($remainder_col<0) {$remainder_col += 5;}
        if ($remainder_animal<0) {$remainder_animal += 12;}
        
        $result =  $link_animal->query("SELECT `color`, `element` FROM `year_color` WHERE `remainder`=$remainder_col");
        
        if ($result!==FALSE)
        {
            if ($row=$result->fetch_assoc())
            {
                $color = $row["color"];
                $element = $row["element"];
            }
            $result->free();
        }
        
        $result =  $link_animal->query("SELECT `animal` FROM `year_animal` WHERE `remainder`=$remainder_animal");
        
        if ($result!==FALSE)
        {
            if ($row=$result->fetch_assoc())
            {
                $animal = $row["animal"];
            }
            $result->free();
        }
        
        return $year.' - '.$element.', '.$color.' '.$animal."<br>";
        $link_animal -> close();
    }
        
    if (!(isset($_GET['year'])))
    {
        echo 'Поле не заполнено';
    }
    else
    {
        $year = $_GET['year'];
        if(!preg_match("/^[-]?\d+$/",$year))
        {
            echo 'The format of year is incorrect.';
        }
        else
        {
            for ($i=0; $i<5; $i++)
            {
                echo  get_year_inf($year);
                $year++;
            }
        }
    }
    ?>
</body>
</html>
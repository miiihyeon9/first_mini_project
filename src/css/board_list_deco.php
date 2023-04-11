

<?php 
    
        $max_ten_min_page_number = $max_page_number - 10 ; 
        if($page_num < $max_ten_min_page_number)
        {
            $ten_next_page = $page_num + 10;
                
        }else
        {
            $ten_next_page = $max_page_number;
    ?>
    
            <div class="page_list" ><a href='board_list.php?page_num=<?php echo $ten_next_page ?>'> >> </a></div>
    <?php
        }
    ?> 





    <?php 

        if($page_num > 11)
        {
        $ten_prev_page = $page_num - 10;
        }else
        {
            $ten_pre_page = 1;
    ?>


            <div class="page_list" ><a href='board_list.php?page_num=<?php echo $ten_prev_page ?>'> << </a></div>
    <?php
        }
    ?>
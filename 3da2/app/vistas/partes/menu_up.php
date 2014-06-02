<ul class='menu_up'>
    <?php
        $menu = \modelos\Menus::get_menuUp();
        foreach ($menu as $key => $item) {
            if(!is_array($item)){
                $item = explode(",", $item);
                $href = \core\URL::generar("$item[0]/$item[1]");
                $title = ucfirst( iText($item[2], 'dicc') );
                $texto = ucfirst(\core\Idioma::text($key, 'dicc'));
                echo"
                    <li class='item' title='$title'>
                        <a href='$href'>$texto</a>
                    </li>
                    ";
            }else{
    ?>
                <li class='item has-sub'> <a><?php echo ucfirst(\core\Idioma::text($key, 'dicc')) ?></a>
                    <ul>
                        <?php
                        foreach ($item as $key => $subitem) {
                            $subitem = explode (",", $subitem);
                            $href = \core\URL::generar("$subitem[0]/$subitem[1]");
                            $title = ucfirst( iText($item[2], 'dicc') );
                            $texto = ucfirst(\core\Idioma::text($key, 'dicc'));
                            echo "
                                <li class='subitem' title='$title'>
                                    <a href='$href'>$texto</a>
                                </li>
                                ";
                        }

                        ?>                                
                    </ul>                            
                </li>
<?php 
                }
            }
?>
</ul>

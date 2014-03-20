<ul class='menu_left'>
    <?php
        $menu = \modelos\Menus::get_menuLeft();
        foreach ($menu as $key => $item) {
            if(!is_array($item)){
                $item = explode(",", $item);
                $href = \core\URL::generar("$item[0]/$item[1]");
                $title = $item[2];
                $texto = \core\Idioma::text($key, 'dicc');
                echo"
                    <li class='item' title='$title'>
                        <a href='$href'>$texto</a>
                    </li>
                    ";
            }else{
    ?>
                <li class='item has-sub'><a><?php echo \core\Idioma::text($key, 'dicc') ?></a>
                    <ul>
                        <?php
                        foreach ($item as $key => $subitem) {
                            $subitem = explode (",", $subitem);
                            $href = \core\URL::generar("$subitem[0]/$subitem[1]");
                            $title = $subitem[2];
                            $texto = \core\Idioma::text($key, 'dicc');
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

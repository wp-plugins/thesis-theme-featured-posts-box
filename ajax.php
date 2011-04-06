<?php
    
$file1 = '../../../wp-config.php';
$file2 = '../../../wp-load.php';
$file3 = '../../../wp-includes/wp-db.php';

if(file_exists($file1))include_once('../../../wp-config.php');
if(file_exists($file2))include_once('../../../wp-load.php');
if(file_exists($file3))include_once('../../../wp-includes/wp-db.php');

global $plugin_url; 
$plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));    
    
$path = ABSPATH . "wp-content/plugins/roarender-featuredbox/";    
$path = str_replace("/", "\\", $path);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

   
    <script type='text/javascript' src="<?php echo $plugin_url; ?>js/jquery.js"> </script>

    <script type='text/javascript'>

    </script>
    
<title>Roarender Featured Posts Box</title>

</head>

<body>

</body>
</html>

<?php

    
if(isset($_POST['Submit']))
{
    $current_image=$_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    
    
    ?>
    
    <?php 
    
    if($file_size < 200000)
    {
        $extension = substr(strrchr($current_image, '.'), 1);
        if (($extension!= "jpg") && ($extension != "jpeg")) 
        {
        die('Unknown extension');
        }
        $time = date("fYhis");
        $new_image = "blank.jpg";
        $destination = $path . "img/".$new_image;
        $action = copy($_FILES['image']['tmp_name'], $destination);

        if (!$action) 
        {
            die('<script type="text/javascript">jQuery(function($){ window.location = "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=rr-featured-box" }); </script>');
        }

        else
        {
            echo '<script type="text/javascript">jQuery(function($){ window.location = "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=rr-featured-box" }); </script>';
        }
    }
    
    else
    {
        echo '<script type="text/javascript">jQuery(function($){ window.location = "' . get_bloginfo('url') . '/wp-admin/options-general.php?page=rr-featured-box" }); </script>';
    }

}


    
?>
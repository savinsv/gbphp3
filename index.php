<?php
    //var_dump($_GET);
    //echo $_GET['file'] . "<br>";

    $rootDir = $_SERVER['DOCUMENT_ROOT'];

    require_once $rootDir ."/lib/lib.php";

    require_once $rootDir."/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();


    try {
        // указывае где хранятся шаблоны
        $loader = new Twig_Loader_Filesystem("{$rootDir}/lib/templates");
        
        // инициализируем Twig
        $twig = new Twig_Environment($loader);
        
        $files = get_files($rootDir ."/img",$exts);
        if ($_GET['file']){
//          echo $_GET['file'];
          $file = $_GET['file'];
          $contentTmpl = $twig->loadTemplate('image.tmpl');
          $content = $contentTmpl->render(array(
            'file'=> $file,
            'images' => $images,
          ));
        } else {
          $contentTmpl = $twig->loadTemplate('catalog.tmpl');
          $content = $contentTmpl->render(array(
            'header' => 'Все картинки...',
            'files'=> $files,
            'images' => $images,
          ));
        }

        // подгружаем шаблон
        $template = $twig->loadTemplate('main.tmpl');
         
        // передаём в шаблон переменные и значения
        // выводим сформированное содержание
        
        $mainTmlp = $template->render(array(
          'rootDir' => $rootDir,
          'style' => $style,
          'title' => 'Каталог',
          'content' => $content,
          'files' => $files,
        ));

        echo $mainTmlp;
        
      } catch (Exception $e) {
        die ('ERROR: ' . $e->getMessage());
      }
      

?>

<?php

    $rootDir = $_SERVER['DOCUMENT_ROOT'];

    require_once $rootDir ."/lib/lib.php";
//    var_dump(connectDb('localhost','gbphp3','worker','getData'));

    require_once $rootDir."/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();


    try {
        // указывае где хранятся шаблоны
        $loader = new Twig_Loader_Filesystem("{$rootDir}/lib/templates");
        
        // инициализируем Twig
        $twig = new Twig_Environment($loader);
        // С PDO даннае о картинках и где они лежат выбираются из BD таблицы images
        // структура id, file, path, ext
/*         $db = connectDb('localhost','gbphp3','worker','getData');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql ="SELECT * FROM images";
        $sth = $db->query($sql);
        while ($row = $sth->fetchObject()) {
        //  $data[] = $row;
        // Добавляем в массив склеенное имя файла картинки из двух элементов file + ext
        $files[] = $row->file . '.' . $row->ext;
        }
        unset($db);
 */
        //Без PDO поиск картинок в каталоге
        $files = get_files($rootDir ."/img",$exts);

        if ($_GET['file'] && $_GET['key'] && in_array($_GET['file'],$files) && ($files[(int)$_GET['key']-1] == $_GET['file']) ){
          $file = $_GET['file'];
          $key = $_GET['key'];
          $contentTmpl = $twig->loadTemplate('image.tmpl');
          $content = $contentTmpl->render(array(
            'file'=> $file,
            'images' => $images,
            'key' => $key,
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

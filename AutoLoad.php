<?php
/**
 * Plugin Name: AutoLoad
 * Wtyczka ma za zadanie całkowicie zaatomatyzować backendową stronę witryny opartej na wordpress.
 * Po przyciśnięciu jednogo przycisku strona ma się dynamicznie aktualizować. Mają pobierać się dane za pliku xml
 * następnie mają się przetwarzać i tworzyc gotowe widoki z podstronami oparte na shortcodach.
 * Całość niestety bez zachowania zasady DRY, ale to dlatego że jest to prototyp do testu. Był też delikatny problem z obiektowością.
 * Ale bez problemu można zaimplementować OOP
 */

add_action('admin_menu', 'test_plugin_setup_menu');
add_shortcode("rejestratoryIP", "rejestratoryIP_init");
add_shortcode("rejestratoryAnalogowe", "rejestratoryAnalogowe_init");
add_shortcode("kameryIP", "kameryIP_init");
add_shortcode("kameryAnalogowe", "kameryAnalogowe_init");

function rejestratoryIP_init($atts){
  include 'rejestratoryIP.txt';
}
function rejestratoryAnalogowe_init($atts){
  include 'rejestratoryAnalogowe.txt';
}
function kameryIP_init($atts){
  include 'kameryIP.txt';
}
function kameryAnalogowe_init($atts){
  include 'kameryAnalogowe.txt';
}

function test_plugin_setup_menu(){
    add_menu_page( 'Test Plugin Page', 'Autoload', 'manage_options', 'test-plugin', 'test_init' );
}
function test_init(){
  echo "<h1>Witaj,</h1>";
  echo "<h4>To wtyczka do automatyzacji wpisów i renderowania widoków wordpress.</br>
  Kliknij przycisk aby zaaktualizować wpisy.
  </br></h3>";
  ?>
  <script>
          console.log('Test wtyczki!');
      </script>
      <form action="admin.php?page=test-plugin" method="post">
          <input type="submit" name="akcja" value="Zaaktualizuj produkty" />
      </form>
</br>
  <?php
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['akcja']))
  {
    aktualizuj();
  }
}
/*

            ---To gotowa funkcja wtyczki---  

*/
function aktualizuj()
{
  if ( ! is_admin() ) {
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
  }
  $html = file_get_contents('TUTAJ LINK');
  $movies = new SimpleXMLElement($html);
  $i = 0;
  $rejIP = [];
  $rejAnalogowe = [];
  $kamIP = [];
  $kamAnalogowe = [];
  echo "<div class='wynik'>";
  foreach ($movies->xpath('//item') as $item) {
    $i++;
    if ($item->brand == "KENIK") {
      switch ($item->category) {
        case 'Monitoring/Monitoring IP/Rejestratory IP':
          $id = strval( $item->id);
          $model = strval($item->model);
          $url = strval($item->images->img);

          $nowa_tablica = array(
            $id,
            $model,
            $url
          );
          array_push($rejIP, $nowa_tablica);
          $post_dynamiczny = array(   
            'post_title'   => $item->model,
            'post_content' => "[wp-file-get-contents url='Tutaj jakiś get do generowania treści podstrony konkretnego produktu{$item->id}?nopage']",
            'post_type'    => 'post',
            'post_status' => 'publish'
            
          );
          if(post_exists($model)==NULL){
            echo "Wpis o nr.kat:{$id} został dodany"."</br>";
            wp_insert_post($post_dynamiczny, $wp_error = false, $fire_after_hooks = true);
          }
          else{
            echo "Wpis o nr.kat:{$id} został zaaktualizowany"."</br>";
          }
        case 'Monitoring/Monitoring analogowy/Rejestratory analogowe':
          
          $id = strval( $item->id);
          $model = strval($item->model);
          $url = strval($item->images->img);

          $nowa_tablica = array(
            $id,
            $model,
            $url
          );
          array_push($rejAnalogowe, $nowa_tablica);
          $post_dynamiczny = array(   
            'post_title'   => $item->model,
            'post_content' => "[wp-file-get-contents url='Tutaj jakiś get do generowania treści podstrony konkretnego produktu{$item->id}?nopage']",
            'post_type'    => 'post',
            'post_status' => 'publish'
            
          );
          if(post_exists($model)==NULL){
            echo "Wpis o nr.kat:{$id} został dodany"."</br>";
            wp_insert_post($post_dynamiczny, $wp_error = false, $fire_after_hooks = true);
          }
          else{
            echo "Wpis o nr.kat:{$id} został zaaktualizowany"."</br>";
          }
          break;
          
        case 'Monitoring/Monitoring IP/Kamery IP':
          $id = strval( $item->id);
          $model = strval($item->model);
          $url = strval($item->images->img);

          $nowa_tablica = array(
            $id,
            $model,
            $url
          );
          array_push($kamIP, $nowa_tablica);
          $post_dynamiczny = array(   
            'post_title'   => $item->model,
            'post_content' => "[wp-file-get-contents url='Tutaj jakiś get do generowania treści podstrony konkretnego produktu{$item->id}?nopage']",
            'post_type'    => 'post',
            'post_status' => 'publish'
            
          );
          if(post_exists($model)==NULL){
            echo "Wpis o nr.kat:{$id} został dodany"."</br>";
            wp_insert_post($post_dynamiczny, $wp_error = false, $fire_after_hooks = true);
          }
          else{
            echo "Wpis o nr.kat:{$id} został zaaktualizowany"."</br>";
          }
          break;
        case 'Monitoring/Monitoring analogowy/Kamery analogowe, przemysłowe':
          $id = strval( $item->id);
          $model = strval($item->model);
          $url = strval($item->images->img);

          $nowa_tablica = array(
            $id,
            $model,
            $url
          );
          array_push($kamAnalogowe, $nowa_tablica);
          $post_dynamiczny = array(   
            'post_title'   => $item->model,
            'post_content' => "[wp-file-get-contents url='Tutaj jakiś get do generowania treści podstrony konkretnego produktu{$item->id}?nopage']",
            'post_type'    => 'post',
            'post_status' => 'publish'
            
          );
          if(post_exists($model)==NULL){
            echo "Wpis o nr.kat:{$id} został dodany"."</br>";
            wp_insert_post($post_dynamiczny, $wp_error = false, $fire_after_hooks = true);
          }
          else{
            echo "Wpis o nr.kat:{$id} został zaaktualizowany"."</br>";
          }
          break;
      }
    }
  }

  //Tutaj bezsensowne include w następnych wesjach użyto get file content
echo "<div class='niepokazuj' style='display:none;'>";
  include 'C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\kameryIP.txt';
  include 'C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\kameryAnalogowe.txt';
  include 'C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\rejestratoryIP.txt';
  include 'C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\rejestratoryAnalogowe.txt';
echo "/div";


  //w razie potrzeby do odnośników tu jest sformatowana data
  $date = getdate();
  $data_formatted = $date['year']."/".$date['mon']."/".$date['mday'];

  $liczba_rejIP = max(array_keys($rejIP));
  $fp1_2 = fopen('C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\rejestratoryIP.txt', "w");
  for($i=0; $i<=$liczba_rejIP; $i++){
    $url = $rejIP[$i][2];
    $model_toFormat = $rejIP[$i][1];
    $model_formatted = str_replace(" ","-",$model_toFormat);
    $html_code = 
    "<a style='color: #000' href='{$model_formatted}'> <!-- W tym miejscu umieszczamy link do konkretnego produktu-->
      <div class='col-md-3' style='padding: 3%; text-align: center;'>
        <img style='height: 90;width: 300px; margin: 0 auto' src='{$url}'>

        <b>{$model_toFormat}</b> <!-- To co jest w tym miejscu znajduję się pod zdjęciem (nazwa produktu) Musisz pamiętać, żeby wszystko robić w jednym ustalonym formacie. BR odpowiada za oddzielenie tekstu -->

        <a style='margin-top: 20px' class='read-more btn t4p-button-default' href='{$model_formatted}'>Sprawdź</a> <!-- W tym miejscu również umieszczamy link do konkretnego produktu-->
      </div>
      </a>";
    fputs($fp1_2,$html_code);
  }
  fclose($fp1_2);


  $liczba_rejAnalogowych = max(array_keys($rejAnalogowe));
  $fp2_2 = fopen('C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\rejestratoryAnalogowe.txt', "w");
  for($i=0; $i<=$liczba_rejAnalogowych; $i++){
    $url = $rejAnalogowe[$i][2];
    $model_toFormat = $rejAnalogowe[$i][1];
    $model_formatted = str_replace(" ","-",$model_toFormat);
    $html_code = 
    "<a style='color: #000' href='{$model_formatted}'> <!-- W tym miejscu umieszczamy link do konkretnego produktu-->
      <div class='col-md-3' style='padding: 3%; text-align: center;'>
        <img style='height: 90;width: 300px; margin: 0 auto' src='{$url}'> 

        <b>{$model_toFormat}</b> <!-- To co jest w tym miejscu znajduję się pod zdjęciem (nazwa produktu) Musisz pamiętać, żeby wszystko robić w jednym ustalonym formacie. BR odpowiada za oddzielenie tekstu -->

        <a style='margin-top: 20px' class='read-more btn t4p-button-default' href='{$model_formatted}'>Sprawdź</a> <!-- W tym miejscu również umieszczamy link do konkretnego produktu-->
      </div>
      </a>";
    fputs($fp2_2,$html_code);
  }
  fclose($fp2_2);


  $liczba_kamIP = max(array_keys($kamIP));
  $fp2_3 = fopen('C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\kameryIP.txt', "w");
  for($i=0; $i<=$liczba_kamIP; $i++){
    $url = $kamIP[$i][2];
    $model_toFormat = $kamIP[$i][1];
    $model_formatted = str_replace(" ","-",$model_toFormat);
    $html_code = 
    "<a style='color: #000' href='{$model_formatted}'> <!-- W tym miejscu umieszczamy link do konkretnego produktu-->
      <div class='col-md-3' style='padding: 3%; text-align: center;'>
        <img style='height: 90;width: 300px; margin: 0 auto' src='{$url}'>

        <b>{$model_toFormat}</b> <!-- To co jest w tym miejscu znajduję się pod zdjęciem (nazwa produktu) Musisz pamiętać, żeby wszystko robić w jednym ustalonym formacie. BR odpowiada za oddzielenie tekstu -->

        <a style='margin-top: 20px' class='read-more btn t4p-button-default' href='{$model_formatted}'>Sprawdź</a> <!-- W tym miejscu również umieszczamy link do konkretnego produktu-->
      </div>
      </a>";
    fputs($fp2_3,$html_code);
  }
  fclose($fp2_3);


  $liczba_kamAnalogowych = max(array_keys($kamAnalogowe));
  $fp2_4 = fopen('C:\xampp\htdocs\wordpress\wp-content\plugins\AutoLoad\kameryAnalogowe.txt', "w");
  for($i=0; $i<=$liczba_kamAnalogowych; $i++){
    $model_toFormat = $kamAnalogowe[$i][1];
    $model_formatted = str_replace(" ","-",$model_toFormat);
    $url = $kamAnalogowe[$i][2];
    $html_code = 
    "<a style='color: #000' href='{$model_formatted}''> <!-- W tym miejscu umieszczamy link do konkretnego produktu-->
      <div class='col-md-3' style='padding: 3%; text-align: center;'>
        <img style='height: 90;width: 300px; margin: 0 auto' src='{$url}'> 

        <b>{$model_toFormat}</b> <!-- To co jest w tym miejscu znajduję się pod zdjęciem (nazwa produktu) Musisz pamiętać, żeby wszystko robić w jednym ustalonym formacie. BR odpowiada za oddzielenie tekstu -->

        <a style='margin-top: 20px' class='read-more btn t4p-button-default' href='{$model_formatted}'>Sprawdź</a> <!-- W tym miejscu również umieszczamy link do konkretnego produktu-->
      </div>
      </a>";
    fputs($fp2_4,$html_code);
  }
  fclose($fp2_4);

}

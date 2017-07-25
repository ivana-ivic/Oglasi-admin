<?php

namespace Oglasi\Http\Controllers;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\View;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxFile;
use Illuminate\Support\HtmlString;
use Carbon\Carbon;

class AdController extends Controller
{
  public function __construct() {

  }

  public function getAd($id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    if($doc->status=="404" || $doc->body['deleted']==true){
      return redirect()->route('404');
    }

    $ad=$doc->body;

    $app = new DropboxApp("hb7xg2t7t3d5nej", "iiv9qmh9ewf3i51", 'J5GXG54mmpAAAAAAAAAAbwFrTE0rf53O4PdtlAE_9Qxjg4-Gs9jmz_qP164KF47o');
    $dropbox = new Dropbox($app);

    for($i=0;$i<count($ad['images']);$i++){
      $folderAndFileName=explode("/",$ad['images'][$i]);
      $filePath=public_path()."\\img\\ads\\".$folderAndFileName[0]."\\".$folderAndFileName[1];
      if(!file_exists(dirname($filePath))){
        mkdir(dirname($filePath), 0777, true);
      }
      $file = $dropbox->download("/Oglasi/".$ad['images'][$i]);
      $contents = $file->getContents();
      file_put_contents($filePath, $contents);
      $fullPath=asset('img/ads/'.$ad['images'][$i]);
      $adImages[]=$fullPath;
    }

    $images="";
    if(count($ad['images'])==0){
      $path=asset('img/no-image-available.jpg');
      $images.="<div class=\"item active\" style=\"background-image:url($path); background-size:cover;background-position:center center;height:500px;\">
                    <a href=\"$path\"><img src=\"$path\" style=\"width:100%;height:500px;visibility:hidden;\" /></a>
                  </div>";
    }
    else{
      $path=$adImages[0];
      $images.="<div class=\"item active\" style=\"background-image:url($path); background-size:cover;background-position:center center;height:500px;\">
                    <a href=\"$path\"><img src=\"$path\" style=\"width:100%;height:500px;visibility:hidden;\" /></a>
                  </div>";
      if(count($ad['images'])>=2){
        for($i=1;$i<count($ad['images']);$i++){
          $path=$adImages[$i];
          $images.="<div class=\"item\" style=\"background-image:url($path);background-size:cover;background-position:center center;height:500px;\">
                        <a href=\"$path\"><img src=\"$path\" style=\"width:100%;height:500px;visibility:hidden;\" /></a>
                      </div>";
        }
      }
    }

    $data=array('ad' => $ad, 'images' => $images);


    return View::make('ad')->with($data);
  }

  public function newAd(){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);

    $title=$_POST['title'];
    $text=$_POST['text'];
    $user_id=$_POST['user_id'];
    $cat1=$_POST['cat1'];
    $cat2=$_POST['cat2'];
    $created_at=Carbon::now()->timestamp;
    $updated_at=Carbon::now()->timestamp;
    $filters=array();
    if($cat1!=null){
      $filters[]=$cat1;
    }
    if($cat2!=null){
      $filters[]=$cat2;
    }
    $comments=array();
    $report_flag=false;
    $report_count=0;
    $images=array();
    $deleted=false;

    $id=null;
    $rev=null;
    list($id, $rev) = $client->postDocument(array('deleted' => $deleted, 'title' => $title, 'created_at' => $created_at, 'updated_at' => $updated_at, 'text' => $text, 'filters' => $filters, 'cat1' => $cat1, 'cat2' => $cat2, 'report_flag' => $report_flag, 'report_count' => $report_count, 'images' => $images, 'comments' => $comments, 'user_id' => $user_id));

    $new_ad_id=$id;

    $user_doc = $client->findDocument($user_id);

    $user=$user_doc->body;

    $user_ads=$user['ads'];

    $user_ads[]=$new_ad_id;

    $id=$user['_id'];
    $rev=$user['_rev'];
    list($id, $rev) = $client->putDocument(array('email' => $user['email'], 'phone' => $user['phone'], 'description' => $user['description'], 'district' => $user['district'], 'ads' => $user_ads, 'password' => $user['password'], 'city' => $user['city'] ), $id, $rev);

    $ads_counter_doc=$client->findDocument("ads_counter");

    $ads_counter=$ads_counter_doc->body;

    $ids=$ads_counter['ids'];

    $ids[]=$new_ad_id;

    $id=$ads_counter['_id'];
    $rev=$ads_counter['_rev'];
    list($id, $rev) = $client->putDocument(array('ids' => $ids), $id, $rev);

    return redirect()->route('ads');
  }

  public function newAdPrepare(){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument("usernames");

    $usernames=$doc->body;

    $ids=$usernames['ids'];

    return View::make('new_ad')->with('usernames', $ids);
  }

  public function editAdPrepare($edit_id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($edit_id);

    $ad=$doc->body;

    return View::make('edit_ad')->with(array('ad' => $ad));
  }

  public function editAd(){
    $id=$_POST['ad_id'];

    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    $ad=$doc->body;

    $rev=$ad['_rev'];

    $title=$_POST['title'];
    $text=$_POST['text'];
    $user_id=$ad['user_id'];
    $cat1=$_POST['cat1'];
    $cat2=$_POST['cat2'];
    $filters=array();
    if($cat1!=null){
      $filters[]=$cat1;
    }
    if($cat2!=null){
      $filters[]=$cat2;
    }
    $comments=$ad['comments'];
    $report_flag=$ad['report_flag'];
    $report_count=$ad['report_count'];
    $images=$ad['images'];
    $deleted=$ad['deleted'];

    $created_at=$ad['created_at'];
    $updated_at=Carbon::now()->timestamp;

    list($id, $rev) = $client->putDocument(array('deleted' => $deleted, 'title' => $title, 'created_at' => $created_at, 'updated_at' => $updated_at, 'text' => $text, 'filters' => $filters, 'cat1' => $cat1, 'cat2' => $cat2, 'report_flag' => $report_flag, 'report_count' => $report_count, 'images' => $images, 'comments' => $comments, 'user_id' => $user_id), $id, $rev);

    return redirect()->route('ad', ['id' => $id]);
  }

  public function deleteAd($id){
    $this->delete($id);
    return redirect()->route('home');
  }

  public function delete($id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    if($doc->status=="404"){
      return redirect()->route('404');
    }

    $ad=$doc->body;

    // $user_doc=$client->findDocument($ad['user_id']);
    //
    // if($user_doc->status=="404"){
    //   return redirect()->route('404');
    // }
    //
    // $user=$user_doc->body;
    // $user_ads=$user['ads'];
    //
    // $ads=array();
    // $key = array_search($id, $user_ads);
    // unset($user_ads[$key]);
    // for($i=0;$i<=count($user_ads);$i++){
    //   if($i!=$key){
    //     $ads[]=$user_ads[$i];
    //   }
    // }

    $id=$ad['_id'];
    $rev=$ad['_rev'];
    list($id, $rev) = $client->putDocument(array('deleted' => true, 'title' => $ad['title'], 'created_at' => $ad['created_at'], 'updated_at' => $ad['updated_at'], 'text' => $ad['text'], 'filters' => $ad['filters'], 'cat1' => $ad['cat1'], 'cat2' => $ad['cat2'], 'report_flag' => $ad['report_flag'], 'report_count' => $ad['report_count'], 'images' => $ad['images'], 'comments' => $ad['comments'], 'user_id' => $ad['user_id'] ), $id, $rev);

    // $id=$user['_id'];
    // $rev=$user['_rev'];
    //
    // list($id, $rev) = $client->putDocument(array('email' => $user['email'], 'phone' => $user['phone'], 'description' => $user['description'], 'district' => $user['district'], 'ads' => $ads, 'password' => $user['password'], 'city' => $user['city'] ), $id, $rev);

    $app = new DropboxApp("hb7xg2t7t3d5nej", "iiv9qmh9ewf3i51", 'J5GXG54mmpAAAAAAAAAAbwFrTE0rf53O4PdtlAE_9Qxjg4-Gs9jmz_qP164KF47o');
    $dropbox = new Dropbox($app);

    if(count($ad['images'])!=0){
      $deletedFolder = $dropbox->delete("/Oglasi/".$ad['_id']);
      $folderPath=public_path()."\\img\\ads\\".$ad['_id'];
      $this->recursiveRemoveDirectory($folderPath);
    }

    $docDeleted = $client->findDocument("ads_deleted");

    if($docDeleted->status=="404"){
      return redirect()->route('404');
    }

    $adsDeleted=$docDeleted->body;
    $deletedIds=$adsDeleted['ids'];
    $deletedIds[]=$ad['_id'];
    $id=$adsDeleted['_id'];
    $rev=$adsDeleted['_rev'];
    list($id, $rev) = $client->putDocument(array('ids' => $deletedIds), $id, $rev);

  }

  public function recursiveRemoveDirectory($directory)
  {
      foreach(glob("{$directory}/*") as $file)
      {
          if(is_dir($file)) {
              recursiveRemoveDirectory($file);
          } else {
              unlink($file);
          }
      }
      rmdir($directory);
  }

  public function approveAd($delete_id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);

    $doc = $client->findDocument($delete_id);

    if($doc->status=="404"){
      return redirect()->route('404');
    }

    $ad=$doc->body;

    // list($id, $rev) = $client->postDocument(array('foo' => 'bar'));
    $id=null;
    $rev=null;
    $ad_images=array();
    list($id, $rev) = $client->postDocument(array('deleted' => false, 'title' => $ad['title'], 'created_at' => $ad['created_at'], 'updated_at' => $ad['updated_at'], 'text' => $ad['text'], 'filters' => $ad['filters'], 'cat1' => $ad['cat1'], 'cat2' => $ad['cat2'], 'report_flag' => false, 'report_count' => 0, 'images' => $ad_images, 'comments' => $ad['comments'], 'user_id' => $ad['user_id'] ));

    $new_ad_id = $id;

    if(count($ad['images'])!=0){
      for($i=0;$i<count($ad['images']);$i++){
        $folder_and_file_name=explode("/",$ad['images'][$i]);
        $img_url=$new_ad_id."/".$folder_and_file_name[1];
        $ad_images[]=$img_url;
      }
      $new_ad_doc = $client->findDocument($new_ad_id);
      $new_ad=$new_ad_doc->body;
      $id=$new_ad_id;
      $rev=$new_ad['_rev'];
      list($id, $rev) = $client->putDocument(array('deleted' => false, 'title' => $new_ad['title'], 'created_at' => $new_ad['created_at'], 'updated_at' => $new_ad['updated_at'], 'text' => $new_ad['text'], 'filters' => $new_ad['filters'], 'cat1' => $new_ad['cat1'], 'cat2' => $new_ad['cat2'], 'report_flag' => false, 'report_count' => 0, 'images' => $ad_images, 'comments' => $new_ad['comments'], 'user_id' => $new_ad['user_id'] ), $id, $rev);
    }

    $userDoc=$client->findDocument($ad['user_id']);

    if($userDoc->status=="404"){
      return redirect()->route('404');
    }

    $user=$userDoc->body;

    $user_ads=$user['ads'];
    $user_ads[]=$new_ad_id;
    // var_dump($user_ads);
    // die();
    $id=$user['_id'];
    $rev=$user['_rev'];
    list($id, $rev) = $client->putDocument(array('email' => $user['email'], 'phone' => $user['phone'], 'description' => $user['description'], 'district' => $user['district'], 'ads' => $user_ads, 'password' => $user['password'], 'city' => $user['city'] ), $id, $rev);

    $ads_counter_doc=$client->findDocument('ads_counter');
    if($ads_counter_doc->status=="404"){
      return redirect()->route('404');
    }

    $ads_counter=$ads_counter_doc->body;

    $ids_counter=$ads_counter['ids'];
    $ids_counter[]=$new_ad_id;
    $id=$ads_counter['_id'];
    $rev=$ads_counter['_rev'];
    list($id, $rev) = $client->putDocument(array('ids' => $ids_counter), $id, $rev);

    $app = new DropboxApp("hb7xg2t7t3d5nej", "iiv9qmh9ewf3i51", 'J5GXG54mmpAAAAAAAAAAbwFrTE0rf53O4PdtlAE_9Qxjg4-Gs9jmz_qP164KF47o');
    $dropbox = new Dropbox($app);

    if(count($ad['images'])!=0){
      $folder = $dropbox->createFolder("/Oglasi/".$new_ad_id);
      for($i=0;$i<count($ad['images']);$i++){
        $folder_and_file_name=explode("/",$ad['images'][$i]);
        $file_name=$folder_and_file_name[1];
        $file = $dropbox->copy("/Oglasi/".$ad['images'][$i], "/Oglasi/".$new_ad_id."/".$file_name);
      }
    }

    // $id=$delete_id;
    // $rev=$ad['_rev'];
    //
    // list($id, $rev) = $client->postDocument(array('deleted' => false, 'title' => $ad['title'], 'created_at' => $ad['created_at'], 'updated_at' => $ad['updated_at'], 'text' => $ad['text'], 'filters' => $ad['filters'], 'cat1' => $ad['cat1'], 'cat2' => $ad['cat2'], 'report_flag' => false, 'report_count' => 0, 'images' => $ad_images, 'comments' => $ad['comments'], 'user_id' => $ad['user_id'] ));
    $this->delete($delete_id);

    return redirect()->route('home');
  }

}

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

class UserController extends Controller
{
  public function __construct() {

  }
  public function getUser($id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    if($doc->status=="404"){
      return redirect()->route('404');
    }

    $user=$doc->body;

    $user_ads=$user['ads'];

    $existing_ads=array();
    for($i=0;$i<count($user_ads);$i++){
      $ad = $client->findDocument($user_ads[$i]);
      $ad_body=$ad->body;
      if($ad_body['deleted']==false){
        $existing_ads[]=$ad_body['_id'];
      }
    }

    return View::make('user')->with(array('user' => $user, 'user_ads' => $existing_ads));
  }

  public function newUser(){

    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);

    $username=$_POST['username'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $description=$_POST['description'];
    $district=$_POST['district'];
    $ads=array();
    $password=$_POST['password'];
    $city=$_POST['city'];

    $usernames_doc = $client->findDocument("usernames");
    $usernames=$usernames_doc->body;
    $users=$usernames['ids'];

    if (in_array($username, $users)) {
      return redirect()->back()->withInput($request->only('email','phone','city','district','description'));
    }

    $id=null;
    $rev=null;
    list($id, $rev)=$client->postDocument(array('_id' => $username, 'email' => $email, 'phone' => $phone, 'description' => $description, 'district' => $district, 'ads' => $ads, 'password' => $password, 'city' => $city ));


    $users[]=$username;

    $id=$usernames['_id'];
    $rev=$usernames['_rev'];
    list($id, $rev) = $client->putDocument(array('ids' => $users), $id, $rev);

    return redirect()->route('user', ['id' => $username]);
  }

  public function editUserPrepare($user_id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($user_id);

    $user=$doc->body;

    return View::make('edit_user')->with(array('user' => $user));
  }

  public function editUser(){
    $id=$_POST['username'];

    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    $user=$doc->body;

    $rev=$user['_rev'];

    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $district=$_POST['district'];
    $city=$_POST['city'];
    $description=$_POST['description'];
    $password=$_POST['password'];
    $ads=$user['ads'];

    list($id, $rev)=$client->putDocument(array('_id' => $id, 'email' => $email, 'phone' => $phone, 'description' => $description, 'district' => $district, 'ads' => $ads, 'password' => $password, 'city' => $city ), $id, $rev);

    return redirect()->route('user', ['id' => $id]);
  }

  public function deleteUser($user_id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($user_id);

    if($doc->status=="404"){
      return redirect()->route('404');
    }

    $user=$doc->body;

    for($i=0;$i<count($user['ads']);$i++){
      $this->delete($user['ads'][$i]);
    }

    // $usernames_doc = $client->findDocument("usernames");
    //
    // $usernames=$usernames_doc->body;
    //
    // $user_ids=$usernames['ids'];
    //
    // $users=array();
    // $key = array_search($user_id, $user_ids);
    // unset($user_ids[$key]);
    // for($i=0;$i<=count($user_ids);$i++){
    //   if($i!=$key){
    //     $users[]=$user_ids[$i];
    //   }
    // }
    //
    // $id=$usernames['_id'];
    // $rev=$usernames['_rev'];
    // list($id, $rev) = $client->putDocument(array('ids' => $users), $id, $rev);

    $id=$user_id;
    $rev=$user['_rev'];
    // $client->deleteDocument($id, $rev);
    list($id, $rev) = $client->putDocument(array('deleted' => true, 'email' => $user['email'], 'phone' => $user['phone'], 'description' => $user['description'], 'district' => $user['district'], 'ads' => $user['ads'], 'password' => $user['password'], 'city' => $user['city'] ), $id, $rev);

    $users_deleted = $client->findDocument("users_deleted");
    $users_deleted_doc = $users_deleted->body;

    $id=$users_deleted_doc['_id'];
    $rev=$users_deleted_doc['_rev'];

    $usernames_deleted=$users_deleted_doc['usernames'];
    $usernames_deleted[]=$user_id;

    list($id, $rev) = $client->putDocument(array('usernames' => $usernames_deleted), $id, $rev);

    return redirect()->route('users');
  }

  public function delete($id){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $doc = $client->findDocument($id);

    if($doc->status=="404"){
      return redirect()->route('404');
    }

    $ad=$doc->body;

    $id=$ad['_id'];
    $rev=$ad['_rev'];
    list($id, $rev) = $client->putDocument(array('deleted' => true, 'title' => $ad['title'], 'created_at' => $ad['created_at'], 'updated_at' => $ad['updated_at'], 'text' => $ad['text'], 'filters' => $ad['filters'], 'cat1' => $ad['cat1'], 'cat2' => $ad['cat2'], 'report_flag' => $ad['report_flag'], 'report_count' => $ad['report_count'], 'images' => $ad['images'], 'comments' => $ad['comments'], 'user_id' => $ad['user_id'] ), $id, $rev);

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

}

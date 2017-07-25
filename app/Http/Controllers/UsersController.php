<?php

namespace Oglasi\Http\Controllers;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\View;


class UsersController extends Controller
{
  public function __construct() {

  }

  public function getUsers(){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $query = $client->createViewQuery('usersDesign', 'users');
    $query->setDescending(false);
    $query->setReduce(false);
    $query->setIncludeDocs(true);
    $result = $query->execute();

    $users=array();
    foreach ($result as $row) {
        $doc = $row['doc'];
        
        if($doc['deleted']==false){
          $user = array('user_id' => $doc['_id'], 'user_email' => $doc['email']);
          $users[] = $user;
        }
    }

    return View::make('users')->with('users', $users);

  }

}

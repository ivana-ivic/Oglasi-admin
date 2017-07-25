<?php

namespace Oglasi\Http\Controllers;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\View;

class AllAdsDesignDocument implements \Doctrine\CouchDB\View\DesignDocument
{
    public function getData()
    {
        return array(
            'language' => 'javascript',
            'views' => array(
                'all_ads' => array(
                    'map' => 'function(doc) {
                        if(doc.title && doc.text) {
                            emit(doc.created_at, doc._id);
                        }
                    }',
                    'reduce' => '_count'
                ),
            ),
        );
    }
}

class AdsController extends Controller
{
  public function __construct() {

  }

  public function getAds(){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $client->createDesignDocument('allAds', new AllAdsDesignDocument());
    $query = $client->createViewQuery('allAds', 'all_ads');
    $query->setDescending(true);
    $query->setReduce(false);
    $query->setIncludeDocs(true);
    $result = $query->execute();

    $ads=array();
    foreach ($result as $row) {
        $doc = $row['doc'];
        if($doc['deleted']==false){
          $ad = array('ad_id' => $doc['_id'], 'ad_title' => $doc['title']);
          $ads[] = $ad;
        }
    }

    // var_dump($ads);
    // die();
    return View::make('ads')->with('ads', $ads);

  }

}

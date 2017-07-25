<?php

namespace Oglasi\Http\Controllers;

use Illuminate\Http\Request;
use Oglasi\Http\Controllers\Controller;
use Oglasi\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\View;

class ReportedAdsDesignDocument implements \Doctrine\CouchDB\View\DesignDocument
{
    public function getData()
    {
        return array(
            'language' => 'javascript',
            'views' => array(
                'reported_ads' => array(
                    'map' => 'function(doc) {
                        if(doc.report_flag==true) {
                            emit(doc.report_count, doc._id);
                        }
                    }',
                    'reduce' => '_count'
                ),
            ),
        );
    }
}

class HomeController extends Controller
{
  public function __construct() {

  }

  public function getReportedAds(){
    $options=array('dbname' => 'test', 'user' => 'Ivana', 'password' => 'ivanacouchadmin', 'ip' => '127.0.0.1');
    $client = \Doctrine\CouchDB\CouchDBClient::create($options);
    $client->createDesignDocument('reportedAds', new ReportedAdsDesignDocument());
    $query = $client->createViewQuery('reportedAds', 'reported_ads');
    $query->setDescending(true);
    $query->setReduce(false);
    $query->setIncludeDocs(true);
    $result = $query->execute();

    $ads=array();
    foreach ($result as $row) {
        $doc = $row['doc'];
        if($doc['deleted']==false){
          $ad = array('ad_id' => $doc['_id'], 'report_count' => $doc['report_count']);
          $ads[] = $ad;
        }
    }

    return View::make('home')->with('ads', $ads);
    // var_dump($ads);
    // die();
  }

}

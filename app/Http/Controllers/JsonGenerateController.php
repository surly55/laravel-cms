<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetRequest;
use App\Models\Site;
use App\Models\Menu;
use App\Models\Search;
use App\Models\Page;
use App\Models\Widget;
use App\Models\WidgetType;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use MongoDB\BSON\Regex as MongoRegex;

class JsonGenerateController extends Controller
{
  //function index accept parametar siteName ex. page URL-> uniline-test/test-page
  public function index($siteName,$pageLocal,$pageName,$API_key)
  {
	 
	


    //create search keyword based on sitename and pagename
    $searchParametar = $siteName;
    $searchParametar .= "/";
    $searchParametar .= $pageName;

    //parameters for menus
    $jsonMenu = array(); //main array for all menu data
    $jsonMenuTitle = array();
    $jsonMenuItems = array();

    $jsonMenuTop = array();
    $jsonMenuTopItems = array();

    $jsonMenuMain = array();
    $jsonMenuMainItems = array();

    $jsonMenuSide = array();
    $jsonMenuSideItems = array();

    //define all necessary variables
    $jsonSiteId = null;
    $jsonPageTitle = null;
    $jsonPageMetaData = null;
    $jsonPageWidgetData = null;
    $jsonWidgetTitle = array();
    $jsonWidgetType = array();
    $jsonWidgetUpdated = array();
    $jsonWidgetCreated = array();
    $jsonWidgetWeight = array();
    $jsonWidgetId = array();
    $mainWidgetData = array();

    $fullWidgetArray = array();

    $jsonPageHeader = array();

    //JSON METADATA
    $jsonMetaDataTitle = "";
    $jsonMetaDataDescription = "";
    $jsonMetaDataKeywords = "";
    $jsonMetaDataAuthor = "";

    //JSON CURRENICES AND languages
    $jsonCurrencies = array();
    $jsonLanguages = array();

    //JSON PAGE LAYOUT AND theme
    $jsonPageLayout = "";
    $jsonPageTheme = "";
    //JSON PAGE CONTENT SEARCH AND SIDEBAR
    $jsonPageSearchData = "";
    $jsonPageSearch = array();
    $searchItemSearchCollapsed = 0;
    $searchItemSearchLocation = "";
    $searchItemSearchFrom = "";
    $searchItemSearchTo = "";
    $searchItemSearchPerson = 0;

    $jsonPageSideBar = array();

    //perform query to database according to page-name and get all necessary data about it
    $query = Page::where('url',$searchParametar,true)->get();
    foreach($query as $pageData) {
        $jsonSiteId = $pageData ->site_id; //site_id
        $jsonPageTitle = $pageData->title; //page title
        $jsonPageMetaData = $pageData["metadata"]; //page metadata
        $jsonPageMenuData = $pageData["menu"]; //page menu
        $jsonPageSearchData = $pageData["search"]; //search
        $jsonPageTheme = $pageData["page_theme"];
        $jsonPageLayout = $pageData["page_type"];
        $jsonPageWidgetData= $pageData->widgets; //page widgets
    }

    //explode metadata
    foreach($jsonPageMetaData as $_metadata) {
      $tmpMetaDataArray[] = $_metadata;
    }

    for($tmd=0;$tmd<count($tmpMetaDataArray);$tmd++){
        if($tmpMetaDataArray[$tmd]["name"]== "title"){ $jsonMetaDataTitle = $tmpMetaDataArray[$tmd]["value"]; }
        if($tmpMetaDataArray[$tmd]["name"]== "description"){ $jsonMetaDataDescription = $tmpMetaDataArray[$tmd]["value"]; }
        if($tmpMetaDataArray[$tmd]["name"]== "keywords"){ $jsonMetaDataKeywords = $tmpMetaDataArray[$tmd]["value"]; }
        if($tmpMetaDataArray[$tmd]["name"]== "author"){ $jsonMetaDataAuthor = $tmpMetaDataArray[$tmd]["value"]; }
    }

    //explode searches
    foreach($jsonPageSearchData as $_search) {
      $tmpSearchDataArray[] = $_search;
    }

    for($tss=0;$tss<count($tmpSearchDataArray);$tss++){
        $tmpSearchId = $tmpSearchDataArray[$tss]["id"];
        $querySearch = Search::where('_id',$tmpSearchDataArray[$tss]["id"],true)->get();
        foreach($querySearch as $searchData) {
            //SEARCH PARAMETARS
            $searchItemSearchCollapsed = $searchData["searchCollapsed"];
            $searchItemSearchLocation = $searchData["itemSearchLocation"];
            $searchItemSearchFrom = $searchData["itemSearchFrom"];
            $searchItemSearchTo = $searchData["itemSearchTo"];
            $searchItemSearchPerson = $searchData["itemSearchPerson"];
        }

    }



    //prepare page Theme and Layout for accepted json formPageType
    if($jsonPageTheme=="0"){ $jsonPageTheme="default"; }
    else if($jsonPageTheme=="1"){ $jsonPageTheme="green"; }
    else if($jsonPageTheme=="2"){ $jsonPageTheme="red"; }
    else if($jsonPageTheme=="3"){ $jsonPageTheme="blue"; }
    else if($jsonPageTheme=="4"){ $jsonPageTheme="yellow"; }
    else if($jsonPageTheme=="5"){ $jsonPageTheme="purple"; }
    else if($jsonPageTheme=="6"){ $jsonPageTheme="black"; }
    else { $jsonPageTheme="default"; }

    if($jsonPageLayout=="1") { $jsonPageLayout="home-full-width"; }
    else if($jsonPageLayout=="2") { $jsonPageLayout="default-limited-width"; }
    else if($jsonPageLayout=="3") { $jsonPageLayout="sidebar"; }
    else { $jsonPageLayout="home-full-width"; }


    //explode menues
    foreach($jsonPageMenuData as $_menudata) {
      $tmpMenuDataArray[] = $_menudata;
    }

    for($tmm=0;$tmm<count($tmpMenuDataArray);$tmm++){
      //  echo $tmpMenuDataArray[$tmm]["id"];
        $queryMenus = Menu::where('_id',$tmpMenuDataArray[$tmm]["id"],true)->get();
        foreach($queryMenus as $menuData) {

            //MENU MAIN
            if($menuData->type=="menu_main"){
              $jsonMenuMainItems[] = $menuData->items;

              // PREPARE DATA FOR MAIN MENU
              $bigMenuArray = array();
              $arrayForMainMenus = array();
              foreach ($jsonMenuMainItems as  $value) {

                $mainBrojacMenuMainItems = 0;
                foreach ($value as  $v) {

                  if($value[$mainBrojacMenuMainItems]["type"]=="main-menu"){
                    $jsonMenuMain[] = array("title"=>$value[$mainBrojacMenuMainItems]["label"], "path"=>$value[$mainBrojacMenuMainItems]["link"],"items"=>array());
                    $arrayForMainMenus[] = $value[$mainBrojacMenuMainItems]["label"];
                  }

                  if($value[$mainBrojacMenuMainItems]["type"]=="sub-menu"){
                    $bigMenuArray[$value[$mainBrojacMenuMainItems]["parent"]][] = array("title"=>$value[$mainBrojacMenuMainItems]["label"], "path"=>$value[$mainBrojacMenuMainItems]["link"]);
                  }

                  if($value[$mainBrojacMenuMainItems]["type"]=="url"){
                    $jsonMenuMain[] = array("title"=>$value[$mainBrojacMenuMainItems]["label"], "path"=>$value[$mainBrojacMenuMainItems]["link"],"items"=>array());
                    $arrayForMainMenus[] = $value[$mainBrojacMenuMainItems]["label"];
                  }
                  $mainBrojacMenuMainItems++;
                }
              }

              //PREPARE ITEM DATA FOR MAIN MENU
              $mainBrojacMenuMainItems = 0;
                foreach ($jsonMenuMainItems as  $value) {
                    foreach ($value as  $v) {
                        if($value[$mainBrojacMenuMainItems]["type"]=="main-menu"){
                            $key = array_search($value[$mainBrojacMenuMainItems]["label"], $arrayForMainMenus);
                            $jsonMenuMain[$key]["items"] = $bigMenuArray[$value[$mainBrojacMenuMainItems]["label"]];
                        }
                        $mainBrojacMenuMainItems++;
                    }
                }

            }

            //MENU TOP
            if($menuData->type=="menu_top"){
              $jsonMenuTopItems[] = $menuData->items;

              // PREPARE DATA FOR TOP MENU
              $bigHeadMenuArray = array();
              $arrayForHeadMenus = array();
              foreach ($jsonMenuTopItems as  $value) {
                $mainBrojacHeadMainItems = 0;
                foreach ($value as  $v) {

                  if($value[$mainBrojacHeadMainItems]["type"]=="main-menu"){
                    $jsonMenuTop[] = array("title"=>$value[$mainBrojacHeadMainItems]["label"], "path"=>$value[$mainBrojacHeadMainItems]["link"],"items"=>array());
                    $arrayForHeadMenus[] = $value[$mainBrojacHeadMainItems]["label"];
                  }

                  if($value[$mainBrojacHeadMainItems]["type"]=="sub-menu"){
                    $bigHeadMenuArray[$value[$mainBrojacHeadMainItems]["parent"]][] = array("title"=>$value[$mainBrojacHeadMainItems]["label"], "path"=>$value[$mainBrojacHeadMainItems]["link"]);
                  }

                  if($value[$mainBrojacHeadMainItems]["type"]=="url"){
                    $jsonMenuTop[] = array("title"=>$value[$mainBrojacHeadMainItems]["label"], "path"=>$value[$mainBrojacHeadMainItems]["link"],"items"=>array());
                    $arrayForHeadMenus[] = $value[$mainBrojacHeadMainItems]["label"];
                  }
                  $mainBrojacHeadMainItems++;
                }
              }

              //PREPARE ITEM DATA FOR TOP Menu
              $mainBrojacMenuHeadItems = 0;
                foreach ($jsonMenuTopItems as  $value) {
                    foreach ($value as  $v) {
                        if($value[$mainBrojacMenuHeadItems]["type"]=="main-menu"){
                            $key = array_search($value[$mainBrojacMenuHeadItems]["label"], $arrayForHeadMenus);
                            $jsonMenuTop[$key]["items"] = $bigHeadMenuArray[$value[$mainBrojacMenuHeadItems]["label"]];
                        }
                        $mainBrojacMenuHeadItems++;
                    }
                }


            }

            //MENU SIDE
            if($menuData->type=="menu_side"){
              $jsonMenuSideItems[] = $menuData->items;
            }
            $jsonMenuTitle[] = $menuData->title; //menu name
            $jsonMenuItems[] = $menuData->items; //menu items
        }








    }



    //catch all widgets on page
    foreach($jsonPageWidgetData as $w) {
      //get data for every widget on page based on their id
      $queryWidgetData = Widget::find($w['id']);
      $jsonWidgetWeight[] = $w['weight'];
      $jsonWidgetTitle[] = $queryWidgetData->name;
      $jsonWidgetSubTitle[] = $queryWidgetData->subtitle;
      $jsonWidgetType[] = $queryWidgetData->type;
      $jsonWidgetId[] = $queryWidgetData->widget_id;
      $jsonWidgetContentData[] = $queryWidgetData->data;
      $jsonWidgetContentImages[] = $queryWidgetData->images;
    }

    //save all widget data to main array
    for ($i=0;$i<count($jsonWidgetTitle);$i++){

      $mainJsonWidgetTitle = $jsonWidgetTitle[$i];
      $mainJsonWidgetSubTitle = $jsonWidgetSubTitle[$i];
      $mainJsonType = $jsonWidgetType[$i];
      $mainJsonContent = $jsonWidgetContentData[$i];
      $mainJsonImages = $jsonWidgetContentImages[$i];


      if($jsonWidgetType[$i]=="brochure-widget"){
        //DATA
        for($j=0;$j<count($mainJsonContent);$j++){
          $jsonContentTitle = $mainJsonContent["title"];
          $jsonContentSubtitle = $mainJsonContent["subtitle"];
          $jsonContentText = $mainJsonContent["text"];
          $jsonContentButton = $mainJsonContent["button"];
          $jsonContentPath = $mainJsonContent["path"];

        }
        //Content
        for($k=0;$k<count($mainJsonImages["title"]);$k++){
          $tmpImageArray[] = array("title"=>$mainJsonImages["title"][$k], "text"=>$mainJsonImages["text"][$k],
                            "img"=>$mainJsonImages["image"][$k], "path"=>$mainJsonImages["path"][$k]  );
        }

        $arr = array(
              'title' => $mainJsonWidgetTitle, 'subtitle' => $mainJsonWidgetSubTitle, 'widget' => $mainJsonType,
              'content' => [
                'title' => $jsonContentTitle,
                'subtitle' =>$jsonContentSubtitle,
                'text' => $jsonContentText,
                'button' => $jsonContentButton,
                'path' => $jsonContentPath,
                'items' =>
                    $tmpImageArray
                ]
              );

      $fullWidgetArray[] =  $arr;
      }

        if($jsonWidgetType[$i]=="image-widget"){
          //DATA
          for($j=0;$j<count($mainJsonContent);$j++){
            $jsonContentTitle = $mainJsonContent["title"];
            $jsonContentSubtitle = $mainJsonContent["subtitle"];
            $jsonContentText = $mainJsonContent["text"];
            $jsonContentButton = $mainJsonContent["button"];
            $jsonContentPath = $mainJsonContent["path"];
            $jsonContentImg = $mainJsonContent["img"];
          }

          $arr = array(
            'title' => $mainJsonWidgetTitle, 'subtitle' => $mainJsonWidgetSubTitle, 'widget' => $mainJsonType,
            'content' => [
              'title' => $jsonContentTitle,
              'subtitle' =>$jsonContentSubtitle,
              'text' => $jsonContentText,
              'button' => $jsonContentButton,
              'path' => $jsonContentPath,
              'img' => $jsonContentImg
              ]
            );

            $fullWidgetArray[] =  $arr;

        }


        if($jsonWidgetType[$i]=="carouseltwocolumns-widget"){
          //Content
          for($k=0;$k<count($mainJsonImages["title"]);$k++){
            $tmpImageArray[] = array("title"=>$mainJsonImages["title"][$k], "subtitle"=>$mainJsonImages["subtitle"][$k],
                              "text"=>$mainJsonImages["text"][$k], "button"=>$mainJsonImages["button"][$k],
                              "path"=>$mainJsonImages["path"][$k], "imgLeft"=>$mainJsonImages["imgLeft"][$k],
                              "imgRight"=>$mainJsonImages["imgRight"][$k]

                             );
          }

          $arr = array(
            'title' => $mainJsonWidgetTitle, 'subtitle' => $mainJsonWidgetSubTitle, 'widget' => $mainJsonType,
            'content' => [
              'slides' =>
                  $tmpImageArray
              ]
            );

            $fullWidgetArray[] =  $arr;

        }


  }


      return response()->json ([
        'page' => [
          [
            'title' => $jsonPageTitle,
            'meta' => [
              'title'=> $jsonMetaDataTitle,
              'description' => $jsonMetaDataDescription,
              'keywords'=> $jsonMetaDataKeywords,
              'author' => $jsonMetaDataAuthor,
              'currencies' => $jsonCurrencies,
              'languages' => $jsonLanguages
            ],
            'page' => [
              'layout' => $jsonPageLayout,
              'theme' => $jsonPageTheme
            ],
            'header' =>
              ["menu_top" => $jsonMenuTop,
               "menu_main" => $jsonMenuMain,
               "menu_side" => $jsonMenuSide
             ],
            'content' =>
              ['search' => [
                "collapsed" => $searchItemSearchCollapsed,
                "parametars" => [
                  "location" => $searchItemSearchLocation,
                  "from" => $searchItemSearchFrom,
                  "to" => $searchItemSearchTo,
                  "persons" => $searchItemSearchPerson,
                ]
              ] ,
              'sidebar' => $jsonPageSideBar,
              'main'=> $fullWidgetArray,
              'footer' => [],
              'newsletter' => [],
              'share' => []
            ]
          ]
        ]
      ]);

  }

}

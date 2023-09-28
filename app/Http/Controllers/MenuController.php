<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\Search;
use App\Models\MenuItem;
use App\Models\Site;
use App\Models\Locale;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use MongoDB\BSON\Regex as MongoRegex;

class MenuController extends Controller
{
    /**
     * List of menus
     *
     * @return \Illuminate\View\View View with list of menus
     */
    public function index(Request $request)
    {

        $viewData = [
            'title' => 'Menus',
            'bodyClasses' => 'model-index menu-index',
            'search' => [],
        ];

        $searchQuery = Search::query()->get();
        $menuQuery = Menu::query()->get();
      //  $searchQuery = Search::agreggate([ {$lookup:{from:'locales', localField : 'site_locale_id', foreignField : '_id'}}]);

        $viewData = [
            'title' => 'Menus',
            'bodyClasses' => 'model-index menu-index',
            'search' => $searchQuery,
            'menu' => $menuQuery
        ];


/*
        if($request->has('locale')) {
            $query->where('site_locale_id', $request->get('locale'));
            $viewData['search']['locale'] = $request->get('locale');
        }

        $sortRule = 'title';
        $sortOrder = 'asc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $viewData['sortRule'] = $sortRule;
        $viewData['sortOrder'] = $sortOrder;

        if($request->ajax()) {
            $menus = $query->orderBy('title')->get(['title']);
            return response()->json([
                'menus' => count($menus) == 0 ? [] : $menus->toArray()
            ]);
        }

        $menus = $query->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['menus'] = $menus;



      //  return view('menu.index', $viewData);
        $viewData2 = [
          'title' => 'searches',
          'bodyClasses' => 'model-index search-index',
          'search' => [],
      ];



      if($request->has('locale')) {
          $query->where('site_locale_id', $request->get('locale'));
          $viewData2['search']['locale'] = $request->get('locale');
      }


      if($request->has('sort')) {
          $sortRule = $request->get('sort');
      }
      if($request->has('order')) {
          $sortOrder = $request->get('order');
      }
      $viewData2['sortRule'] = $sortRule;
      $viewData2['sortOrder'] = $sortOrder;

      if($request->ajax()) {
          $searches = $query->orderBy('title')->get(['title']);
          return response()->json([
              'searches' => count($searches) == 0 ? [] : $searches->toArray()
          ]);
      }

      $searches = $query->orderBy($sortRule, $sortOrder)->paginate(20);
      $viewData2['searches'] = $searches;

      $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ]);
      $viewData2['sites'] = $sites;
      $viewData2['locales'] = [];
      foreach($sites as $site) {
          foreach($site->locales as $locale) {
              $viewData2['locales'][$locale->_id] = $locale->name . ' (' . $locale->locale->code . ')';
          }
      }
      asort($viewData2['locales']);
*/
//return 1;
      //return view('menu.index', $viewData,$viewData2);
      return view('menu.index', $viewData);
}
    /**
     * Show detailed information about a Menu with given ID
     *
     * @param string $id Menu ID
     * @return \Illuminate\View\View View with detailed info about Menu
     */
    public function show($id)
    {
       $menu = Menu::findOrFail($id);

        return view('menu.show', [
            'title' => 'View menu: ' . $menu->title,
            'menu' => $menu,
            'bodyClasses' => 'model-show menu-show',
        ]);

    }

    /**
     * Create new Menu
     *
     * @return \Illuminate\View\View View with form to create a menu
     */
    public function create()
    {
      $locales = Locale::orderBy('name')->get();
      /*  $sites = Site::with('locales')->orderBy('name')->get()->keyBy('_id');;
        $selectedSite = old('site_id', $sites->first()->_id);
        $hasLocales = false;
        if(isset($sites[$selectedSite]->locales) && !empty($sites[$selectedSite]->locales)) {
            $hasLocales = true;
            $selectedLocale = old('locale');
        }

        return view('menu.create', [
            'title' => 'Create new menu',
            'sites' => $sites,
            'selectedSite' => $selectedSite,
            'hasLocales' => $hasLocales,
            'selectedLocale' => isset($selectedLocale) ? $selectedLocale : null,
            'bodyClasses' => 'model-create menu-create',
        ]);
        */
        return view('menu.create', [
            'title' => 'Create new menu',
            'locales' => $locales,
            'bodyClasses' => 'model-create menu-create'
        ]);

    }

    /**
     * Store Menu in database
     *
     * @param \App\Http\Requests\MenuRequest $request Request with menu data
     * @return \Illuminate\Http\RedirectResponse Redirect back to menus index
     */
    public function store(MenuRequest $request)
    {
      //check type of selected menu
      $typeOfMenu = $request->input('type');

      //if we prepare to save search
      if($typeOfMenu=="search"){
        $search = new Search($request->all());
        $searchTitle = $request->input('title');
        $searchCollapsed = $request->input('searchCollapsed');  //1-false; 0-true
        $itemSearchLocation = $request->input('itemSearchLocation');
        $itemSearchAccomodation = $request->input('itemSearchAccomodation');
        $itemSearchFrom = $request->input('itemSearchFrom');
        $itemSearchTo = $request->input('itemSearchTo');
        $itemSearchAdults = $request->input('itemSearchAdults');
        $itemSearchKids = $request->input('$itemSearchKids');
        $search->save();
      }

      if($typeOfMenu=="menu_top" || $typeOfMenu=="menu_main" ){
        $menu = new Menu($request->all());
        $menuTitle = $request->input('title');
        $menuType = $request->input('type');
        if($request->has('items')) {
            foreach($request->input('items') as $i => $item) {
                $menuItem = new MenuItem([
                    'position' => isset($item['position']) ? $item['position'] : '',
                    'label' => $item['label'],
                    'labelHtml' => html_entity_decode($item['labelHtml']),
                    'type' => $item['type'],
                    'link' => $item['link'],
                    'parent' => $item['parent1'],
                    'tags' => $item['tags'],
                ]);
                $menu->items()->associate($menuItem);
            }
        }
        $menu->save();
      }




      /*
        $menu = new Menu($request->all());

        $menu->save();


        */
        return redirect()->route('menu.index');

    }

    /**
     * Edit Menu with given ID
     *
     * @param string $id Menu ID
     * @return \Illuminate\View\View View with a form to edit a menu
     */
    public function edit($id)
    {
        $menu = Menu::with('items')->findOrFail($id);
        $sites = Site::with('locales')->orderBy('name')->get()->keyBy('_id');;
        $selectedSite = old('site_id', $menu->site->_id);
        $hasLocales = false;
        if(isset($sites[$selectedSite]->locales) && !empty($sites[$selectedSite]->locales)) {
            $hasLocales = true;
            $selectedLocale = old('locale', $menu->locale->_id);
        }

        return view('menu.edit', [
            'title' => 'Edit menu: ' . $menu->title,
            'menu' => $menu,
            'sites' => $sites,
            'selectedSite' => $selectedSite,
            'hasLocales' => $hasLocales,
            'selectedLocale' => isset($selectedLocale) ? $selectedLocale : null,
            'bodyClasses' => 'model-edit menu-edit',
        ]);
    }

    /**
     * Update Menu with given ID
     *
     * @param string $id Menu ID
     * @param \App\Http\Request\MenuRequest $request Request with menu data
     * @return \Illuminate\Http\RedirectResponse Redirect back to menus index
     */
    public function update($id, MenuRequest $request)
    {
        $menu = Menu::findOrFail($id);
        $menu->fill($request->all());

        $menu->items()->delete();
        if($request->has('items')) {
            foreach($request->input('items') as $i => $item) {
                $menuItem = new MenuItem([
                    'position' => isset($item['position']) ? $item['position'] : 0,
                    'label' => $item['label'],
                    'labelHtml' => html_entity_decode($item['labelHtml']),
                    'type' => $item['type'],
                    'link' => $item['link'],
                    'tags' => $item['tags'],
                ]);
                $menu->items()->associate($menuItem);
            }
        }
        $menu->save();

        return redirect()->route('menu.index');
    }

    /**
     * Delete Menu with given ID
     *
     * @param string $id Menu ID
     * @param \Illuminate\Http\Request $request Request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse Returns a JSON response if called through AJAX or a redirect to menus index if called normally
     */
    public function destroy($id, Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'Menu %s successfully deleted'
        ];
        $responseCode = 200;

        try {
            $menu = Menu::find($id);
            $response['message'] = sprintf($response['message'], $menu->title);
            $menu->delete();
        } catch(ModelNotFoundException $e) {
            $response['success'] = false;
            $response['message'] = 'Menu with ID ' . $id . ' not found!';
            $responseCode = 404;
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to delete menu.';
            $responseCode = 500;
        }

        if($request->ajax()) {
            return response()->json($response, $responseCode);
        }

        return redirect()->route('menu.index');
    }

    public function lookup(Request $request)
    {
        $searchString = urldecode($request->get('s'));

        $menus = Menu::where('title', 'regex', new MongoRegex('.*' . $searchString .'.*', 'i'))->orderBy('title')->get();

        $menusArray = array();
        if($menus->count()) {
            foreach($menus as $menu) {
                $menusArray[] = array(
                    'id' => $menu->_id,
                    'title' => $menu->title,
                );
            }
        }

        return response()->json($menusArray);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageMetadata;
use App\Models\PageMenu;
use App\Models\PageSearch;
use App\Models\PageType;
use App\Models\Site;
use App\Models\Widget;
use App\Models\Menu;
use App\Models\Search;
use App\Http\Requests\PageRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use MongoDB\BSON\Regex as MongoRegex;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Pages',
            'bodyClasses' => 'model-index page-index',
        ];

        $query = Page::query()->with('site', 'type');

        $search = [];
        if($request->has('title')) {
            $regex = '/.*' . $request->get('title') . '.*/i';
            $query->where('title', 'regexp', $regex);
            $search['title'] = $request->get('title');
        }
        if($request->has('url')) {
            $regex = '/.*' . $request->get('url') . '.*/i';
            $query->where('url', 'regexp', $regex);
            $search['url'] = $request->get('url');
        }
        if($request->has('type')) {
            $query->where('type_id', $request->get('type'));
            $search['type'] = $request->get('type');
        }
        if($request->has('site')) {
            $query->where('site_id', $request->get('site'));
            $search['site'] = $request->get('site');
        }
        if($request->has('locale')) {
            $query->where('site_locale_id', $request->get('locale'));
            $search['locale'] = $request->get('locale');
        }
        $viewData['search'] = $search;

        $sortRule = 'updated_at';
        $sortOrder = 'desc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $viewData['sortRule'] = $sortRule;
        $viewData['sortOrder'] = $sortOrder;

        $pages = $query->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['pages'] = $pages;
        if($pages->count() == 0 && empty($search)) {
            $viewData['hasSites'] = Site::count() > 0 ?: false;
            $viewData['hasPageTypes'] = PageType::count() > 0 ?: false;
        }

      $pageTypes = PageType::orderBy('name')->lists('name', '_id');
        $viewData['pageTypes'] = $pageTypes;
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ]);
        $viewData['sites'] = $sites;
        $viewData['locales'] = [];
        foreach($sites as $site) {
            foreach($site->locales as $locale) {
                $viewData['locales'][$locale->_id] = $locale->name . ' (' . $locale->locale->code . ')';
            }
        }
        asort($viewData['locales']);

        return view('page.index', $viewData);
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('page.show', [
            'title' => 'View page: ' . $page->title,
            'page' => $page,
            'bodyClasses' => 'model-show page-show'
        ]);
    }

    public function create()
    {
        $pageTypes = PageType::with('templates')->orderBy('name')->get(['_id', 'name']);
        $sites = Site::with('locales', 'pageTypes', 'pageTypes.templates', 'pageTypes.attachedWidgets')->orderBy('name')->get([ 'name' ])->keyBy('_id');
        $selectedSite = old('site_id', $sites->first()->_id);
        $hasLocales = false;
        if(isset($sites->get($selectedSite)->locales) && !empty($sites->get($selectedSite)->locales)) {
            $hasLocales = true;
            $selectedLocale = old('locale');
        }
        $widgets = [];
        $widgets = Widget::query()->get();
        /*if(old('widgets')) {
            foreach(old('widgets') as $w) {
                $widget = Widget::find($w['id']);
                $widgets[] = [
                    'id' => $w['id'],
                    'name' => $widget->name,
                    'weight' => $w['weight'],
                ];
            }
        }*/
        $metadata = old('metadata', []);
        $query = Menu::query();
        $menus = $query->orderBy('title')->get(['title']);

        $querySearch = Search::query();
        $searches = $querySearch->orderBy('title')->get(['title']);

        return view('page.create', [
            'title' => 'Create new page',
            'pageTypes' => $pageTypes,
            'sites' => $sites,
            'selectedSite' => $selectedSite,
            'hasLocales' => $hasLocales,
            'selectedLocale' => isset($selectedLocale) ? $selectedLocale : null,
            'widgets' => $widgets,
            'metadata' => $metadata,
            'menu' => $menus,
            'search' => $searches,
            'bodyClasses' => 'model-create page-create',

        ]);
    }

    public function store(PageRequest $request)
    {

        $page = new Page($request->all());
        // Page metadata
        if(!empty($request->get('metadata', []))) {
            foreach($request->get('metadata') as $_metadata) {
                $page->metadata()->associate(new PageMetadata($_metadata));
            }
        }
        else {
          $page->metadata()->associate(new PageMetadata([]));
        }

        // Page menu
        if(!empty($request->get('menu_items', []))) {
            foreach($request->get('menu_items') as $_menu) {
              //  var_dump($_menu);
                $page->menu()->associate(new PageMenu($_menu));
            }
        }
        else {
          $page->menu()->associate(new PageMenu(array()));
        }

        // Page search
        if(!empty($request->get('search_items', []))) {
            foreach($request->get('search_items') as $_search) {
              //  var_dump($_menu);
                $page->search()->associate(new PageSearch($_search));
            }
        }
        else {
          $page->search()->associate(new PageSearch(array()));
        }

        $page->save();

        return redirect()->route('page.index');

    }

    public function edit($id)
    {
        $page = Page::with('parent', 'type.templates')->findOrFail($id);
        $pageTypes = PageType::with('templates')->orderBy('name')->get(['_id', 'name']);
        $sites = Site::with('locales', 'pageTypes', 'pageTypes.templates', 'pageTypes.attachedWidgets')->orderBy('name')->get([ 'name' ])->keyBy('_id');
        $selectedSite = old('site_id', $page->site->_id);
        $hasLocales = false;
        if(isset($sites[$selectedSite]->locales) && !empty($sites[$selectedSite]->locales)) {
            $hasLocales = true;
            $selectedLocale = old('locale', $page->locale->_id);
        }
        $widgets = [];
        if(isset($page->widgets) && !empty($page->widgets)) {
            foreach($page->widgets as $w) {
                $widget = Widget::find($w['id']);
                if($widget) {
                    $widgets[] = [
                        'id' => $w['id'],
                        'name' => $widget->name,
                        'group' => $w['group'],
                        'weight' => $w['weight'],
                    ];
                }
            }
        }
        $metadata = old('metadata', isset($page->metadata) ? $page->metadata : []);

        return view('page.edit', [
            'title' => 'Edit page: ' . $page->title,
            'page' => $page,
            'pageTypes' => $pageTypes,
            'sites' => $sites,
            'selectedSite' => $selectedSite,
            'hasLocales' => $hasLocales,
            'selectedLocale' => isset($selectedLocale) ? $selectedLocale : null,
            'widgets' => $widgets,
            'metadata' => $metadata,
            'bodyClasses' => 'model-edit page-edit',
        ]);
    }

    public function update($id, PageRequest $request)
    {
        $page = Page::findOrFail($id);

        $page->fill($request->all());
        if(!$request->get('widgets')) {
            $page->unset('widgets');
        }

        // Metadata
        $page->metadata()->delete();
        if(!empty($request->get('metadata', []))) {
            foreach($request->get('metadata') as $_metadata) {
                $page->metadata()->associate(new PageMetadata($_metadata));
            }
        }

        $page->save();

        return redirect()->route('page.index');
    }

    public function destroy($id, Request $request)
    {
        try {
            Page::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete page.',
                ], 500);
            }
            return redirect()->route('page.index');
        }

        return redirect()->route('page.index');
    }

    public function lookup(Request $request)
    {
        $searchString = urldecode($request->get('s'));

        $pages = Page::where('title', 'regex', new MongoRegex('.*' . $searchString .'.*', 'i'))->orWhere('url', 'regex', new MongoRegex('.*' . $searchString . '.*', 'i'))->orderBy('title')->take(100)->get();

        $pagesArray = array();
        if($pages->count()) {
            foreach($pages as $page) {
                $pagesArray[] = array(
                    'id' => $page->_id,
                    'title' => $page->title,
                    'url' => $page->url,
                );
            }
        }

        return response()->json($pagesArray);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use App\Models\Site;
use App\Models\SiteLocale;
use App\Models\SiteOption;
use App\Models\SiteWidget;
use App\Http\Requests\SiteRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SiteController extends Controller {

    /**
     * List sites
     *
     * @param Illuminate\Http\Request $request Request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Sites',
            'bodyClasses' => 'model-index site-index',
            'search' => [],
        ];

        $query = Site::query();
        if($request->has('name')) {
            $regex = '/.*' . $request->get('name') . '.*/i';
            $query->where('name', 'regexp', $regex);
            $viewData['search']['name'] = $request->get('name');
        }
        if($request->has('domain')) {
            $regex = '/.*' . $request->get('domain') . '.*/i';
            $query->where('domain', 'regexp', $regex);
            $viewData['search']['domain'] = $request->get('domain');
        }

        $sortRule = 'name';
        $sortOrder = 'asc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $viewData['sortRule'] = $sortRule;
        $viewData['sortOrder'] = $sortOrder;
        $query = $query->orderBy($sortRule, $sortOrder);

        if($request->ajax()) {
            $sites = $query->with('locales')->get();
            return response()->json($sites);
        }

        $sites = $query->paginate(10);
        $viewData['sites'] = $sites;

        return view('site.index', $viewData);
    }

    public function show($id, Request $request)
    {
        $site = Site::with('locales')->findOrFail($id);

        if($request->ajax()) {
            return response()->json($site);
        }

        return view('site.show', [
            'title' => 'View site: ' . $site->name,
            'site' => $site ,
        ]);
    }

    public function create()
    {
        $locales = Locale::orderBy('name')->get();

        return view('site.create', [
            'title' => 'Create new site',
            'locales' => $locales,
        ]);
    }

    public function store(SiteRequest $request)
    {
        $site = new Site($request->except('locales', 'options', 'layout'));

        /*LANGUAGE */
        $language_items = $request->get('language_items');
        $site->languages = [];
        $languages = [];
        if(!empty($language_items)){
          foreach($language_items as $curr){
            $languages[] = [
              'value' => $curr["id"],
              'active' => $curr["active"]
            ];
          }
        }
        else {
          $languages[] = [
            'value' => NULL,
            'active' => '0'
          ];
        }
        $site->languages = $languages;

        /*CURRENCY*/
        $currency_items = $request->get('currency_items');
        $site->currencies = [];
        $currencies = [];
        if(!empty($currency_items)){
          foreach($currency_items as $curr){
            $currencies[] = [
              'value' => $curr["id"],
              'active' => $curr["active"]
            ];
          }
        }
        else {
          $currencies[] = [
            'value' => NULL,
            'active' => '0'
          ];
        }
        $site->currencies = $currencies;

        /*NEWSLETTER PART*/
        $site->newsletter = [];
        $newsletter_title = $request->get('newsletter_title');
        if(empty($newsletter_title)){  $newsletter_title = "NULL"; }
        $newsletter_subtitle = $request->get('newsletter_subtitle');
        if(empty($newsletter_subtitle)){  $newsletter_subtitle = "NULL"; }
        $newsletter_email_text = $request->get('newsletter_email_text');
        if(empty($newsletter_email_text)){  $newsletter_email_text = "NULL"; }
        $newsletter_button_text = $request->get('newsletter_button_text');
        if(empty($newsletter_button_text)){  $newsletter_button_text = "NULL"; }
        $newsletter = [];
        $newsletter[] = [
            'title' => $newsletter_title,
            'subtitle' => $newsletter_subtitle,
            'email_text' => $newsletter_email_text,
            'button_text' => $newsletter_button_text
        ];
        $site->newsletter = $newsletter;

        /*SHARE PART*/
        $site->share = [];
        $share_title = $request->get('share_title');
        if(empty($share_title)){  $share_title = "NULL"; }
        $share_facebook = $request->get('share_facebook');
        if(empty($share_facebook)){  $share_facebook = "NULL"; }
        $share_twitter = $request->get('share_twitter');
        if(empty($share_twitter)){  $share_twitter = "NULL"; }
        $share_google = $request->get('share_google');
        if(empty($share_google)){  $share_google = "NULL"; }
        $share_linkedin = $request->get('share_linkedin');
        if(empty($share_linkedin)){  $share_linkedin = "NULL"; }
        $share = [];
        $share[] = [
            'name' => $share_title,
            'facebook' => $share_facebook,
            'twitter' => $share_twitter,
            'google' => $share_google,
            'linkedin' => $share_linkedin
        ];
        $site->share = $share;



        /*if(!empty($locales)) {
            foreach($locales['name'] as $id => $localeName) {
                $locale = Locale::findOrFail($locales['locale'][$id]);
                $siteLocale = new SiteLocale();
                $siteLocale->name = $locales['name'][$id];
                $siteLocale->type =  $locales['type'][$id];
                $siteLocale->active = (bool)$locales['active'][$id];
                $siteLocale->locale()->associate($locale);
                if($locales['type'][$id] == 'url_prefix') {
                    $siteLocale->url_prefix = $locales['id'][$id];
                } elseif($locales['type'][$id] == 'subdomain') {
                    $siteLocale->subdomain = $locales['id'][$id];
                }
                $site->locales()->associate($siteLocale);
            }
        }*/
  $locales = $request->get('locales');
        if(!empty($locales)) {
            foreach($locales['name'] as $id => $localeName) {
                $locale = Locale::findOrFail($locales['locale'][$id]);
                $siteLocale = new SiteLocale();
                $siteLocale->name = $locales['name'][$id];
                $siteLocale->type =  $locales['type'][$id];
                $siteLocale->active = (bool)$locales['active'][$id];
                $siteLocale->locale()->associate($locale);
                if($locales['type'][$id] == 'url_prefix') {
                    $siteLocale->url_prefix = $locales['id'][$id];
                } elseif($locales['type'][$id] == 'subdomain') {
                    $siteLocale->subdomain = $locales['id'][$id];
                }

                $site->locales()->associate($siteLocale);
            }
        }

        $site->options = [];
        if($request->has('options')) {
            $options = [];
            foreach($request->input('options.name') as $i => $val) {
                $options[] = [
                    'name' => $val,
                    'value' => $request->input('options.value.' . $i),
                ];
            }
            $site->options = $options;
        }
        if($request->has('layout')) {
            $regions = [];
            foreach($request->input('layout.regions.name') as $i => $val) {
                $regions[] = [
                    'id' => $request->input('layout.regions.id.' . $i),
                    'name' => $val,
                ];
            }
            $site->layout = [ 'regions' => $regions ];
        }

        $site->save();

        return redirect()->route('site.index');

    }

    public function edit($id)
    {
        $site = Site::with([ 'locales' , 'options' ])->findOrFail($id);
        $locales = Locale::orderBy('name')->get();

        return view('site.edit', [
            'title' => 'Edit site: ' . $site->name,
            'site' => $site,
            'locales' => $locales,
        ]);
    }

    public function update($id, SiteRequest $request)
    {
        $site = Site::findOrFail($id);

        $site->name = $request->get('name');
        $site->domain = $request->get('domain');
        $site->https = $request->has('https') ?: false;

        $locales = $request->get('locales');
        if(!empty($locales)) {
            foreach($locales['name'] as $id => $localeName) {
                $locale = Locale::findOrFail($locales['locale'][$id]);
                if(!isset($locales['_id'][$id])) {
                    $siteLocale = new SiteLocale();
                } else {
                    $siteLocale = SiteLocale::find($locales['_id'][$id]);
                }
                $siteLocale->name = $locales['name'][$id];
                $siteLocale->type =  $locales['type'][$id];
                $siteLocale->active = (bool)$locales['active'][$id];
                $siteLocale->locale()->associate($locale);
                if($locales['type'][$id] == 'url_prefix') {
                    $siteLocale->url_prefix = $locales['id'][$id];
                } elseif($locales['type'][$id] == 'subdomain') {
                    $siteLocale->subdomain = $locales['id'][$id];
                }
                $site->locales()->save($siteLocale);
            }
        }

        // Replace options
        $site->options()->delete();
        if($request->has('options')) {
            foreach($request->input('options.name') as $i => $val) {
                $option = new SiteOption([
                    'name' => $val,
                    'site_locale_id' => $request->input('options.locale.' . $i) != '0' ? $request->input('options.locale.' . $i) : null,
                    'value' => $request->input('options.value.' . $i),
                ]);
                $site->options()->associate($option);
            }
        }

        // Layout (regions)
        $site->layout = null;
        if($request->has('layout')) {
            $regions = [];
            foreach($request->input('layout.regions.name') as $i => $val) {
                $regions[] = [
                    'id' => $request->input('layout.regions.id.' . $i),
                    'name' => $val,
                ];
            }
            $site->layout = [ 'regions' => $regions ];
        }

        // Widgets
        $site->attachedWidgets()->delete();
        if($request->has('widgets')) {
            foreach($request->input('widgets.widget') as $i => $widgetId) {
                $widget = new SiteWidget([
                    'widget_id' => $widgetId,
                    'site_locale_id' => $request->input('widgets.locale.' . $i),
                    'region' => $request->input('widgets.region.' . $i),
                    'weight' => $request->input('widgets.weight.' . $i),
                ]);
                $site->attachedWidgets()->associate($widget);
            }
        }

        $site->save();

        return redirect()->route('site.index');
    }

    public function destroy($id, Request $request)
    {
        try {
            Site::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Site successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete site.',
                ], 500);
            }
            return redirect()->route('site.index');
        }

        return redirect()->route('site.index');
    }

}

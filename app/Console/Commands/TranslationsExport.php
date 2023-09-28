<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\Translation;
use Illuminate\Console\Command;

class TranslationsExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export translations into CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $sites = Site::with('locales')->get();
        foreach($sites as $site) {
            $this->info('Exporting translations for ' . $site->name . '...');
            $locales = $site->locales->map(function($locale) {
                return $locale->name . '|' . $locale->id;
            });
            $translations = Translation::where('site_id', $site->id)->get();
            $csvFile = storage_path('app/' . $site->name . '_translations-export.csv');
            $fh = fopen($csvFile, 'w');
            fputcsv($fh, array_merge([ 'key', 'source' ], $locales->toArray()));
            foreach($translations as $trans) {
                $exportTrans = $site->locales->map(function($locale) use ($trans) {
                    if(isset($trans->translations[$locale->id])) {
                        return $trans->translations[$locale->id];
                    }
                    return '';
                });
                fputcsv($fh, array_merge([ $trans->key, $trans->source ], $exportTrans->toArray()));
            }
            fclose($fh);

            $this->info('Exported ' . count($translations) . ' translations to ' . $csvFile);
        }  
    }
}

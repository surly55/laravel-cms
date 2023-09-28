<?php

use Illuminate\Database\Seeder;

class LocalesCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('locales')->delete();

        // List of languages with ISO 639-1 codes, taken from www.loc.gov/standards/iso639-2/php/code_list.php
        DB::collection('locales')->insert([
            [ 'name' => 'Afar', 'code' => 'aa' ],
            [ 'name' => 'Abkhazian', 'code' => 'ab' ],
            [ 'name' => 'Afrikaans', 'code' => 'af' ],
            [ 'name' => 'Akan', 'code' => 'ak' ],
            [ 'name' => 'Albanian', 'code' => 'sq' ],
            [ 'name' => 'Amharic', 'code' => 'am' ],
            [ 'name' => 'Arabic', 'code' => 'ar' ],
            [ 'name' => 'Aragonese', 'code' => 'an' ],
            [ 'name' => 'Assamese', 'code' => 'as' ],
            [ 'name' => 'Avaric', 'code' => 'av' ],
            [ 'name' => 'Avestan', 'code' => 'ae' ],
            [ 'name' => 'Aymara', 'code' => 'ay' ],
            [ 'name' => 'Azerbaijani', 'code' => 'az' ],
            [ 'name' => 'Bashkir', 'code' => 'ba' ],
            [ 'name' => 'Bambara', 'code' => 'bm' ],
            [ 'name' => 'Basque', 'code' => 'eu' ],
            [ 'name' => 'Belarusian', 'code' => 'be' ],
            [ 'name' => 'Bengali', 'code' => 'bn' ],
            [ 'name' => 'Bihari languages', 'code' => 'bh' ],
            [ 'name' => 'Bislama', 'code' => 'bi' ],
            [ 'name' => 'Tibetan', 'code' => 'bo' ],
            [ 'name' => 'Bosnian', 'code' => 'bs' ],
            [ 'name' => 'Breton', 'code' => 'br' ],
            [ 'name' => 'Bulgarian', 'code' => 'bg' ],
            [ 'name' => 'Catalan (Valencian)', 'code' => 'ca' ],
            [ 'name' => 'Czech', 'code' => 'cs' ],
            [ 'name' => 'Chamorro', 'code' => 'ch' ],
            [ 'name' => 'Chechen', 'code' => 'ce' ],
            [ 'name' => 'Chinese', 'code' => 'zh' ],
            [ 'name' => 'Church Slavic', 'code' => 'cu' ],
            [ 'name' => 'Chuvash', 'code' => 'cv' ],
            [ 'name' => 'Cornish', 'code' => 'kw' ],
            [ 'name' => 'Corsican', 'code' => 'co' ],
            [ 'name' => 'Cree', 'code' => 'cr' ],
            [ 'name' => 'Welsh', 'code' => 'cy' ],
            [ 'name' => 'Danish', 'code' => 'da' ],
            [ 'name' => 'Divehi (Dhivehi, Maldivian)', 'code' => 'dv' ],
            [ 'name' => 'Dutch (Flemish)', 'code' => 'nl' ],
            [ 'name' => 'Dzongkha', 'code' => 'dz' ],
            [ 'name' => 'Greek, Modern', 'code' => 'el' ],
            [ 'name' => 'English', 'code' => 'en' ],
            [ 'name' => 'Esperanto', 'code' => 'eo' ],
            [ 'name' => 'Estonian', 'code' => 'et' ],
            [ 'name' => 'Ewe', 'code' => 'ee' ],
            [ 'name' => 'Faroese', 'code' => 'fo' ],
            [ 'name' => 'Persian', 'code' => 'fa' ],
            [ 'name' => 'Fijian', 'code' => 'fj' ],
            [ 'name' => 'Finnish', 'code' => 'fi' ],
            [ 'name' => 'French', 'code' => 'fr' ],
            [ 'name' => 'Western Frisian', 'code' => 'fy' ],
            [ 'name' => 'Fulah', 'code' => 'ff' ],
            [ 'name' => 'Georgian', 'code' => 'ka' ],
            [ 'name' => 'German', 'code' => 'de' ],
            [ 'name' => 'Gaelic (Scottish Gaelic)', 'code' => 'gd' ],
            [ 'name' => 'Irish', 'code' => 'ga' ],
            [ 'name' => 'Galician', 'code' => 'gl' ],
            [ 'name' => 'Manx', 'code' => 'gv' ],
            [ 'name' => 'Guarani', 'code' => 'gn' ],
            [ 'name' => 'Gujarati', 'code' => 'gu' ],
            [ 'name' => 'Haitian (Haitian Creole)', 'code' => 'ht' ],
            [ 'name' => 'Hausa', 'code' => 'ha' ],
            [ 'name' => 'Hebrew', 'code' => 'he' ],
            [ 'name' => 'Herero', 'code' => 'hz' ],
            [ 'name' => 'Hindi', 'code' => 'hi' ],
            [ 'name' => 'Hiri Motu', 'code' => 'ho' ],
            [ 'name' => 'Croatian', 'code' => 'hr' ],
            [ 'name' => 'Hungarian', 'code' => 'hu' ],
            [ 'name' => 'Armenian', 'code' => 'hy' ],
            [ 'name' => 'Igbo', 'code' => 'ig' ],
            [ 'name' => 'Icelandic', 'code' => 'is' ],
            [ 'name' => 'Ido', 'code' => 'io' ],
            [ 'name' => 'Sichuan Yi (Nuosu)', 'code' => 'ii' ],
            [ 'name' => 'Inuktitut', 'code' => 'iu' ],
            [ 'name' => 'Interlingue (Occidental)', 'code' => 'ie' ],
            [ 'name' => 'Interlingua (International Auxiliary Language Association)', 'code' => 'ia' ],
            [ 'name' => 'Indonesian', 'code' => 'id' ],
            [ 'name' => 'Inupiaq', 'code' => 'ik' ],
            [ 'name' => 'Italian', 'code' => 'it' ],
            [ 'name' => 'Javanese', 'code' => 'jv' ],
            [ 'name' => 'Japanese', 'code' => 'ja' ],
            [ 'name' => 'Kalaallisut (Greenlandic)', 'code' => 'kl' ],
            [ 'name' => 'Kannada', 'code' => 'kn' ],
            [ 'name' => 'Kashmiri', 'code' => 'ks' ],
            [ 'name' => 'Kanuri', 'code' => 'kr' ],
            [ 'name' => 'Kazakh', 'code' => 'kk' ],
            [ 'name' => 'Central Khmer', 'code' => 'km' ],
            [ 'name' => 'Kikuyu (Gikuyu)', 'code' => 'ki' ],
            [ 'name' => 'Kinyarwanda', 'code' => 'rw' ],
            [ 'name' => 'Kirghiz (Kyrgyz)', 'code' => 'ky' ],
            [ 'name' => 'Komi', 'code' => 'kv' ],
            [ 'name' => 'Kongo', 'code' => 'kg' ],
            [ 'name' => 'Korean', 'code' => 'ko' ],
            [ 'name' => 'Kuanyama (Kwanyama)', 'code' => 'kj' ],
            [ 'name' => 'Kurdish', 'code' => 'ku' ],
            [ 'name' => 'Lao', 'code' => 'lo' ],
            [ 'name' => 'Latin', 'code' => 'la' ],
            [ 'name' => 'Latvian', 'code' => 'lv' ],
            [ 'name' => 'Limburgan (Limburger, Limburgish)', 'code' => 'li' ],
            [ 'name' => 'Lingala', 'code' => 'ln' ],
            [ 'name' => 'Lithuanian', 'code' => 'lt' ],
            [ 'name' => 'Luxembourgish (Letzeburgesch)', 'code' => 'lb' ],
            [ 'name' => 'Luba-Katanga', 'code' => 'lu' ],
            [ 'name' => 'Ganda', 'code' => 'lg' ],
            [ 'name' => 'Macedonian', 'code' => 'mk' ],
            [ 'name' => 'Marshallese', 'code' => 'mh' ],
            [ 'name' => 'Malayalam', 'code' => 'ml' ],
            [ 'name' => 'Maori', 'code' => 'mi' ],
            [ 'name' => 'Marathi', 'code' => 'mr' ],
            [ 'name' => 'Malay', 'code' => 'ms' ],
            [ 'name' => 'Malagasy', 'code' => 'mg' ],
            [ 'name' => 'Maltese', 'code' => 'mt' ],
            [ 'name' => 'Mongolian', 'code' => 'mn' ],
            [ 'name' => 'Burmese', 'code' => 'my' ],
            [ 'name' => 'Nauru', 'code' => 'na' ],
            [ 'name' => 'Navajo (Navaho)', 'code' => 'nv' ],
            [ 'name' => 'Ndebele, South (South Ndebele)', 'code' => 'nr' ],
            [ 'name' => 'Ndebele, North (North Ndebele)', 'code' => 'nd' ],
            [ 'name' => 'Ndonga', 'code' => 'ng' ],
            [ 'name' => 'Nepali', 'code' => 'ne' ],
            [ 'name' => 'Norwegian Nynorsk (Nynorsk, Norwegian)', 'code' => 'nn' ],
            [ 'name' => 'Bokmål, Norwegian (Norwegian Bokmål)', 'code' => 'nb' ],
            [ 'name' => 'Norwegian', 'code' => 'no' ],
            [ 'name' => 'Chichewa (Chewa; Nyanja)', 'code' => 'ny' ],
            [ 'name' => 'Occitan (post 1500)', 'code' => 'oc' ],
            [ 'name' => 'Ojibwa', 'code' => 'oj' ],
            [ 'name' => 'Oriya', 'code' => 'or' ],
            [ 'name' => 'Oromo', 'code' => 'om' ],
            [ 'name' => 'Ossetian (Ossetic)', 'code' => 'os' ],
            [ 'name' => 'Panjabi (Punjabi)', 'code' => 'pa' ],
            [ 'name' => 'Pali', 'code' => 'pi' ],
            [ 'name' => 'Polish', 'code' => 'pl' ],
            [ 'name' => 'Portuguese', 'code' => 'pt' ],
            [ 'name' => 'Pushto (Pashto)', 'code' => 'ps' ],
            [ 'name' => 'Quechua', 'code' => 'qu' ],
            [ 'name' => 'Romansh', 'code' => 'rm' ],
            [ 'name' => 'Romanian (Moldavian; Moldovan)', 'code' => 'ro' ],
            [ 'name' => 'Rundi', 'code' => 'rn' ],
            [ 'name' => 'Russian', 'code' => 'ru' ],
            [ 'name' => 'Sango', 'code' => 'sg' ],
            [ 'name' => 'Sanskrit', 'code' => 'sa' ],
            [ 'name' => 'Sinhala (Sinhalese)', 'code' => 'si' ],
            [ 'name' => 'Slovak', 'code' => 'sk' ],
            [ 'name' => 'Slovenian', 'code' => 'sl' ],
            [ 'name' => 'Northern Sami', 'code' => 'se' ],
            [ 'name' => 'Samoan', 'code' => 'sm' ],
            [ 'name' => 'Shona', 'code' => 'sn' ],
            [ 'name' => 'Sindhi', 'code' => 'sd' ],
            [ 'name' => 'Somali', 'code' => 'so' ],
            [ 'name' => 'Sotho, Southern', 'code' => 'st' ],
            [ 'name' => 'Spanish (Castilian)', 'code' => 'es' ],
            [ 'name' => 'Sardinian', 'code' => 'sc' ],
            [ 'name' => 'Serbian', 'code' => 'sr' ],
            [ 'name' => 'Swati', 'code' => 'ss' ],
            [ 'name' => 'Sundanese', 'code' => 'su' ],
            [ 'name' => 'Swahili', 'code' => 'sw' ],
            [ 'name' => 'Swedish', 'code' => 'sv' ],
            [ 'name' => 'Tahitian', 'code' => 'ty' ],
            [ 'name' => 'Tamil', 'code' => 'ta' ],
            [ 'name' => 'Tatar', 'code' => 'tt' ],
            [ 'name' => 'Telugu', 'code' => 'te' ],
            [ 'name' => 'Tajik', 'code' => 'tg' ],
            [ 'name' => 'Tagalog', 'code' => 'tl' ],
            [ 'name' => 'Thai', 'code' => 'th' ],
            [ 'name' => 'Tigrinya', 'code' => 'ti' ],
            [ 'name' => 'Tonga (Tonga Islands)', 'code' => 'to' ],
            [ 'name' => 'Tswana', 'code' => 'tn' ],
            [ 'name' => 'Tsonga', 'code' => 'ts' ],
            [ 'name' => 'Turkmen', 'code' => 'tk' ],
            [ 'name' => 'Turkish', 'code' => 'tr' ],
            [ 'name' => 'Twi', 'code' => 'tw' ],
            [ 'name' => 'Uighur (Uyghur)', 'code' => 'ug' ],
            [ 'name' => 'Ukrainian', 'code' => 'uk' ],
            [ 'name' => 'Urdu', 'code' => 'ur' ],
            [ 'name' => 'Uzbek', 'code' => 'uz' ],
            [ 'name' => 'Venda', 'code' => 've' ],
            [ 'name' => 'Vietnamese', 'code' => 'vi' ],
            [ 'name' => 'Volapük', 'code' => 'vo' ],
            [ 'name' => 'Walloon', 'code' => 'wa' ],
            [ 'name' => 'Wolof', 'code' => 'wo' ],
            [ 'name' => 'Xhosa', 'code' => 'xh' ],
            [ 'name' => 'Yiddish', 'code' => 'yi' ],
            [ 'name' => 'Yoruba', 'code' => 'yo' ],
            [ 'name' => 'Zhuang (Chuang)', 'code' => 'za' ],
            [ 'name' => 'Zulu', 'code' => 'zu' ],
        ]);
    }
}

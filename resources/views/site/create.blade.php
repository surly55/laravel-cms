@extends('layouts.master')

@section('javascripts')
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/js/sites.min.js"></script>
<script src="/js/sites_custom.js"></script>
@endsection

@section('content')
    {!! Form::open([ 'route' => 'site.store', 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-globe-plus"></i>Create site <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('site.index') }}">Sites</a></li>
            <li class="active">Create</strong></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid box-primary box-site-details">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.details"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form', [ 'action' => 'create' ])
                    </div>
                </div>

                <div class="box box-site-locales">
                    <div class="box-header with-border">
                        <h3 class="box-title">Locales</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-locales', [ 'action' => 'create' ])
                    </div>
                </div>
            </div>

              <div class="col-md-6">

                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Languages</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-8">
                        <select id="languageNames" class="form-control">
                            <option value="0" disabled>Select...</option>
                            <option value="hr" >Croatian</option>
                            <option value="en" >English</option>
                            <option value="it" >Italian</option>
                            <option value="de" >Deutsch</option>
                            <option value="ru" >Russian</option>
                            <option value="fr" >Francais</option>
                            <option value="es" >Espanol</option>
                            <option value="po" >Polski</option>
                            <option value="sl" >Slovenčina</option>
                            <option value="ro" >Romana</option>
                            <option value="ch" >Čestina</option>
                            <option value="po" >Portuguese</option>
                            <option value="ch" >Chinese</option>
                            <option value="ar" >Arabic</option>
                        </select>
                      </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-default btn-block" id="addLanguage"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>
                        <div class="box-body">
                        <table id="tableLanguage" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
                            <thead>
                                <tr>
                                    <th class="col-sm-6">Name</th>
                                    <th class="col-sm-1">Active</th>
                                    <th class="col-sm-5">-</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>



                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Currencies</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-8">
                        <select id="currenciesName" class="form-control">
                            <option value="0" disabled>Select...</option>
                            <option value="eur">EUR</option>
                            <option value="hrk">HRK</option>
                            <option value="usd">USD</option>
                            <option value="jpy">JPY</option>
                            <option value="gbp">GBP</option>
                            <option value="aud">AUD</option>
                            <option value="cad">CAD</option>
                            <option value="chf">CHF</option>
                            <option value="cny">CNY</option>
                            <option value="rub">RUB</option>
                            <option value="inr">INR</option>
                            <option value="km">KM</option>
                        </select>
                      </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-default btn-block" id="addCurency"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <div class="box-body">
                    <table id="tableCurrency" class="table table-striped table-bordered table-condensed" style="margin-top: 5px">
                        <thead>
                            <tr>
                                <th class="col-sm-6">Name</th>
                                <th class="col-sm-1">Active</th>
                                <th class="col-sm-5">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>

                </div>

                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Newsletter</h3>
                    </div>
                    <div class="box-body">
                      <label for="newsletter_title">Title</label>
                      <input placeholder="Newsletter title" type="text" class="form-control" name="newsletter_title" id="newsletter_title">
                      <br>
                      <label for="localeName">Subtitle</label>
                      <input placeholder="Newsletter subtitle" type="text" class="form-control" name="newsletter_subtitle" id="newsletter_subtitle">
                      <br>
                      <label for="localeName">E-mail text</label>
                      <input placeholder="Newsletter e-mail text" type="text" class="form-control" name="newsletter_email_text" id="newsletter_email_text">
                      <br>
                      <label for="localeName">Button text</label>
                      <input placeholder="Newsletter button text" type="text" class="form-control" name="newsletter_button_text" id="newsletter_button_text">
                      <br>
                    </div>
                </div>

                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Share</h3>


                    </div>
                    <div class="box-body">
                      <div class="form-group">
                          <label for="localeName">Share title</label>
                          <input placeholder="Main share title" type="text" class="form-control" name="share_title" id="share_title">
                      </div>
                      <div class="form-group">
                        <i class="fa fa-facebook"></i>
                          <input placeholder="Facebok share url" type="text" class="form-control" name="share_facebook" id="share_facebook">
                      </div>
                      <div class="form-group">
                        <i class="fa fa-twitter"></i>
                          <input placeholder="Twitter share url" type="text" class="form-control" name="share_twitter" id="share_twitter">
                      </div>
                      <div class="form-group">
                        <i class="fa fa-google"></i>
                          <input placeholder="Google share url" type="text" class="form-control" name="share_google" id="share_google">
                      </div>
                      <div class="form-group">
                        <i class="fa fa-linkedin"></i>
                          <input placeholder="Linkedin share url" type="text" class="form-control" name="share_linkedin" id="share_linkedin">
                      </div>


                    </div>
                </div>



              </div>

            <div class="col-md-6" style="display:none;">
                <div class="box box-default box-site-options">
                    <div class="box-header with-border">
                        <h3 class="box-title">Options</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-options', [ 'action' => 'create' ])
                    </div>
                </div>

                <div class="box box-default box-site-layout">
                    <div class="box-header with-border">
                        <h3 class="box-title">Layout</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.layout"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('site._form-layout', [ 'action' => 'create' ])
                    </div>
                </div>

                <div class="box box-default box-site-layout">
                    <div class="box-header with-border">
                        <h3 class="box-title">Widgets</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="help" data-help="site.widgets"><i class="fa fa-question" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <p>After you've created a site and added a few widgets, you may add them here as site-wide widgets.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::close() !!}
@endsection

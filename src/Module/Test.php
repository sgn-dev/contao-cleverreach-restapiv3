<?php
/**
 * Cleverreach API Bundle for Contao Open Source CMS
 *
 * Copyright (C) 2018 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Sgn47gradnord\Cleverreachapi\Module;

use Patchwork\Utf8;

class Test extends AbstractModule
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'test';

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['cl_test'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile()
    {
        // This file contains both:
//   1. A simulation of your page/plugin/service to start the OAuth
//   2. The callback page to be called after OAuth finished
// Make sure to place this file freely accessible on a server!

// At first some very important variables:

// Values from your OAuth app. You create ONE for a page/plugin/service.
        $clientid     = "btTGlNQMm5";
        $clientsecret = "NCz9QfYfiglnlGsw54P5N0yHHUuxGRDu";

// This is the url of your callback page, to be called after OAuth finished.
// In this case it is this file - wherever you put it on your server.
        $redirect_uri = "http://dev.spielwiese:8888/app_dev.php/";

// The official CleverReach URLs, no need to change those.
        $auth_url  = "https://rest.cleverreach.com/oauth/authorize.php";
        $token_url = "https://rest.cleverreach.com/oauth/token.php";


// As the callback page is called by our OAuth service with a code, we use that parameter to differ between the two pages.

        if (!$_GET["code"]) {  // If there is no code, this page was propably opened in a browser normally

            // This is a simulation of YOUR page/plugin/service.
            echo "<h1>My fancy web service</h1>";
            echo "<h2>Please let me access your CleverReach® account, user!</h2>";

            // The link will redirect the user to our OAuth service.
            // As the redirect_uri is used as a url parameter, we have to encode it accordingly.
            $redir = urlencode($redirect_uri);
            echo "<a href=\"{$auth_url}?client_id={$clientid}&grant=basic&response_type=code&redirect_uri={$redir}\">OK, connect now!</a>";

        } else {  // If there is a code, it must be a callback from OAuth

            // No time to loose! Quickly trade the code for a Token, before it gets invalid.
            // We need to send some data in a POST request for that.

            // Preparing post data:

            // your secret data to make sure, it is you
            $fields["client_id"] = $clientid;
            $fields["client_secret"] = $clientsecret;

            // This must be the same as the previous redirect uri
            $fields["redirect_uri"] = $redirect_uri;

            // This is the actual trade. We tell OAuth what we want and provide the code.
            $fields["grant_type"] = "authorization_code";
            $fields["code"] = $_GET["code"];

            // We use curl to make the request
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL, $token_url);
            curl_setopt($curl,CURLOPT_POST, sizeof($fields));
            curl_setopt($curl,CURLOPT_POSTFIELDS, $fields);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close ($curl);

            echo "<h1>My fancy web service</h1>";
            echo "<h2>This is the result of the OAuth process:</h2>";

            // The final $result contains the access_token and some other information besides.
            // For you to see it, we dump it out here.
            var_dump($result);

            // Make sure to store the access_token in order to control the users REST API!
        }
    }
}
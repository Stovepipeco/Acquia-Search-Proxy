Search proxy
======

Allows search proxying against Acquia Search. Also provides method for
testing search queries.


Configuration
-------------

Update default settings in settings-search-proxy.php.  Fill in the acquia_identifier and derived_key to allow searching.
If these settings are omitted or incorrect you will get Access Denied 403 errors.

// Optionally set to 'stage' or 'prod'.  This is a fallback default if not defined in URL and is used for CLI.
$env = 'prod';

$sdefaults = array(
  'prod' => array(
    'acquia_identifier' => 'GTWX-10000', // The Acquia account identifier. e.g. GTWX-10000
    'derived_key' => 'some_hash_generated', // The derived_key is NOT your Acquia key and needs to be generated using the drush line below.
    'host' => 'search.acquia.com', // The host that Acquia solr is located.  This could be the same for both environments (can be found using drush line below).
    'node_access' => TRUE, // Add filter for only content available to anonymous users.
  ),
);

/*
 * Please execute the following commands for you environment:
 *   [acquia_identifier] -- drush vget acquia_identifier
 *   [derived_key] -- drush php-eval 'echo _acquia_search_derived_key();'
 *   [host] -- drush solr-get-env-url
 *     - Set to domain name only! Example: http://[DOMAIN_NAME]/solr/GTWX-100000
 */


Usage
-----

http://localhost/search-proxy.php/stage/select?q=test // Query stage environment.
http://localhost/search-proxy.php/prod/select?q=test // Query production environment.
http://localhost/search-proxy.php/select?q=test // Query environment set in settings-search-proxy.php ($env)

* select - the operation to perform against Acquia Search.
* q - the query to run against Acquia Search.

Example uses in CLI (command-line interface) - uses environment set in settings-search-proxy.php ($env):

    PATH_INFO="/admin/ping" php search-proxy.php
    PATH_INFO="/admin/luke" QUERY_STRING="show=schema" php search-proxy.php
    PATH_INFO="/select" QUERY_STRING="q=foo" php search-proxy.php


Example
-------

http://localhost/search-proxy.php/prod/select?q=test
    
    <response>
      <lst name="responseHeader">
        <int name="status">0</int>
        <int name="QTime">2</int>
        <lst name="params">
          <str name="request_id">4f2c136fe61a0</str>
          <str name="q">test</str>
        </lst>
      </lst>
      <result name="response" numFound="0" start="0"/>
      <lst name="highlighting"/>
    </response>
    

Extras
------
Command to download all the solr configuration files from the server (doesn't support directories):

    PATH_INFO="/admin/file" QUERY_STRING="contentType=text/xml;charset=utf-8" php search-proxy.php | grep -o 'lst name="[^"]*' | tail -n +3 | cut -d\" -f2 | xargs -L1 -I% sh -c 'PATH_INFO="/admin/file" QUERY_STRING="contentType=text/xml;charset=utf-8&file=%" php search-proxy.php | tee %'


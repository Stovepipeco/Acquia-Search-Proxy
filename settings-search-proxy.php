<?php

// Optionally set to 'stage' or 'prod'.  This is a fallback default if not defined in URL and is used for CLI.
$env = 'prod';

/**
 * 'acquia_identifier' - The Acquia account identifier. e.g. GTWX-10000
 * 'derived_key' - The derived_key is NOT your Acquia key and needs to be generated using the drush line below.
 * 'host' - The host that Acquia solr is located.  This could be the same for both environments
 * 'node_access' => Add filter for only content available to anonymous users.
 *
 * Please execute the following commands for you environment:
 *   [acquia_identifier] -- drush vget acquia_identifier
 *   [derived_key] -- drush php-eval 'echo _acquia_search_derived_key();'
 *   [host] -- drush solr-get-env-url
 *     - Set to domain name only! Example: http://[DOMAIN_NAME]/solr/GTWX-100000
 */
$sdefaults = array(
  'stage' => array(
    'acquia_identifier' => '',
    'derived_key' => '',
    'host' => '',
    'node_access' => FALSE,
  ),
  'prod' => array(
    'acquia_identifier' => '',
    'derived_key' => '',
    'host' => '',
    'node_access' => FALSE,
  ),
);

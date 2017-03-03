<?php

return array(
  'extension_name'         => 'Sirateck_Lemonway4ec',
  'summary'                => 'A 1 minute integration for the cheapest payment solution in Europe.Accept payment by credit cards from all around the world.',
  'description'            => 'Through its API, Lemon Way offers you state-of-the-art payment technology. Beyond their technological expertise, Lemon Way also offers a multitude of complementary regulation and management services.',
  'notes'                  => '',
  'extension_version'      => '0.1.0',
  'skip_version_compare'   => false,
  'auto_detect_version'    => true,

  'stability'              => 'stable',
  'license'                => 'http://opensource.org/licenses/mit-license.php MIT licence',
  'channel'                => 'community',

  'author_name'            => 'Kassim Belghait',
  'author_user'            => 'Sirateck',
  'author_email'           => 'kassim@sirateck.com',

  'base_dir'               => __DIR__.'/dist',
  'archive_files'          => 'package.tar',
  'path_output'            => __DIR__.'/dist',

  'php_min'                => '5.2.0',
  'php_max'                => '6.0.0',

  'extensions'             => array()
);

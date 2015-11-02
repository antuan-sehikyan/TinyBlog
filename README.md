ZF2 Tiny Blog Module + Doctrine Example
======================================

##Introduction

This is a ZF2 Tiny Blog Module using [DoctrineModule](https://github.com/doctrine/DoctrineModule) + 
[CkEditor](http://ckeditor.com/download) + 
[Htmlpurifier](http://htmlpurifier.org/) Integration with 
[Soflomo](https://github.com/Soflomo/Purifier) Module. 

##Installation Using Composer

The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies:

    curl -s https://getcomposer.org/installer | php --

You would then invoke `composer` to install dependencies. Add to your composer.json

	"ledsinclouds/tiny-blog": "dev-master"        
        
##Required Modules

	"doctrine/doctrine-module": "0.*",  
	"doctrine/doctrine-orm-module": "0.*",	
	"soflomo/purifier": "dev-master",
	"soflomo/common": "dev-master",	
	"rwoverdijk/assetmanager": "1.*"
	        
##Configuration

Once module installed, you could declare the module into your __"config/application.config.php"__ by adding: 
	
        'Application',	
        'DoctrineModule',
		'DoctrineORMModule',
		'Soflomo\\Purifier',
		'Soflomo\\Common'
        'AssetManager', 				         	
		'TinyBlog',

Copy/Paste the configuration file and change configuration options according to your social accounts.
Note: You must create applications for that...

    cp vendor/ledsinclouds/album/config/doctrine.local.php.dist config/autoload/doctrine.local.php
	
##Create your Database:

	./vendor/bin/doctrine-module orm:validate-schema
	./vendor/bin/doctrine-module orm:schema-tool:update --force

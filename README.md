Digital NZ Set
================================================================================

Created By
-----------------------------------------------
Haunt Digital
hauntdigital.co.nz

Requirements
-----------------------------------------------
SilverStripe 3+

Documentation
-----------------------------------------------
A Silverstripe module for interacting with Digital NZ sets via the Digital NZ API.
This currently only has functions for working with Digital NZ sets.

The previously committed config.yml has been removed so that the Digital NZ tab doesn't automatically appear on every subsite.
It will have to be manually added in to the site/subsite's config.yml file.

Installation Instructions
-----------------------------------------------
1. Install SilverStripe module as usual. 
2. Add the following to your config so that the 'Digital NZ' tab appears. 
    SiteConfig:
      extensions:
       - DigitalNZSetSiteConfig
2. Run /dev/build?flush=1
3. In the admin/settings page you should have a tab for 'Digital NZ'.
4. Enter your Digital NZ API key into the form. 
5. Set subsites module usage for this site. 

Basic Usage
-----------------------------------------------
Once your module has been configured, you can use the module in any of your classes. To do this simply put 'YourClassName_Controller::add_extension('DigitalNZ');' into your _config.php file. 
This will allow you to call functions from the DigitalNZ module as if they were on your class, ie $this->getSet($set). 

The module has 3 basic functions, they are as following:

1. getSet($set)
   -----------------------------------------------
   This function expects to be passed the id of a DigitalNZ set, it will look something like this: 541907321257572a3c000001. 
   This function will return the id, name, count, priority, homepage, approved, created_at, updated_at, record, description, privacy and tags of that particular set. 
   
2. getSetRecords($set, $limit = NULL)
   -----------------------------------------------
   This function expects to be passed the id of a DigitalNZ set, it will look something like this: 541907321257572a3c000001.
   This function will return the record_id, position, title, description, large_thumbnail_url, thumbnail_url, display_content_partner, contributing_partner, display_collection, landing_url, category, date, dnz_type, dc_identifier, dc_creator for all of the records which belong to that set.
   You can also pass it an integer if you wish to set a limit on the number of records that it will return, ie 5. 
   
3. convertUrlToSetID($url)
   ----------------------------------------------- 
   This function will convert a url into a set id, it is expecting to be passed a url which looks like this: http://www.digitalnz.org/user_sets/541907321257572a3c000001.
   This will return the id from the url, ie 541907321257572a3c000001.
   You can then use this in conjunction with the getSet or getSetRecords functions. 
   If any other URL instances occur these will need to be added to the preg_match patterns and replacements array. 
   
   When calling these functions in your controller, make sure that your functions return an ArrayList.
   

Using Digital NZ Set with the Subsites module
-----------------------------------------------
This module works with or without the Subsites module by configuring it in the Digital NZ tab.
There is a subsiteCheck function wrapped around every function to check if the subsite module is in use. If so, it then does the recommended subsite check. 
It's not be best way of doing things but it seems to be the way of the subsite (and subsite-related) module.

   
THANK YOU
-----------------------------------------------
For using our module :). 

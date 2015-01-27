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

This module is meant to be used with the subsites module as it was initially produced for the First World War site that is to go to MoE's CWP, 
and they are using the subsites module in a strange way - that is they have sompletely different sites using the subsites module.
Make sure to note Installation Instruction #2 if you're not using the subsites module.

If you are using the subsites module, please note Installation Instruction #3.

Installation Instructions
-----------------------------------------------
1. Install SilverStripe module as usual. 
2. If you're using this module on an install that doesn't use the subsites module, Remove the line below in the DigitalNZSetSiteConfig.php file. R
Remove the closing curly brace for it as well.
    (line 31)
    if (SubSiteConfig::display('DigitalNZ', 'display')) {
3. If you're using subsites, make sure to add your subsite constant to the config.yml file in this module under DigitalNZ > Display.    
4. Run /dev/build?flush=1
5. In the admin/settings page you should have a tab for 'Digital NZ'.
6. Enter your Digital NZ API key into the form. 
7. Set subsites module usage for this site. 

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

To get the Digital NZ tab to not automatically display in every subsite, I've had to add some yucky code. Docs and install instructions have been laid out.
There might be a better way to do this but there no time or budget at present to pursue this. 

   
THANK YOU
-----------------------------------------------
For using our module :). 

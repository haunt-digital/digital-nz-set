<?php

/**
 * Class DigitalNZSiteConfig
 * CMS configurable items related to the Digital NZ Set module.
 * Makes the Digital NZ tab appear in the settings area of the admin interface and displays the fields specified below.
 * 
 * Requires users to have developer access to modify.
 */
class DigitalNZSetSiteConfig extends DataExtension implements PermissionProvider
{

    private static $db = array(
        'DigitalNZApiKey' => 'Text',
    		'UseWithSubsite' => 'Boolean',      // false             # true | false
    );

    private static $defaults = array(
    		'UseWithSubsite' => 0,
    );		

    /**
     * @param FieldList $fields
     * 
     * Adds a tab to the SilverStripe CMS settings that allows the user to input Digital NZ related settings.
     */
    public function updateCMSFields(FieldList $fields) {
    	
    	// Check to see if this is used with subsites
    	if (DigitalNZSetSiteConfig::subsiteCheck()) {

        	$fields->removebyName('SubsiteID');
        	
        	$digitalNZ = $fields->findOrMakeTab('Root.DigitalNZ');
        	$digitalNZ->title = 'Digital NZ';
        	
        	$digitalNZ->push($digitalNZApiKey = new TextField('DigitalNZApiKey', 'Digital NZ Api Key'));
        	$digitalNZApiKey->setDescription('The Digital NZ api key to use.');
        	
        	$digitalNZ->push($useWithSubsite = new OptionsetField("UseWithSubsite", "Use with Subsites?", array("1" => "Yes", "0" => "No",), "0"));
        	$useWithSubsite->setDescription("Select 'Yes' if you're using subsites in this installation so that the Digital NZ set module is limited to a subsite.");
        	
        	// Make sure only a developer can change this value
        	if (!Permission::check('DIGITALNZ_DEVELOPER_EDIT')) {
        		$fields->makeFieldReadonly('SubSiteConstant');
        	}
        	
        	return $fields;
    	}   	  	

    }

    /**
     *
     * Make sure only devs can change these values.
     *
     * @return array
     */
    public function providePermissions()
    {
    	return array(
    			'DIGITALNZ_DEVELOPER_EDIT' => array(
    					'name' => 'Edit developer settings',
    					'category' => 'Developer Specific Settings'
    			),
    	);
    }
    
    public function canEdit($member = null)
    {
    	return Permission::check('DIGITALNZ_DEVELOPER_EDIT');
    }    
    
    /**
     * Allows this module to work with and without the subsite module.
     * Check Digital NZ site config to see if this is using subsites and if so, do a subsite check as specified in the subsites doc.
     * 
     * @return boolean
     */
    public function subsiteCheck() {
    	if (SiteConfig::current_site_config()->UseWithSubsite) {
    		return SubSiteConfig::display('ClassName', 'display');
    	}
    	return true;
    }

}
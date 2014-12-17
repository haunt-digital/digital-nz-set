<?php

/**
 * Class DigitalNZSet
 * This is used for performing basic interactions with the DigitalNZ api.
 */

class DigitalNZSet extends DataExtension {

    /**
     * This function gets all the information about a specific set.
     * It is expecting to be passed the set id.
     * @param $set
     * @return array
     */
    public function getSet($set) {
        if (DigitalNZSetSiteConfig::subsiteCheck()) {
            if ($set) {
                
                $set_content = array();
                $api_key = SiteConfig::current_site_config()->DigitalNZApiKey;

                if($api_key) {

                    $url = 'http://api.digitalnz.org/v3/sets/' . $set . '.json?api_key=' . $api_key;

                    $process = curl_init($url);
                    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
                    $return = curl_exec($process);
                    $collection = json_decode($return);

                    if(isset($collection->errors)) {
                        echo $collection->errors;
                    } else {
                        $set_content['id'] = $collection->set->id;
                        $set_content['name'] = $collection->set->name;
                        $set_content['count'] = $collection->set->count;
                        $set_content['priority'] = $collection->set->priority;
                        $set_content['homepage'] = $collection->set->homepage;
                        $set_content['approved'] = $collection->set->approved;
                        $set_content['created_at'] = $collection->set->created_at;
                        $set_content['updated_at'] = $collection->set->updated_at;
                        $set_content['record'] = $collection->set->record->record_id;
                        $set_content['description'] = $collection->set->description;
                        $set_content['privacy'] = $collection->set->homepage;
                        $set_content['tags'] = $collection->set->tags;
                    }
                } else {
                    error_log("You are missing the API Key, this can be set up in the admin/settings of your subsite.", 0);
                }

                return $set_content;

            } else {
                error_log("This function requires a set id.", 0);
            }
        }
    }

    /**
     * This function gets all of the records from a set.
     * It is expecting to be passed the set id.
     * You can also pass a limit to this function if you want to limit the amount of results that are returned.
     * @param $set
     * @param $limit
     * @return array
     */
    public function getSetRecords($set, $limit = NULL) {
    		if (DigitalNZSetSiteConfig::subsiteCheck()) {
            if ($set) {

                $records = array();
                $api_key = SiteConfig::current_site_config()->DigitalNZApiKey;

                if($api_key) {

                    $url = 'http://api.digitalnz.org/v3/sets/' . $set . '.json?api_key=' . $api_key;
                    $process = curl_init($url);
                    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
                    $return = curl_exec($process);
                    $collection = json_decode($return);

                    if(isset($collection->errors)) {
                        echo $collection->errors;
                    } else {
                        $i = 0;
                        foreach ($collection->set->records as $r) {

                            if ($limit) {
                                if ($i == $limit) {
                                    break;
                                }
                            }

                            $records[$i]['record_id'] = $r->record_id;
                            $records[$i]['position'] = $r->position;
                            $records[$i]['title'] = $r->title;
                            $records[$i]['description'] = $r->description;
                            $records[$i]['large_thumbnail_url'] = $r->large_thumbnail_url;
                            $records[$i]['thumbnail_url'] = $r->thumbnail_url;
                            $records[$i]['display_content_partner'] = $r->display_content_partner;
                            $records[$i]['contributing_partner'] = $r->contributing_partner;
                            $records[$i]['display_collection'] = $r->display_collection;
                            $records[$i]['landing_url'] = $r->landing_url;
                            $records[$i]['category'] = $r->category;
                            $records[$i]['date'] = $r->date;
                            $records[$i]['dnz_type'] = $r->dnz_type;
                            $records[$i]['dc_identifier'] = $r->dc_identifier;
                            $records[$i]['dc_creator'] = $r->creator;

                            $i++;
                        }
                    }
                } else {
                    error_log('You are missing the API Key, this can be set up in the admin/settings of your subsite.', 0);
                }

                return $records;

            } else {
                error_log('This function requires a set id.', 0);
            }
        }
    }

    /**
     * This function is used to convert a url into a Set ID.
     * It is expecting to be passed a url that looks like this.
     * http://www.digitalnz.org/user_sets/541907321257572a3c000001
     * @param $url
     * @return int
     */
    public function convertUrlToSetID($url) {
    		if (DigitalNZSetSiteConfig::subsiteCheck()) {
            $patterns = array();

            $patterns[0] = '/http:/';
            $patterns[1] = '/https:/';
            $patterns[2] = '/www.digitalnz.org/';
            $patterns[3] = '/user_sets/';
            $patterns[4] = '/\//';

            $replacements = array();

            $replacements[0] = '';
            $replacements[1] = '';
            $replacements[2] = '';
            $replacements[3] = '';
            $replacements[4] = '';

            $id = preg_replace($patterns, $replacements, $url);

            return $id;
        }
    }

} 
<?php

		################################################
		#                                              #
		#    DPortal CMS, CMS without Database engine  #
		#                                              #
		#  XML Sitemap generator from Sections         #
		#  and others thinks (sitemap.php)             #
		#                                              #
		#  Copyright (c) Davod.                        #
		#                                              #
		#  This program is published under the         #
		#  GNU General Public License                  #
		#                                              #
		#  Please see README and LICENSE for details   #
		#                                              #
		################################################

function getentries_sitemap(){

	$handle = fopen(ENTRIES_PATH.'.entries', "rb");
	while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
		if($data[0] != null && file_exists(ENTRIES_PATH . $data[0])){
			$entries[] = array('name'=>$data[1],'title'=>$data[2],'published'=>$data[5],'updated'=>filemtime(ENTRIES_PATH . $data[0]));
		}
	}
	fclose($handle);

	if($entries != null){
		krsort($entries);
		
		foreach($entries as $item){
			$entries_ordered[] = array('name'=>$item['name'],'title'=>$item['title'],'updated'=>$item['updated'],'published'=>$item['published']);
		}
		
		return $entries_ordered;
	}else return null;
}

?>

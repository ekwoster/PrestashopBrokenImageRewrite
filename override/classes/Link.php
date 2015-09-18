<?php
/*
	Author: Evgeniy Kozachenko
	Github: https://github.com/kozachenko/PrestashopBrokenImageRewrite
	Moreinfo: http://htmler.ru/?p=2430
 */
class Link extends LinkCore{
	
	public function getImageLink($name, $ids, $type = null)
	{
		global $protocol_content;
		
		if (empty($protocol_content))
			$protocol_content = _PS_SSL_ENABLED_ ? 'https://' : 'http://';

		// legacy mode or default image
		if ((Configuration::get('PS_LEGACY_IMAGES') 
			&& (file_exists(_PS_PROD_IMG_DIR_.$ids.($type ? '-'.$type : '').'.jpg')))
			|| strpos($ids, 'default') !== false)
		{
			// if ($this->allow == 1)
			// 	$uri_path = __PS_BASE_URI__.$ids.($type ? '-'.$type : '').'/'.$name.'.jpg';
			// else
			// 	$uri_path = _THEME_PROD_DIR_.$ids.($type ? '-'.$type : '').'.jpg';
			$uri_path = _THEME_PROD_DIR_.$ids.($type ? '-'.$type : '').'.jpg';
		}else
		{
			// if ids if of the form id_product-id_image, we want to extract the id_image part
			$split_ids = explode('-', $ids);
			$id_image = (isset($split_ids[1]) ? $split_ids[1] : $split_ids[0]);
			
			// if ($this->allow == 1)
			// 	$uri_path = __PS_BASE_URI__.$id_image.($type ? '-'.$type : '').'/'.$name.'.jpg';
			// else
			// 	$uri_path = _THEME_PROD_DIR_.Image::getImgFolderStatic($id_image).$id_image.($type ? '-'.$type : '').'.jpg';
			$uri_path = _THEME_PROD_DIR_.Image::getImgFolderStatic($id_image).$id_image.($type ? '-'.$type : '').'.jpg';
		}
		
		return $protocol_content.Tools::getMediaServer($uri_path).$uri_path;
	}

}
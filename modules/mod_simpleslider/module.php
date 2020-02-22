<?php
function mod_simpleslider($module_id){
    $inCore = cmsCore::getInstance();
    $inDB = cmsDatabase::getInstance();

    $cfg = $inCore->loadModuleConfig($module_id);

    global $_LANG;
		
    if($cfg['sort']=='rating') { $orderby = 'rating DESC'; }
    elseif($cfg['sort']=='hits') { $orderby = 'hits DESC'; }
    else{ $orderby = 'id DESC'; }

    if ($cfg['cat_id']>0){

        if (!$cfg['subs']){
            //select from category
            $catsql = ' AND i.category_id = '.$cfg['cat_id'];
        } else {
            //select from category and subcategories
            $rootcat  = $inDB->get_fields('cms_uc_cats', 'id='.$cfg['cat_id'], 'NSLeft, NSRight');
            $catsql   = "AND (c.NSLeft >= {$rootcat['NSLeft']} AND c.NSRight <= {$rootcat['NSRight']})";
        }

    } else {
            $catsql = '';
    }

    $sql = "SELECT i.* , IFNULL(AVG( r.points ), 0) AS rating, c.view_type as viewtype
                    FROM cms_uc_items i
                    LEFT JOIN cms_uc_cats c ON c.id = i.category_id
    LEFT JOIN cms_uc_ratings r ON r.item_id = i.id
                    WHERE i.published = 1 $catsql
                    GROUP BY i.id
                    ORDER BY $orderby 
                    LIMIT ".$cfg['num'];

    $result = $inDB->query($sql);
		
    $items = array();
    $is_uc = false;
		
    if ($inDB->num_rows($result)){
        $inCore->includeFile('components/catalog/includes/shopcore.php');
        $is_uc = true;
    
        while($item = $inDB->fetch_assoc($result)){
            $item['fieldsdata'] = unserialize($item['fieldsdata']);
            $item['title'] = substr($item['title'], 0, 40);

            for($f = 0; $f<$cfg['showf']; $f++){
                $item['fdata'][] = $inCore->getUCSearchLink($item['category_id'], null, $f, $item['fieldsdata'][$f]);
            }						

            $item['key'] = $_LANG['UC_POPULAR_VIEWS'].': <a href="/catalog/item'.$item['id'].'.html" title="'.$_LANG['UC_POPULAR_VIEWS'].'">'.$item['hits'].'</a>'; 


            $item['fdate'] = $inCore->dateFormat($item['fdate']);
            if ($item['viewtype']=='shop'){
                $item['price'] = number_format(shopDiscountPrice($item['id'], $item['category_id'], $item['price']), 2, '.', ' ');
            }
            
            $item['title'] = addslashes($item['title']);	
							
            $items[] = $item;
        }				
    }

    $smarty = $inCore->initSmarty('modules', 'mod_simpleslider.tpl');			
    $smarty->assign('items', $items);
    $smarty->assign('cfg', $cfg);
    $smarty->assign('is_uc', $is_uc);			
    $smarty->display('mod_simpleslider.tpl');

    return true;
		
}
?>
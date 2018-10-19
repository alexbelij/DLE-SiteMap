<?php

/*
=============================================================================
 ����: sitemap.php (frontend) ������ 2.2
-----------------------------------------------------------------------------
 �����: ����� ��������� ����������, mail@mithrandir.ru
-----------------------------------------------------------------------------
 ���� ���������: http://alaev.info/blog/post/1974
-----------------------------------------------------------------------------
 ��������� ������, ������������ ����� �� tpl ��� �������:
    * need_cats     - ������ id ��������� ����� ������� ��� ������ � �����
    * exc_cats      - ������ id ��������� ����� �������, ����������� �� �����
    * need_news     - ������ id ������ ����� ������� ��� ������ � �����
    * exc_news      - ������ id ������ ����� �������, ����������� �� �����
    * need_static   - ������ id ����������� ������� ����� ������� ��� ������ � �����
    * exc_static    - ������ id ����������� ������� ����� �������, ����������� �� �����
    * cats_as_links - ���������� �������� ��������� ��� ������ (1 ��� 0)
    * show_static   - ���������� � ����� ����������� �������� (1 ��� 0)
    * cats_sort     - ���� ���������� ������ ���������
    * cats_msort    - ����������� ���������� ������ ���������
    * news_sort     - ���� ���������� ������ ������
    * news_msort    - ����������� ���������� ������ ������
    * static_sort   - ���� ���������� ������ ����������� �������
    * static_msort  - ����������� ���������� ������ ����������� �������
    * cats_limit    - ������������ ���������� ��������� ������������
    * news_limit    - ������������ ���������� ��������� ������ �� ���������
    * static_limit  - ������������ ���������� ��������� ����������� �������
-----------------------------------------------------------------------------
 �������� CSS ������� ����� �����:
    .sitemap_categories         - ������� <ul> ������ ���������
    .sitemap_categories li      - ������� <li> ������ ���������
    .sitemap_items              - ������� <ul> ������ ������
    .sitemap_items li           - ������� <li> ������ ������
    .sitemap_static_pages       - ������� <ul> ������ ����������� �������
    .sitemap_static_pages li    - ������� <li> ������ ����������� �������

    .root - ����� ��� ����������������� ���������, ����������� � ����� ������
    
    .sitemap_categories a       - ������� <a> c ��������� ���������
    .sitemap_categories span    - ������� <span> c ��������� ���������
    .sitemap_items a            - ������� <a> c ��������� ������
    .sitemap_static_pages a     - ������� <a> c ��������� ����������� ��������
-----------------------------------------------------------------------------
 ����������: ����� ����� �����
=============================================================================
*/
    // ���������
    if( ! defined( 'DATALIFEENGINE' ) ) {
            die( "Hacking attempt!" );
    }

    /*
     * ����� ��� �������� ����� �����
     */
    class Sitemap
    {
        /*
         * ����������� ������ Sitemap - ����� �������� dle_api � sitemap_config � _time
         * @param $dle_api - ������ ������ DLE_API
         * @param $sitemap_config - ������ � ������������� ������
         * @param $_TIME - ����� � UNIX ������� � ������ �������� �������� � ���������� �������
         */
        public function __construct($dle_api, $sitemap_config, $_TIME)
        {
            // ���������� ������ DLE API
            $this->dle_api = $dle_api;

            // ������� ����� � UNIX ������� � ������ �������� �������� � ���������� �������
            $this->_time = $_TIME;

            // ������������ ������
            $this->sitemap_config = $sitemap_config;
        }


        /*
         * ����� ���������� ������ ������, ��������� � ����������� ������� �� �����
         * @return string
         */
        public function tree()
        {
            // � ���������� $site_tree ����� ������ ���������
            $site_tree = '';

            // ���������� ��� ������ �� �����
            $site_tree .= $this->show_cat_items(0);

            // ���������� ������� ��� ���������, ������������ � ��������� � ��� ������
            $site_tree .= $this->show_cats(0);

            // ���� � ���������� ������ ������������� ����� ����������� �������, ������� ��
            if($this->sitemap_config['show_static'])
            {
                $site_tree .= $this->show_static();
            }

            // ��������
            $site_tree .= '<div style="display: block !important; text-align: right !important;"><a style="display: inline !important;" href="http://alaev.info/blog/post/1974?from=SiteMap">DLE SiteMap by alaev.info</a></div>';

            // ���������� ���������
            return $site_tree;
        }


        /*
         * ����� ��� ����������� ���� ������������ � ������ ���������
         * @param $parent_id - ������������� ���������-��������
         * @return string
         */
        public function show_cats($parent_id)
        {
            // � ���������� $cats_html ����� ������ ���������� ���������� ��� ������
            $cats_html = '';

            // �������� ��� ������������ ������ ���������
            $cats = $this->take_cats($parent_id);

            if($cats)
            {
                // ��������� ����
                $cats_html = '<ul class="sitemap_categories'.(($parent_id == 0)?' root':'').'">';

                // ���������� ��� ��������� �� ������� ���������
                foreach($cats as $cat)
                {
                    // ��������� ���� ���������
                    $cats_html .= '<li'.(($parent_id == 0)?' class="root"':'').'>';

                    // ���� ���������� �������� cats_as_links, ���������� ������ �� ���������, ���� ��� - ������ ��������� ������������
                    if($this->sitemap_config['cats_as_links'])
                    {
                        $cats_html .= '<a href="'.$this->create_cat_url($cat).'">'.stripslashes($cat['name']).'</a>';
                    }
                    else
                    {
                        $cats_html .= '<span>'.stripslashes($cat['name']).'</span>';
                    }
                    

                    // ������� ������ �� ���������
                    $cats_html .= $this->show_cat_items($cat);

                    // ������� ������������
                    $cats_html .= $this->show_cats($cat['id']);

                    // ��������� ����
                    $cats_html .= '</li>';
                }

                // ��������� ����
                $cats_html .= '</ul>';
            }
            
            // ���������� ���������
            return $cats_html;
        }


        /*
         * ����� ��� ����������� ���� ������ � ������ ���������
         * @param $cat - ������ � ����������� � ��������� - ��������� ��� ��������� ���������� ���������� ������
         * @return string
         */
        public function show_cat_items($cat)
        {
            // id ���������
            $cat_id = intval($cat['id']);
            
            // � ���������� $items_html ����� ������ ���������� ���������� ��� ������
            $items_html ='';
            
            // �������� ��� ������ �� ������ ���������
            $items = $this->take_cat_items($cat);

            if($items)
            {
                // ��������� ����
                $items_html = '<ul class="sitemap_items'.(($cat_id == 0)?' root':'').'">';

                // ���������� ��� ������
                foreach($items as $item)
                {
                    $items_html .= '<li'.(($cat_id == 0)?' class="root"':'').'>';
                    $items_html .= '<a href="'.$this->getPostUrl($item).'">'.stripslashes($item['title']).'</a>';
                    $items_html .= '</li>';
                }

                // ��������� ����
                $items_html .= '</ul>';
            }

            // ���������� ���������
            return $items_html;
        }


        /*
         * ����� ��� ����������� ���� ����������� ������� � �����
         * @return string
         */
        public function show_static()
        {
            // � ���������� $static_html ����� ������ ���������� ���������� ��� ������
            $static_html ='';

            // �������� ��� ����������� �������� �� ���� ������
            $static_pages = $this->take_static_pages();

            if($static_pages)
            {
                // ��������� ����
                $static_html = '<ul class="sitemap_static_pages root">';

                // ���������� ��� ����������� ��������
                foreach($static_pages as $static)
                {
                    $static_html .= '<li class="root">';
                    $static_html .= '<a href="'.$this->create_static_url($static).'">'.stripslashes($static['descr']).'</a>';
                    $static_html .= '</li>';
                }

                // ��������� ����
                $static_html .= '</ul>';
            }

            // ���������� ���������
            return $static_html;
        }


        /*
         * @param $parent_id - ������������� ���������-��������
         * @return array ���� ������������ �� ��������� ���������
         */
        public function take_cats($parent_id)
        {
            // ������ ������ ����� �� ������� � �����������
            $fields = 'id, name, alt_name, news_sort, news_msort';

            // ������� ������ ����� ������ � ������ $wheres
            $wheres = array();

            // ������� �� ����������� ��� ������ �������
            if(!empty($this->sitemap_config['need_cats']))
            {
                $wheres[] = 'id IN ('.$this->sitemap_config['need_cats'].')';
            }

            // ������� �� ����������� �� ������ �������
            if(!empty($this->sitemap_config['exc_cats']))
            {
                $wheres[] = 'id NOT IN ('.$this->sitemap_config['exc_cats'].')';
            }
            
            // ������� �� id ���������-��������
            $wheres[] = 'parentid = '.$parent_id;

            // ���������� ������� ������ � ������ $condition
            $condition = implode(' AND ', $wheres);

            // ���� � ������� ���������� - �� ������� sitemap_config
            $sort = $this->sitemap_config['cats_sort'];
            $sort_order = $this->sitemap_config['cats_msort'];

            // �����
            $limit = !empty($this->sitemap_config['cats_limit'])?$this->sitemap_config['cats_limit']:'';

            // ���������� ������ � �����������
            return $this->dle_api->load_table (PREFIX."_category", $fields, $condition, true, 0, $limit, $sort, $sort_order);
        }


        /*
         * ����� ���� �������������� �� ������ take_news DLE API
         * @param $cat - ������ � ����������� � ��������� - ��������� ��� ��������� ���������� ���������� ������
         * @return array ���� ������ �� ��������� $cat
         */
        public function take_cat_items($cat)
        {
            // id ���������
            $cat_id = intval($cat['id']);
            
            // ������ ������ ����� �� ������� �� ��������
            $fields = 'id, category, title, alt_name, date';
            $fields.= $this->dle_api->dle_config['version_id'] < 9.6?', flag':''; // ��� ������ dle �������� ���� flag

            // ������� ������ ����� ������ � ������ $wheres
            $wheres = array();

            // ������� �� ����������� ��� ������ �������
            if(!empty($this->sitemap_config['need_news']))
            {
                $wheres[] = 'id IN ('.$this->sitemap_config['need_news'].')';
            }

            // ������� �� ����������� �� ������ �������
            if(!empty($this->sitemap_config['exc_news']))
            {
                $wheres[] = 'id NOT IN ('.$this->sitemap_config['exc_news'].')';
            }

            // ������� ������ - id ��������� (� ����������� �� �������� ��������������� DLE)
            if ($this->dle_api->dle_config['allow_multi_category'] == 1)
            {
                $wheres[] = 'category regexp "[[:<:]]('.str_replace(',', '|', $cat_id).')[[:>:]]"';
            }
            else
            {
                $wheres[] = 'category = '.$cat_id;
            }

            // ������� ��� ����������� ������ ������, ��������� ���������
            $wheres[] = 'approve = 1';

            // ������� ��� ����������� ������ ��� ������, ���� ���������� ������� ��� ���������
            $wheres[] = 'date < "'.date("Y-m-d H:i:s", $this->_time).'"';

            // ���������� ������� ������ � ������ $condition
            $condition = implode(' AND ', $wheres);

            // ���� ���������� - �� ������� sitemap_config, �������� ������� ��������� ��� ���������� �������� DLE
            if(!empty($this->sitemap_config['news_sort']))
            {
                $sort = $this->sitemap_config['news_sort'];
            }
            elseif(!empty($cat['news_sort']))
            {
                $sort = $cat['news_sort'];
            }
            else
            {
                $sort = $this->dle_api->dle_config['news_sort'];
            }

            // ������� ���������� - �� ������� sitemap_config, �������� ������� ��������� ��� ���������� �������� DLE
            if(!empty($this->sitemap_config['news_msort']))
            {
                $sort_order = $this->sitemap_config['news_msort'];
            }
            elseif(!empty($cat['news_msort']))
            {
                $sort_order = $cat['news_msort'];
            }
            else
            {
                $sort_order = $this->dle_api->dle_config['news_msort'];
            }

            // �����
            $limit = !empty($this->sitemap_config['news_limit'])?$this->sitemap_config['news_limit']:'';

            // ���������� ������ � �����������
            return $this->dle_api->load_table (PREFIX."_post", $fields, $condition, true, 0, $limit, $sort, $sort_order);
        }


        /*
         * @return array ������ ���� ����������� ������� �� �����
         */
        public function take_static_pages()
        {
            // ������ ������ ����� �� ������� ����������� �������
            $fields = 'id, name, descr';

            // ������� ������ ����� ������ � ������ $wheres
            $wheres = array();

            // ������� �� ����������� ��� ������ �������
            if(!empty($this->sitemap_config['need_static']))
            {
                $wheres[] = 'id IN ('.$this->sitemap_config['need_static'].')';
            }

            // ������� �� ����������� �� ������ �������
            if(!empty($this->sitemap_config['exc_static']))
            {
                $wheres[] = 'id NOT IN ('.$this->sitemap_config['exc_static'].')';
            }

            // �������, ����� ����� ���������� ���� ������ �������� �������
            $wheres[] = 'date < '.$this->_time;

            // ���������� ������� ������ � ������ $condition
            $condition = implode(' AND ', $wheres);

            // ���� � ������� ���������� - �� ������� sitemap_config
            $sort = $this->sitemap_config['static_sort'];
            $sort_order = $this->sitemap_config['static_msort'];

            // �����
            $limit = !empty($this->sitemap_config['static_limit'])?$this->sitemap_config['static_limit']:'';

            // ���������� ������ � �����������
            return $this->dle_api->load_table (PREFIX."_static", $fields, $condition, true, 0, $limit, $sort, $sort_order);
        }


        /*
         * @param $cat - ������ � ����������� � ���������
         * @return string URL ��� ���������
         */
        public function create_cat_url($cat)
        {
			if($this->dle_api->dle_config['allow_alt_url'] && $this->dle_api->dle_config['allow_alt_url'] != "no")
            {
                $url = $this->dle_api->dle_config['http_home_url'].get_url($cat['id']).'/';
            }
            else
            {
                $url = $this->dle_api->dle_config['http_home_url'].'index.php?do=cat&category='.$cat['alt_name'].'/';
            }

            return $url;
        }


        /*
         * @param $post - ������ � ����������� � ������
         * @return string URL ��� ���������
         */
        public function getPostUrl($post)
        {
			if($this->dle_api->dle_config['allow_alt_url'] && $this->dle_api->dle_config['allow_alt_url'] != "no")
            {
                if(
                    ($this->dle_api->dle_config['version_id'] < 9.6 && $post['flag'] && $this->dle_api->dle_config['seo_type'])
                        ||
                    ($this->dle_api->dle_config['version_id'] >= 9.6 && ($this->dle_api->dle_config['seo_type'] == 1 || $this->dle_api->dle_config['seo_type'] == 2))
                )
                {
                    if(intval($post['category']) && $this->dle_api->dle_config['seo_type'] == 2)
                    {
                        $url = $this->dle_api->dle_config['http_home_url'].get_url(intval($post['category'])).'/'.$post['id'].'-'.$post['alt_name'].'.html';
                    }
                    else
                    {
                        $url = $this->dle_api->dle_config['http_home_url'].$post['id'].'-'.$post['alt_name'].'.html';
                    }
                }
                else
                {
                    $url = $this->dle_api->dle_config['http_home_url'].date("Y/m/d/", strtotime($post['date'])).$post['alt_name'].'.html';
                }
            }
            else
            {
                $url = $this->dle_api->dle_config['http_home_url'].'index.php?newsid='.$post['id'];
            }

            return $url;
        }


        /*
         * @param $static - ������ � ����������� � ����������� ��������
         * @return string  URL ��� ����������� ��������
         */
        public function create_static_url($static)
        {
			if($this->dle_api->dle_config['allow_alt_url'] && $this->dle_api->dle_config['allow_alt_url'] != "no")
            {
                $url = $this->dle_api->dle_config['http_home_url'].$static['name'].'.html';
            }
            else
            {
                $url = $this->dle_api->dle_config['http_home_url']."index.php?do=static&page=".$static['name'];
            }

            return $url;
        }
    }
    /*---End Of Sitemap Class---*/


    // ���������� DLE API
    include ('engine/api/api.class.php');
    
    // $site_tree - ������ ����� �����
    $site_tree = false;

    // ���� ����������� ��������, ������� �������� ���������� ������ �� ����
    if($dle_api->dle_config['allow_cache'] && $this->dle_api->dle_config['allow_cache'] != "no")
    {
        $site_tree = $dle_api->load_from_cache('site_tree');
    }

    // ���� � ���� ������ ���, ���������� ������
    if($site_tree === false)
    {
        // ������������ ������
        $sitemap_config = array();
        $sitemap_config['need_cats']        = !empty($need_cats)?$need_cats:false;
        $sitemap_config['exc_cats']         = !empty($exc_cats)?$exc_cats:false;
        $sitemap_config['need_news']        = !empty($need_news)?$need_news:false;
        $sitemap_config['exc_news']         = !empty($exc_news)?$exc_news:false;
        $sitemap_config['need_static']      = !empty($need_static)?$need_static:false;
        $sitemap_config['exc_static']       = !empty($exc_static)?$exc_static:false;
        $sitemap_config['cats_as_links']    = !empty($cats_as_links)?true:false;
        $sitemap_config['show_static']      = !empty($show_static)?true:false;
        $sitemap_config['cats_sort']        = !empty($cats_sort)?$cats_sort:'posi';
        $sitemap_config['cats_msort']       = !empty($cats_msort)?$cats_msort:'ASC';
        $sitemap_config['news_sort']        = !empty($news_sort)?$news_sort:false;
        $sitemap_config['news_msort']       = !empty($news_msort)?$news_msort:false;
        $sitemap_config['static_sort']      = !empty($static_sort)?$static_sort:'date';
        $sitemap_config['static_msort']     = !empty($static_msort)?$static_msort:'ASC';
        $sitemap_config['cats_limit']       = !empty($cats_limit)?$cats_limit:false;
        $sitemap_config['news_limit']       = !empty($news_limit)?$news_limit:false;
        $sitemap_config['static_limit']     = !empty($static_limit)?$static_limit:false;

        // ������ ������ $sitemap, ��������� ������������ ������ $dle_api, ������ $sitemap_config � ������������� ������ � $_TIME
        $sitemap = new Sitemap($dle_api, $sitemap_config, $_TIME);

        // �������� ������ �� ������� sitemap
        $site_tree = $sitemap->tree();

        // ���� ����������� ��������, ��������� ������ � ���
        if($dle_api->dle_config['allow_cache'] && $this->dle_api->dle_config['allow_cache'] != "no")
        {
            $dle_api->save_to_cache('site_tree', $site_tree);
        }
    }

	$canonical = false;

    // ���������� ���� ������� sitemap.tpl, ��������� ���
    $tpl = new dle_template();
    $tpl->dir = TEMPLATE_DIR;
    $tpl->load_template('sitemap.tpl');
    $tpl->set('{site_tree}', $site_tree);
    $tpl->compile('sitemap');

    // ������� ���������
    echo $tpl->result['sitemap'];
    
?>
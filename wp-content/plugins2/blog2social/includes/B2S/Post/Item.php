<?php

class B2S_Post_Item {

    protected $postData;
    protected $postTotal = 0;
    protected $postItem = '';
    protected $postPagination = '';
    protected $postPaginationLinks = 5;
    protected $searchAuthorId;
    protected $searchPostStatus;
    protected $searchShowByDate;
    protected $searchPublishDate;
    protected $searchSchedDate;
    protected $searchPostTitle;
    protected $searchPostCat;
    protected $searchPostType;
    protected $postCalendarSchedDates;
    public $currentPage = 0;
    public $type;

    function __construct($type = 'all', $title = "", $authorId = "", $postStatus = "", $publishDate = '', $schedDate = '', $showByDate = '', $currentPage = 0, $postCat = "", $postType = "") {
        $this->type = $type;
        $this->searchPostTitle = $title;
        $this->searchAuthorId = $authorId;
        $this->searchPostStatus = $postStatus;
        $this->searchPublishDate = $publishDate;
        $this->searchSchedDate = $schedDate;
        $this->searchShowByDate = $showByDate;
        $this->currentPage = $currentPage;
        $this->searchPostCat = $postCat;
        $this->searchPostType = $postType;
    }

    protected function getData() {
        global $wpdb;

        $addSearchAuthorId = '';
        $addSearchPostTitle = '';
        $order = 'post_date';
        $sortType = 'DESC';
        $leftJoin = "";
        $leftJoinWhere = "";
        if (!empty($this->searchPublishDate)) {
            $sortType = $this->searchPublishDate;
        }
        if (!empty($this->searchSchedDate)) {
            $sortType = $this->searchSchedDate;
        }
        if (!empty($this->searchPostTitle)) {
            $addSearchPostTitle = $wpdb->prepare(' AND `post_title` LIKE %s', '%' . trim($this->searchPostTitle) . '%');
        }
        if (!empty($this->searchAuthorId)) {
            $addSearchAuthorId = $wpdb->prepare(' AND `post_author` = %d', $this->searchAuthorId);
        }
        if (!empty($this->searchPostCat)) {
            if ($this->type == 'all') {
                $leftJoin = "LEFT JOIN wp_term_relationships ON $wpdb->posts.`ID` = wp_term_relationships.object_id";
            } else {
                $leftJoin = "LEFT JOIN wp_term_relationships ON posts.`ID` = wp_term_relationships.object_id";
            }
            $leftJoinWhere = 'AND wp_term_relationships.term_taxonomy_id = ' . $this->searchPostCat;
        }

        if (!empty($this->searchPostStatus)) {
            $addSearchType = $wpdb->prepare(' `post_status` = %s', $this->searchPostStatus);
        } else {
            $addSearchType = " (`post_status` = 'publish' OR `post_status` = 'pending' OR `post_status` = 'future') ";
        }


        $postTypes = " "; //`post_content` != ''
        if (!empty($this->searchPostType)) {
            $postTypes .= " `post_type` LIKE '%" . $this->searchPostType . "%' "; // AND
        } else {
            $post_types = get_post_types(array('public' => true));
            if (is_array($post_types) && !empty($post_types)) {
                $postTypes .= " `post_type` IN("; // AND
                foreach ($post_types as $k => $v) {
                    if ($v != 'attachment' && $v != 'nav_menu_item' && $v != 'revision') {
                        $postTypes .= "'" . $v . "',";
                    }
                }
                $postTypes = rtrim($postTypes, ',');
                $postTypes .= " ) ";
            } else {
                $postTypes .= " (`post_type` LIKE '%product%' OR `post_type` LIKE '%book%' OR `post_type` LIKE '%article%' OR `post_type` LIKE '%job%' OR `post_type` LIKE '%event%' OR `post_type` = 'post' OR `post_type` = 'page') ";
                // AND
            }
        }

        $addNotAdmin = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `post_author` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';
        $addNotAdminPosts = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `blog_user_id` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';

        if ($this->type == 'all') {
            $sqlPosts = "SELECT `$wpdb->posts`.`ID`,`post_author`,`post_date`,`post_type`,`post_status`, `post_title`
		FROM `$wpdb->posts` $leftJoin
		WHERE $addSearchType $addSearchAuthorId $addSearchPostTitle $addNotAdmin
                AND  $postTypes $leftJoinWhere
		ORDER BY `" . $order . "` " . $sortType . "
                LIMIT " . (($this->currentPage - 1) * B2S_PLUGIN_POSTPERPAGE) . "," . B2S_PLUGIN_POSTPERPAGE;
            $this->postData = $wpdb->get_results($sqlPosts);
            $sqlPostsTotal = "SELECT COUNT(*)
		FROM `$wpdb->posts` $leftJoin
		WHERE $addSearchType $addSearchAuthorId $addSearchPostTitle $addNotAdmin
                AND $postTypes $leftJoinWhere";
            $this->postTotal = $wpdb->get_var($sqlPostsTotal);
        }

        if ($this->type == 'publish' || $this->type == 'sched') {
            //ExistsTable
            if ($wpdb->get_var("SHOW TABLES LIKE 'b2s_posts'") == 'b2s_posts') {
                $where = ($this->type == 'publish') ? " `hide` = 0 AND `sched_date`= '0000-00-00 00:00:00' $addNotAdminPosts GROUP BY `post_id` ORDER BY `publish_date` " . $sortType : " `hide` = 0 AND `publish_date`= '0000-00-00 00:00:00' $addNotAdminPosts GROUP BY `post_id` ORDER BY `sched_date` " . $sortType;
                $orderBy = ($this->type == 'publish') ? " ORDER BY `publish_date` " . $sortType : " ORDER BY `sched_date` " . $sortType;
                $addSearchShowByDate = (!empty($this->searchShowByDate)) ? (($this->type == 'publish') ? " DATE_FORMAT(publish_date,'%Y-%m-%d') = '" . $this->searchShowByDate . "' AND " : " DATE_FORMAT(sched_date,'%Y-%m-%d') = '" . $this->searchShowByDate . "' AND ") : '';
                $select = ($this->type == 'publish') ? 'filter.`blog_user_id`, filter.`publish_date`' : 'filter.`blog_user_id`, filter.`sched_date`';
                $selectInnerJoin = ($this->type == 'publish') ? '`publish_date`' : '`sched_date`';
                $sqlPosts = "SELECT posts.`ID`, posts.`post_author`,posts.`post_type`,posts.`post_title`, " . $select . ", filter.`id`
                            FROM `$wpdb->posts` posts $leftJoin
                                INNER JOIN(
                                        SELECT `id`,$selectInnerJoin,`blog_user_id`, `post_id`
                                            FROM `b2s_posts`
                                                  WHERE $addSearchShowByDate $where
                                         ) filter
                                     ON posts.`ID` = filter.`post_id`
                             WHERE $addSearchType $addSearchAuthorId $addSearchPostTitle  AND $postTypes $leftJoinWhere $orderBy
                        LIMIT " . (($this->currentPage - 1) * B2S_PLUGIN_POSTPERPAGE) . "," . B2S_PLUGIN_POSTPERPAGE;

                $this->postData = $wpdb->get_results($sqlPosts);

                if ($this->type == 'publish') {
                    $sqlPostsTotal = "SELECT COUNT(posts.`ID`)
                            FROM `$wpdb->posts` posts $leftJoin
                                INNER JOIN(
                                        SELECT `post_id`
                                            FROM `b2s_posts`
                                                 WHERE $addSearchShowByDate $where
                                         ) filter
                                     ON posts.`ID` = filter.`post_id`
                             WHERE $addSearchType $addSearchAuthorId $addSearchPostTitle  AND $postTypes $leftJoinWhere";
                    $this->postTotal = $wpdb->get_var($sqlPostsTotal);

                    //for Calender (mark Event)
                } else {
                    $where = ($this->type == 'publish') ? " `hide` = 0 AND `sched_date`= '0000-00-00 00:00:00' $addNotAdminPosts ORDER BY `publish_date` " . $sortType : " `hide` = 0 AND `publish_date`= '0000-00-00 00:00:00' $addNotAdminPosts  ORDER BY `sched_date` " . $sortType;
                    $sqlPostsTotal = "SELECT posts.`ID`, DATE_FORMAT(filter.`sched_date`,'%Y-%m-%d') AS sched
                            FROM `$wpdb->posts` posts $leftJoin
                                INNER JOIN(
                                        SELECT `post_id`, `sched_date`
                                            FROM `b2s_posts`
                                                 WHERE $addSearchShowByDate $where
                                         ) filter
                                     ON posts.`ID` = filter.`post_id`
                             WHERE $addSearchType $addSearchAuthorId $addSearchPostTitle  AND $postTypes $leftJoinWhere";

                    $schedResult = $wpdb->get_results($sqlPostsTotal);
                    if (is_array($schedResult) && !empty($schedResult)) {
                        $this->postCalendarSchedDates = array();
                        $postIds = array();
                        foreach ($schedResult as $k => $v) {
                            if (!in_array($v->ID, $postIds)) {
                                $postIds[] = $v->ID;
                            }
                            if (!in_array($v->sched, $this->postCalendarSchedDates)) {
                                $this->postCalendarSchedDates[] = $v->sched;
                            }
                        }
                        $this->postTotal = count($postIds);
                    }
                }
            }
        }
    }

    public function getItemHtml() {
        $this->getData();
        $postStatus = array('publish' => __('published', 'blog2social'), 'pending' => __('draft', 'blog2social'), 'future' => __('scheduled', 'blog2social'));

        if (empty($this->postData)) {
            $text = __('You have no posts published or scheduled.', 'blog2social');
            return '<li class="list-group-item"><div class="media"><div class="media-body"></div>' . $text . '</div></li>';
        }

        foreach ($this->postData as $var) {
            $postType = 'post';
            if (strpos(strtolower($var->post_type), 'event') !== false) {
                $postType = 'event';
            }
            if (strpos(strtolower($var->post_type), 'job') !== false) {
                $postType = 'job';
            }
            
            //PostTitle - Bug: Converting json + PHP Extension
            $postTitle = $var->post_title;
            if(function_exists('mb_strlen') && function_exists('mb_substr')) {
               $postTitle =  (mb_strlen(trim($var->post_title),'UTF-8') > 80 ? mb_substr($var->post_title, 0, 77,'UTF-8') . '...' : $var->post_title); 
            }
            

            if ($this->type == 'all') {
                $userInfo = get_user_meta($var->post_author);
                $lastPublish = $this->getLastPublish($var->ID);
                $lastPublish = ($lastPublish != false) ? ' | ' . __('last shared on social media', 'blog2social') . ' ' . B2S_Util::getCustomDateFormat($lastPublish, substr(B2S_LANGUAGE, 0, 2)) : '';
                     
                $this->postItem .= '<li class="list-group-item">
                                <div class="media">
                                    <img class="post-img-10 pull-left hidden-xs" src="' . plugins_url('/assets/images/b2s/' . $postType . '-icon.png', B2S_PLUGIN_FILE) . '" alt="posttype">
                                        <div class="media-body">
                                                <strong><a target="_blank" href="' . get_permalink($var->ID) . '">' .$postTitle. '</a></strong>
                                            <span class="pull-right b2s-publish-btn">
                                                <a class="btn btn-success btn-sm publishPostBtn" href="admin.php?page=blog2social-ship&postId=' . $var->ID . '">' . __('Share on Social Media', 'blog2social') . '</a>
                                            </span>
                                            <p class="info hidden-xs">#' . $var->ID . ' | ' . __('Author', 'blog2social') . ' <a href="' . get_author_posts_url($var->post_author) . '">' . (isset($userInfo['nickname'][0]) ? $userInfo['nickname'][0] : '-') . '</a> | ' . $postStatus[trim(strtolower($var->post_status))] . ' ' . __('on blog', 'blog2social') . ': ' . B2S_Util::getCustomDateFormat($var->post_date, substr(B2S_LANGUAGE, 0, 2)) . $lastPublish . '</p>
                                        </div>
                                    </div>
                                </li>';
            }

            if ($this->type == 'publish') {
                $userInfo = get_user_meta($var->blog_user_id);
                $countPublish = $this->getPostCount($var->ID);
                $lastPublish = $this->getLastPost($var->ID);
                $this->postItem .= '<li class="list-group-item">
                                        <div class="media">
                                            <img class="post-img-10 pull-left hidden-xs" src="' . plugins_url('/assets/images/b2s/' . $postType . '-icon.png', B2S_PLUGIN_FILE) . '" alt="posttype">
                                                <div class="media-body">
                                                    <div class="pull-left media-nav">
                                                            <strong><a target="_blank" href="' . get_permalink($var->ID) . '">' . $postTitle . '</a></strong>
                                                        <span class="pull-right">
                                                        <a class="btn btn-success hidden-xs btn-sm" href="admin.php?page=blog2social-ship&postId=' . $var->ID . '">' . __('Re-share this post', 'blog2social') . '</a>
                                                            <button type="button" class="btn btn-primary btn-sm b2sDetailsPublishPostBtn" data-search-date="' . $this->searchShowByDate . '" data-post-id="' . $var->ID . '"><i class="glyphicon glyphicon-chevron-down"></i> ' . __('Details', 'blog2social') . '</button>
                                                        </span>
                                                        <p class="info hidden-xs"><a class="b2sDetailsPublishPostTriggerLink" href="#"><span class="b2s-publish-count" data-post-id="' . $var->ID . '">' . $countPublish . '</span> ' . __('shared social media posts', 'blog2social') . '</a> | ' . __('latest share by', 'blog2social') . ' <a href="' . get_author_posts_url($var->blog_user_id) . '">' . (isset($userInfo['nickname'][0]) ? $userInfo['nickname'][0] : '-') . '</a> ' . B2S_Util::getCustomDateFormat($lastPublish, substr(B2S_LANGUAGE, 0, 2)) . '</p>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="b2s-post-publish-area" data-post-id="' . $var->ID . '"></div>
                                                    </div>
                                                </div>
                                         </div>
                                    </li>';
            }

            if ($this->type == 'sched') {
                $userInfo = get_user_meta($var->blog_user_id);
                $schedPublish = $this->getPostCount($var->ID);
                $nextSched = $this->getLastPost($var->ID);
                $this->postItem .= '<li class="list-group-item">
                                        <div class="media">
                                             <img class="post-img-10 pull-left hidden-xs" src="' . plugins_url('/assets/images/b2s/' . $postType . '-icon.png', B2S_PLUGIN_FILE) . '" alt="posttype">
                                                <div class="media-body">
                                                    <div class="pull-left media-head">
                                                            <strong><a target="_blank" href="' . get_permalink($var->ID) . '">' .$postTitle . '</a></strong>
                                                        <span class="pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm b2sDetailsSchedPostBtn" data-search-date="' . $this->searchShowByDate . '" data-post-id="' . $var->ID . '"><i class="glyphicon glyphicon-chevron-down"></i> ' . __('Details', 'blog2social') . '</button>
                                                        </span>
                                                        <p class="info hidden-xs"><a class="b2sDetailsSchedPostTriggerLink" href="#"><span class="b2s-sched-count" data-post-id="' . $var->ID . '">' . $schedPublish . '</span> ' . __('scheduled social media posts', 'blog2social') . '</a> | ' . __('next share by', 'blog2social') . ' <a href="' . get_author_posts_url($var->blog_user_id) . '">' . (isset($userInfo['nickname'][0]) ? $userInfo['nickname'][0] : '-') . '</a> ' . B2S_Util::getCustomDateFormat($nextSched, substr(B2S_LANGUAGE, 0, 2)) . '</p>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="b2s-post-sched-area" data-post-id="' . $var->ID . '"></div>
                                                 </div>
                                             </div>
                                         </div>
                                    </li>';
            }
        }

        return html_entity_decode($this->postItem, ENT_COMPAT, 'UTF-8');
    }

    private function getPostCount($post_id = 0) {
        if ($post_id > 0) {
            global $wpdb;
            $addNotAdmin = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `blog_user_id` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';
            $addSearchShowByDate = (!empty($this->searchShowByDate)) ? (($this->type == 'publish') ? " AND DATE_FORMAT(publish_date,'%Y-%m-%d') = '" . $this->searchShowByDate . "' " : " AND DATE_FORMAT(sched_date,'%Y-%m-%d') = '" . $this->searchShowByDate . "' ") : '';
            $where = ($this->type == 'publish') ? " `sched_date` = '0000-00-00 00:00:00' " : " `publish_date` = '0000-00-00 00:00:00'";
            $sqlPostsTotal = "SELECT COUNT(`post_id`) FROM `b2s_posts` WHERE $where $addNotAdmin $addSearchShowByDate AND `hide` = 0 AND `post_id` = " . $post_id;
            return $wpdb->get_var($sqlPostsTotal);
        }
        return 0;
    }

    private function getLastPost($post_id = 0) {
        if ($post_id > 0) {
            global $wpdb;
            $addNotAdmin = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `blog_user_id` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';
            $order = ($this->type == 'publish') ? " `publish_date` DESC" : " `sched_date` ASC ";
            $where = ($this->type == 'publish') ? " `sched_date` = '0000-00-00 00:00:00' " : " `publish_date` = '0000-00-00 00:00:00'";
            $fields = $this->type == 'publish' ? "publish_date" : "sched_date";
            $sqlLast = "SELECT $fields FROM `b2s_posts` WHERE $where $addNotAdmin AND `hide` = 0 AND `post_id` = " . $post_id . " ORDER BY $order LIMIT 1";
            return $wpdb->get_var($sqlLast);
        }
        return date('Y-m-d H:i:s');
    }

    private function getLastPublish($post_id = 0) {
        if ($post_id > 0) {
            global $wpdb;
            $addNotAdmin = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `blog_user_id` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';
            $order = "`publish_date` DESC";
            $where = "`sched_date` = '0000-00-00 00:00:00' ";
            $fields = "publish_date";
            $sqlLast = "SELECT $fields FROM `b2s_posts` WHERE $where $addNotAdmin AND `hide` = 0 AND `post_id` = " . $post_id . " ORDER BY $order LIMIT 1";
            $result = $wpdb->get_results($sqlLast);
            if (!empty($result) && isset($result[0]->publish_date)) {
                return $result[0]->publish_date;
            }
        }
        return false;
    }

    public function getCalendarSchedDate() {
        if ((int) $this->postTotal > 0) {
            if (is_array($this->postCalendarSchedDates) && !empty($this->postCalendarSchedDates)) {
                return $this->postCalendarSchedDates;
            }
        }
        return 0;
    }

    public function getPaginationHtml() {
        if ((int) $this->postTotal > 0) {
            $last = ceil($this->postTotal / B2S_PLUGIN_POSTPERPAGE);
            $start = (($this->currentPage - $this->postPaginationLinks ) > 0 ) ? $this->currentPage - $this->postPaginationLinks : 1;
            $end = (( $this->currentPage + $this->postPaginationLinks ) < $last ) ? $this->currentPage + $this->postPaginationLinks : $last;
            $this->postPagination = '<ul class="pagination">';
            $class = ( $this->currentPage == 1 ) ? "disabled" : "";
            $linkpre = ( $this->currentPage == 1 ) ? $this->currentPage : ( $this->currentPage - 1);
            $this->postPagination .= '<li class="' . $class . '"><a class="b2s-pagination-btn" data-page="' . $linkpre . '" href="#">&laquo;</a></li>';
            if ($start > 1) {
                $this->postPagination .= '<li><a class="b2s-pagination-btn" data-page="1" href="#">1</a></li>';
                $this->postPagination .= '<li class="disabled"><span>...</span></li>';
            }
            for ($i = $start; $i <= $end; $i++) {
                $class = ( $this->currentPage == $i ) ? "active" : "";
                $this->postPagination .= '<li class="' . $class . '"><a class="b2s-pagination-btn" data-page="' . $i . '" href="#">' . $i . '</a></li>';
            }
            if ($end < $last) {
                $this->postPagination .= '<li class="disabled"><span>...</span></li>';
                $this->postPagination .= '<li><a class="b2s-pagination-btn" data-page="' . $last . '" href="#">' . $last . '</a></li>';
            }
            $class = ( $this->currentPage == $last ) ? "disabled" : "";
            $linkpast = ( $this->currentPage == $last ) ? $this->currentPage : ( $this->currentPage + 1 );
            $this->postPagination .= '<li class="' . $class . '"><a class="b2s-pagination-btn" data-page="' . $linkpast . '" href="#">&raquo;</a></li>';
            $this->postPagination .= '</ul>';
        }
        return $this->postPagination;
    }

    public function getPublishPostDataHtml($post_id = 0, $showByDate = '') {
        if ($post_id > 0) {
            global $wpdb;
            $addNotAdminPosts = (!B2S_PLUGIN_ADMIN) ? (' AND blog_user_id =' . B2S_PLUGIN_BLOG_USER_ID) : '';
            $addSearchShowByDate = (!empty($showByDate)) ? " AND DATE_FORMAT(`b2s_posts`.`publish_date`,'%%Y-%%m-%%d') = '" . $showByDate . "' " : '';
            $sqlData = $wpdb->prepare("SELECT `b2s_posts`.`id`,`blog_user_id`,`publish_date`,`publish_link`,`sched_type`,`publish_error_code`,`b2s_posts_network_details`.`network_id`,`b2s_posts_network_details`.`network_type`, `b2s_posts_network_details`.`network_auth_id`, `b2s_posts_network_details`.`network_display_name` FROM `b2s_posts` LEFT JOIN `b2s_posts_network_details` ON `b2s_posts`.`network_details_id` = `b2s_posts_network_details`.`id` WHERE `b2s_posts`.`hide` = 0  AND `b2s_posts`.`sched_date` = '0000-00-00 00:00:00' $addNotAdminPosts $addSearchShowByDate AND `b2s_posts`.`post_id` = %d ORDER BY `b2s_posts`.`publish_date` DESC", $post_id);
            $result = $wpdb->get_results($sqlData);
            if (!empty($result) && is_array($result)) {
                $networkType = unserialize(B2S_PLUGIN_NETWORK_TYPE);
                $networkName = unserialize(B2S_PLUGIN_NETWORK);
                $networkErrorCode = unserialize(B2S_PLUGIN_NETWORK_ERROR);
                $content = '<div class="row"><div class="col-md-12"><ul class="list-group">';
                $content .='<li class="list-group-item"><label class="checkbox-inline checkbox-all-label"><input class="checkbox-all" data-blog-post-id="' . $post_id . '" name="selected-checkbox-all" value="" type="checkbox"> ' . __('select all', 'blog2social') . '</label></li>';
                foreach ($result as $var) {
                    $autoPosting = (isset($var->sched_type) && (int) $var->sched_type == 3) ? ' - <strong>' . __('Auto-Posting', 'blog2social') . '</strong>' : '';
                    $publishLink = (!empty($var->publish_link)) ? '<a target="_blank" href="' . $var->publish_link . '">' . __('show', 'blog2social') . '</a> | ' : '';
                    $error = (!empty($var->publish_error_code)) ? '<span class="network-text-info text-danger hidden-xs"> <i class="glyphicon glyphicon-remove-circle glyphicon-danger"></i> ' . $networkErrorCode[trim($var->publish_error_code)] . '</span>' : '';
                    $userInfo = get_user_meta($var->blog_user_id);
                    $content .= ' <li class="list-group-item b2s-post-publish-area-li" data-post-id="' . $var->id . '">
                                    <div class="media">';

                    $content .='<input class="checkboxes pull-left checkbox-item" data-blog-post-id="' . $post_id . '" name="selected-checkbox-item" value="' . $var->id . '" type="checkbox">';

                    if (!empty($var->publish_link)) {
                        $content .= '<a class="pull-left" target="_blank" href="' . $var->publish_link . '"><img class="pull-left hidden-xs" src="' . plugins_url('/assets/images/portale/' . $var->network_id . '_flat.png', B2S_PLUGIN_FILE) . '" alt="posttype"></a>';
                    } else {
                        $content .= '<img class="pull-left hidden-xs" src="' . plugins_url('/assets/images/portale/' . $var->network_id . '_flat.png', B2S_PLUGIN_FILE) . '" alt="posttype">';
                    }
                    $content .= '<div class="media-body">
                                            <strong>' . $networkName[$var->network_id] . '</strong> ' . $error . '
                                            <p class="info">' . $networkType[$var->network_type] . (!empty($var->network_display_name) ? (': ' . $var->network_display_name) : '' ) . ' | ' . __('shared by', 'blog2social') . ' <a href="' . get_author_posts_url($var->blog_user_id) . '">' . (isset($userInfo['nickname'][0]) ? $userInfo['nickname'][0] : '-') . '</a> ' . B2S_Util::getCustomDateFormat($var->publish_date, substr(B2S_LANGUAGE, 0, 2)) . $autoPosting . '</p>
                                            <p class="info">' . $publishLink;

                    $content .= B2S_PLUGIN_USER_VERSION > 0 ? '<a href="#" class="b2s-post-publish-area-drop-btn" data-post-id="' . $var->id . '">' : '<a href="#" data-toggle="modal" data-title="' . __('You want to delete a publish post entry?', 'blog2social') . '" data-target="#b2sProFeatureModal" >';
                    $content .= __('delete from reporting', 'blog2social') . '</a> ';
                    if (!empty($error)) {
                        $content .= '| <a href="admin.php?page=blog2social-ship&postId=' . $post_id . '&network_auth_id=' . $var->network_auth_id . '">' . __('re-share', 'blog2social') . '</a>';
                    }

                    $content . '</p>
                                        </div>
                                    </div>
                                </li>';
                }
                $content .='<li class="list-group-item"><label class="checkbox-inline checkbox-all-label-btn"><span class="glyphicon glyphicon glyphicon-trash "></span> ';
                $content .= B2S_PLUGIN_USER_VERSION > 0 ? '<a class="checkbox-post-publish-all-btn" data-blog-post-id="' . $post_id . '" href="#">' : '<a href="#" data-toggle="modal" data-title="' . __('You want to delete a publish post entry?', 'blog2social') . '" data-target="#b2sProFeatureModal" >';
                $content .= __('delete from reporting', 'blog2social') . '</a></label></li>';
                $content .= '</ul></div></div>';
                return $content;
            }
        }
        return false;
    }

    public function getSchedPostDataHtml($post_id = 0, $showByDate = '') {
        if ($post_id > 0) {
            global $wpdb;
            $addNotAdminPosts = (B2S_PLUGIN_ADMIN == false) ? $wpdb->prepare(' AND `b2s_posts`.`blog_user_id` = %d', B2S_PLUGIN_BLOG_USER_ID) : '';
            $addSearchShowByDate = (!empty($showByDate)) ? " AND DATE_FORMAT(`b2s_posts`.`sched_date`,'%%Y-%%m-%%d') = '" . $showByDate . "' " : '';
            $sqlData = $wpdb->prepare("SELECT `b2s_posts`.`id`,`blog_user_id`,`v2_id`, `sched_date`, `sched_type`,`b2s_posts_network_details`.`network_id`,`b2s_posts_network_details`.`network_type`,`b2s_posts_network_details`.`network_display_name` FROM `b2s_posts` LEFT JOIN `b2s_posts_network_details` ON `b2s_posts`.`network_details_id` = `b2s_posts_network_details`.`id` WHERE `b2s_posts`.`hide` = 0  AND `b2s_posts`.`publish_date` = '0000-00-00 00:00:00' $addNotAdminPosts $addSearchShowByDate AND `b2s_posts`.`post_id` = %d ORDER BY `b2s_posts`.`sched_date` ASC ", $post_id);
            $result = $wpdb->get_results($sqlData);
            if (!empty($result) && is_array($result)) {
                $networkType = unserialize(B2S_PLUGIN_NETWORK_TYPE);
                $networkName = unserialize(B2S_PLUGIN_NETWORK);
                $content = '<div class="row"><div class="col-md-12"><ul class="list-group">';
                $content .='<li class="list-group-item"><label class="checkbox-inline checkbox-all-label"><input class="checkbox-all" data-blog-post-id="' . $post_id . '" name="selected-checkbox-all" value="" type="checkbox"> ' . __('select all', 'blog2social') . '</label></li>';
                foreach ($result as $var) {
                    $autoPosting = (isset($var->sched_type) && (int) $var->sched_type == 3) ? ' - <strong>' . __('Auto-Posting', 'blog2social') . '</strong>' : '';
                    $userInfo = get_user_meta($var->blog_user_id);
                    $content .= '<li class="list-group-item b2s-post-sched-area-li" data-post-id="' . $var->id . '">
                                    <div class="media">';
                    $content .='<input class="checkboxes pull-left checkbox-item" data-blog-post-id="' . $post_id . '" name="selected-checkbox-item" value="' . $var->id . '" type="checkbox">';

                    $content .='<img class="pull-left hidden-xs" src="' . plugins_url('/assets/images/portale/' . $var->network_id . '_flat.png', B2S_PLUGIN_FILE) . '" alt="posttype">
                                            <div class="media-body">
                                                <strong>' . $networkName[$var->network_id] . '</strong>
                                                <p class="info">' . $networkType[$var->network_type] . (!empty($var->network_display_name) ? (': ' . $var->network_display_name) : '' ) . ' | ' . __('scheduled by', 'blog2social') . ' <a href="' . get_author_posts_url($var->blog_user_id) . '">' . (isset($userInfo['nickname'][0]) ? $userInfo['nickname'][0] : '-') . '</a> <span class="b2s-post-sched-area-sched-time" data-post-id="' . $var->id . '">' . B2S_Util::getCustomDateFormat($var->sched_date, substr(B2S_LANGUAGE, 0, 2)) . $autoPosting . '</span></p>
                                                <p class="info">';

                    $content .= (B2S_PLUGIN_USER_VERSION > 0) ? '<a href="#" class="b2s-post-sched-area-drop-btn" data-post-id="' . $var->id . '">' : '<a href="#" data-toggle="modal" data-title="' . __('You want to delete an scheduled post entry?', 'blog2social') . '" data-target="#b2sProFeatureModal" >';
                    $content .= __('delete scheduling', 'blog2social') . '</a> ';

                    if ((int) $var->v2_id == 0) {
                        $content .= '|';
                        $content .= (B2S_PLUGIN_USER_VERSION > 0) ? ' <a href="#" class="b2s-post-sched-area-edittime-btn" data-post-id="' . $var->id . '">' : ' <a href="#" data-toggle="modal" data-title="' . __('You want to change the time for your scheduled post?', 'blog2social') . '" data-target="#b2sProFeatureModal">';
                        $content .= __('change time', 'blog2social') . '</a>';
                    }
                    $content .= '</p>
                                            </div>
                                    </div>
                                </li>';
                }
                $content .='<li class="list-group-item"><label class="checkbox-inline checkbox-all-label-btn"><span class="glyphicon glyphicon glyphicon-trash "></span> ';
                $content .= (B2S_PLUGIN_USER_VERSION > 0) ? '<a class="checkbox-post-sched-all-btn" data-blog-post-id="' . $post_id . '" href="#">' : '<a href="#" data-toggle="modal" data-title="' . __('You want to delete an scheduled post entry?', 'blog2social') . '" data-target="#b2sProFeatureModal" >';
                $content .= __('delete scheduling', 'blog2social') . '</a></label></li>';
                $content .= '</ul></div></div>';
                return $content;
            }
        }
        return false;
    }

}

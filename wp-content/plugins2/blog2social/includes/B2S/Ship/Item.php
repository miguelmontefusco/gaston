<?php

class B2S_Ship_Item {

    private $allowTitleProfile = array(7, 9, 13);
    private $allowTitlePage = array();
    private $allowTitleGroup = array();
    private $isCommentProfile = array(1, 3, 8, 10);
    private $isCommentPage = array();
    private $isCommentGroup = array(8);
    private $allowTag = array(4, 9);
    private $allowHtml = array(4, 11, 14);
    private $showTitleProfile = array(4, 9, 11, 14);
    private $showTitlePage = array(8);
    private $showTitleGroup = array(8);
    private $onlyImage = array(6, 7, 12);
    private $allowNoImageProfile = array(5, 9);
    private $allowNoCustomImageProfile = array(8);
    private $allowNoImagePage = array(8);
    private $allowEditUrl = array(1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14);
    private $showBoards = array(6);
    private $showGroups = array(8);
    private $hideGroupName = array(8);
    private $setShortTextProfile = array(1 => 239, 2 => 116, 3 => 239, 6 => 300, 8 => 239, 10 => 442, 12 => 240, 9 => 200);
    private $setShortTextPage = array(1 => 239, 3 => 239, 8 => 1200, 10 => 442);
    private $setShortTextGroup = array(8 => 239, 10 => 442);
    private $allowHashTags = array(6, 10, 12);
    private $limitCharacterProfile = array(2 => 140, 3 => 600, 6 => 500, 8 => 420, 9 => 250);
    private $limitCharacterPage = array(3 => 600, 8 => 1200);
    private $requiredUrl = array(1, 3, 8, 9, 10);
    private $getText = array(1, 7, 10, 12);
    private $maxWeekTimeSelect = 52;
    private $maxSchedCount = 3;
    private $noScheduleRegularly = array(4, 11, 14);
    private $defaultImage;
    // private $allowPreview = array(1);
    private $postData;
    private $postUrl;
    private $postStatus;
    private $websiteName;
    private $postId;

    public function __construct($postId) {
        $this->postId = $postId;
        $this->postData = get_post($this->postId);
        $this->postStatus = $this->postData->post_status;
        $this->websiteName = get_option('blogname');
        $this->postUrl = (get_permalink($this->postData->ID) !== false ? get_permalink($this->postData->ID) : $this->postData->guid);
    }

    public function getItemHtml($data) {

        $neworkName = unserialize(B2S_PLUGIN_NETWORK);
        $networkTypeName = unserialize(B2S_PLUGIN_NETWORK_TYPE);
        $limit = false;
        $limitValue = 0;
        $textareaLimitInfo = "";
        $textareaOnKeyUp = "";
        $this->defaultImage = plugins_url('/assets/images/no-image.png', B2S_PLUGIN_FILE);

        //Settings
        switch ($data->networkType) {
            case '0':
                //profil
                if (isset($this->limitCharacterProfile[$data->networkId]) && (int) $this->limitCharacterProfile[$data->networkId] > 0) {
                    $limitValue = $this->limitCharacterProfile[$data->networkId];
                    $limit = true;
                }
                $infoImage = (in_array($data->networkId, $this->allowNoImageProfile)) ? __('Network does not support image for profiles', 'blog2social') . '!' : '';
                $infoImage .= (in_array($data->networkId, $this->allowNoCustomImageProfile)) ? (!empty($infoImage) ? ' | ' : '') . __('Network defines image by link', 'blog2social') . '!' : '';
                $htmlTags = highlight_string("<p><br><i><b><a><img>", true);
                $infoImage .= (in_array($data->networkId, $this->allowHtml)) ? (!empty($infoImage) ? ' | ' : '') . __('Supported HTML tags', 'blog2social') . ': ' . $htmlTags : '';

                $network_display_name = $data->network_display_name;
                $isRequiredTextarea = (in_array($data->networkId, $this->isCommentProfile)) ? '' : 'required="required"';

                //ShortText
                if (isset($this->setShortTextProfile[$data->networkId]) && (int) $this->setShortTextProfile[$data->networkId] > 0) {
                    $preContent = ($data->networkId == 2) ? $this->postData->post_title : B2S_Util::prepareContent($this->postData->post_content, false);
                    $message = B2S_Util::getExcerpt($preContent, (int) $this->setShortTextProfile[$data->networkId]);
                } else {
                    $message = (in_array($data->networkId, $this->allowTitleProfile) ? $this->postData->post_title : B2S_Util::prepareContent($this->postData->post_content, (in_array($data->networkId, $this->allowHtml) ? '<p><h1><h2><br><i><b><a><img>' : false)));
                }

                //Hashtags
                if (in_array($data->networkId, $this->allowHashTags)) {
                    $message .= $this->getHashTagsString();
                }
                $countCharacter = 0;
                if ($limit !== false) {

                    /* $countValue = $limitValue;
                      if ($data->networkId == 2) { //Twitter
                      $countValue = $limitValue - 24;
                      }
                      $countCharacter = (int) $countValue - (in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8'));
                      if ($countCharacter <= 0) {
                      $message = mb_substr($message, 0, (int) $countValue);
                      $countCharacter = 0;
                      } */

                    $infoCharacterCount = ($data->networkId != 2) ? ' (' . __('Text only', 'blog2social') . ')' : '';
                    $excludedImageTransfer = ($data->networkId == 2) ? $this->excludedImageTransferHtml($data->networkId, $data->networkAuthId, $limitValue) : '';

                    $textareaLimitInfo = $excludedImageTransfer . '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span>/' . $limitValue . ' ' . __('characters', 'blog2social') . $infoCharacterCount . '</span>';
                    $textareaOnKeyUp = 'onkeyup="networkLimitAll(\'' . $data->networkAuthId . '\',\'' . $data->networkId . '\',\'' . $limitValue . '\');"';
                } else {
                    //$countCharacter = in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8');
                    $textareaOnKeyUp = 'onkeyup="networkCount(\'' . $data->networkAuthId . '\');"';
                    $textareaLimitInfo = '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span> ' . __('characters', 'blog2social') . '</span>';
                }

                break;
            case '1':
                //page
                if (isset($this->limitCharacterPage[$data->networkId]) && (int) $this->limitCharacterPage[$data->networkId] > 0) {
                    $limitValue = $this->limitCharacterPage[$data->networkId];
                    $limit = true;
                }
                $infoImage = (in_array($data->networkId, $this->allowNoImagePage)) ? __('Network does not support image for pages', 'blog2social') . '!' : '';

                //ShortText
                if (isset($this->setShortTextPage[$data->networkId]) && (int) $this->setShortTextPage[$data->networkId] > 0) {
                    if ($data->networkId == 8) { //Xing -1 Leerzeichen
                        $this->setShortTextPage[$data->networkId] = (int) $this->setShortTextPage[$data->networkId] - mb_strlen($this->postUrl, 'UTF-8') - 1;
                    }
                    $message = B2S_Util::getExcerpt(B2S_Util::prepareContent($this->postData->post_content, false), (int) $this->setShortTextPage[$data->networkId]);
                } else {
                    $message = (in_array($data->networkId, $this->allowTitlePage) ? $this->postData->post_title : B2S_Util::prepareContent($this->postData->post_content, (in_array($data->networkId, $this->allowHtml) ? '<p><h1><h2><br><i><b><a><img>' : false)));
                }

                //Hashtags
                if (in_array($data->networkId, $this->allowHashTags)) {
                    $message .= $this->getHashTagsString();
                }

                $network_display_name = $data->network_display_name;
                $isRequiredTextarea = (in_array($data->networkId, $this->isCommentPage)) ? '' : 'required="required"';

                $countCharacter = 0;
                if ($limit !== false) {
                    /*$countValue = $limitValue;
                    if ($data->networkId == 8) { //Xing -1 Leerzeichen
                        $countValue = $limitValue - mb_strlen($this->postUrl, 'UTF-8') - 1;
                    }
                    $countCharacter = (int) $countValue - (in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8'));
                    if ($countCharacter <= 0) {
                        $message = mb_substr($message, 0, (int) $countValue);
                        $countCharacter = 0;
                    }*/

                    $textareaLimitInfo = '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span>/' . $limitValue . ' ' . __('characters', 'blog2social') . '</span>';
                    $textareaOnKeyUp = 'onkeyup="networkLimitAll(\'' . $data->networkAuthId . '\',\'' . $data->networkId . '\',\'' . $limitValue . '\');"';
                } else {
                    //$countCharacter = in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8');
                    $textareaOnKeyUp = 'onkeyup="networkCount(\'' . $data->networkAuthId . '\');"';
                    $textareaLimitInfo = '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span> ' . __('characters', 'blog2social') . '</span>';
                }
                break;
            case'2':
                //group
                //ShortText
                if (isset($this->setShortTextGroup[$data->networkId]) && (int) $this->setShortTextGroup[$data->networkId] > 0) {
                    $message = B2S_Util::getExcerpt(B2S_Util::prepareContent($this->postData->post_content, false), (int) $this->setShortTextGroup[$data->networkId]);
                } else {
                    $message = (in_array($data->networkId, $this->allowTitleGroup) ? $this->postData->post_title : B2S_Util::prepareContent($this->postData->post_content, (in_array($data->networkId, $this->allowHtml) ? '<p><h1><h2><br><i><b><a><img>' : false)));
                }
                //Hashtags
                if (in_array($data->networkId, $this->allowHashTags)) {
                    $message .= $this->getHashTagsString();
                }
                $network_display_name = in_array($data->networkId, $this->hideGroupName) ? '' : $data->network_display_name;
                $isRequiredTextarea = (in_array($data->networkId, $this->isCommentGroup)) ? '' : 'required="required"';

                $countCharacter = 0;
                if ($limit !== false) {
                    /*$countValue = $limitValue;
                    $countCharacter = (int) $countValue - (in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8'));
                    if ($countCharacter <= 0) {
                        $message = mb_substr($message, 0, (int) $countValue);
                        $countCharacter = 0;
                    }*/

                    $textareaLimitInfo = '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span>/' . $limitValue . ' ' . __('characters', 'blog2social') . '</span>';
                    $textareaOnKeyUp = 'onkeyup="networkLimitAll(\'' . $data->networkAuthId . '\',\'' . $data->networkId . '\',\'' . $limitValue . '\');"';
                } else {
                    //$countCharacter = in_array($data->networkId, $this->allowHtml) ? (int) mb_strlen(strip_tags($message), 'UTF-8') : (int) mb_strlen($message, 'UTF-8');
                    $textareaOnKeyUp = 'onkeyup="networkCount(\'' . $data->networkAuthId . '\');"';
                    $textareaLimitInfo = '<span class="b2s-post-item-countChar" data-network-auth-id="' . $data->networkAuthId . '">' . (int) $countCharacter . '</span> ' . __('characters', 'blog2social') . '</span>';
                }
                break;
        }


        //Infotexte
        $messageInfo = (!empty($infoImage)) ? '<p class="b2s-post-item-message-info pull-left hidden-sm hidden-xs">' . $infoImage . '</p>' : '';
        $onlyimage = in_array($data->networkId, $this->onlyImage) ? 'b2sOnlyWithImage' : '';

        $content = '<div class="b2s-post-item ' . $onlyimage . '" data-network-auth-id="' . $data->networkAuthId . '" data-network-id="' . $data->networkId . '">';
        $content .= '<div class="panel panel-group">';
        $content .= '<div class="panel-body">';
        $content .= '<div class="b2s-post-item-area">';
        $content .= '<div class="b2s-post-item-thumb hidden-xs">';
        $content .= '<img alt="" class="img-responsive" src="' . plugins_url('/assets/images/portale/' . $data->networkId . '_flat.png', B2S_PLUGIN_FILE) . '">';
        $content .= '</div>';
        $content .= '<div class="b2s-post-item-details">';
        $content .= '<h4 class="pull-left">' . stripslashes($network_display_name) . '</h4>';
        $content .= '<div class="clearfix"></div>';
        $content .= '<p class="pull-left">' . $networkTypeName[$data->networkType] . ' | ' . $neworkName[$data->networkId];
        $content .= '<div class="b2s-post-item-details-message-result" data-network-auth-id="' . $data->networkAuthId . '" style="display:none;"></div>';
        $content .= '<span class="hidden-xs b2s-post-item-details-message-info" data-network-auth-id="' . $data->networkAuthId . '">' . $messageInfo . '</span></span>';

        $content .= '<div class="pull-right hidden-xs b2s-post-item-info-area">';
        if (in_array($data->networkId, $this->getText)) {
            $content .= '<button class="btn btn-xs btn-link b2s-post-ship-item-full-text" data-network-auth-id="' . $data->networkAuthId . '" >' . __('Insert full-text', 'blog2social') . '</button> | ';
        }
        $content .= '<button class="btn btn-xs btn-link b2s-post-ship-item-message-delete" data-network-auth-id="' . $data->networkAuthId . '">' . __('Delete text', 'blog2social') . '</button> | ';
        $content .= $textareaLimitInfo . '</div>';

        $content .= '</p>';

        $content .= '<div class="b2s-post-item-details-edit-area" data-network-auth-id="' . $data->networkAuthId . '">';
        $content .= in_array($data->networkId, $this->showBoards) ? $this->getBoardHtml($data->networkAuthId, $data->networkId) : '';
        $content .= (in_array($data->networkId, $this->showGroups) && $data->networkType == 2) ? $this->getGroupsHtml($data->networkAuthId, $data->networkId) : '';
        $content .= ((in_array($data->networkId, $this->showTitleProfile) && $data->networkType == 0) || (in_array($data->networkId, $this->showTitlePage) && $data->networkType == 1) || (in_array($data->networkId, $this->showTitleGroup) && $data->networkType == 2)) ? $this->getTitleHtml($data->networkAuthId, $this->postData->post_title) : '';
        $content .= $this->getCustomEditArea($data->networkId, $data->networkAuthId, $data->networkType, $message, $isRequiredTextarea, $textareaOnKeyUp, $limit, $limitValue);
        $content .= (in_array($data->networkId, $this->allowTag)) ? $this->getTagsHtml($data->networkAuthId) : '';
        $content .= $this->getShippingTimeHtml($data->networkAuthId, $data->networkType, $data->networkId);
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<input type="hidden" class="form-control" name="b2s[' . $data->networkAuthId . '][network_id]" value="' . $data->networkId . '">';
        $content .= '<input type="hidden" class="form-control" name="b2s[' . $data->networkAuthId . '][network_type]" value="' . $data->networkType . '">';
        $content .= '<input type="hidden" class="form-control" name="b2s[' . $data->networkAuthId . '][network_display_name]" value="' . $data->network_display_name . '">';

        $content .= '</div>';
        return $content;
    }

    private function getCustomEditArea($networkId, $networkAuthId, $networkType, $message, $isRequiredTextarea, $textareaOnKeyUp, $limit, $limitValue) {
        $meta = false;
        if ($networkId == 1 || ($networkId == 8 && $networkType == 0) || $networkId == 3) {
            if (trim(strtolower($this->postStatus)) == 'publish') {
                $meta = B2S_Util::getMetaTags($this->postId, $this->postUrl);
            } else {
                $meta = array('title' => B2S_Util::getExcerpt($this->postData->post_title, 50) . ' - ' . $this->websiteName, 'description' => B2S_Util::getExcerpt(B2S_Util::prepareContent($this->postData->post_content, false), 150));
            }
        }
        if (is_array($meta) && !empty($meta)) {
            if ($networkId == 1) {
                $edit = '<textarea class="form-control fb-textarea-input b2s-post-item-details-item-message-input ' . (in_array($networkId, $this->allowHtml) ? 'b2s-post-item-details-item-message-input-allow-html' : '') . '" data-network-text-limit="'.$limitValue.'" data-network-auth-id="' . $networkAuthId . '" placeholder="' . __('Write something about your post...', 'blog2social') . '" name="b2s[' . $networkAuthId . '][content]" ' . $isRequiredTextarea . ' ' . $textareaOnKeyUp . '>' . $message . '</textarea>';
                $edit .= '<div class="fb-container">';
                $edit .= '<img src="' . (isset($meta['image']) && !empty($meta['image']) ? $meta['image'] : $this->defaultImage) . '" class="fb-url-image b2s-post-item-details-url-image" data-network-image-change="1" data-network-auth-id="' . $networkAuthId . '">';
                $edit .= '<div class="fb-content">';
                $edit .= '<p class="fb-url-title b2s-post-item-details-preview-title" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['title']) && !empty($meta['title']) ? $meta['title'] : '') . '</p>';
                $edit .= '<span class="fb-url-desc b2s-post-item-details-preview-desc" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['description']) && !empty($meta['description']) ? $meta['description'] : '' ) . '</span>';
                $edit .= $this->getUrlHtml($networkId, $networkAuthId, $limit, $limitValue, true, 'fb-url-input', true);
                $edit .= '</div>';
                $edit .= '</div>';
            }

            if ($networkId == 3) {
                $edit = '<textarea class="form-control linkedin-textarea-input b2s-post-item-details-item-message-input ' . (in_array($networkId, $this->allowHtml) ? 'b2s-post-item-details-item-message-input-allow-html' : '') . '" data-network-text-limit="'.$limitValue.'" data-network-auth-id="' . $networkAuthId . '" placeholder="' . __('Write something about your post...', 'blog2social') . '" name="b2s[' . $networkAuthId . '][content]" ' . $isRequiredTextarea . ' ' . $textareaOnKeyUp . '>' . $message . '</textarea>';
                $edit .= '<div class="linkedin-container">';
                $edit .= '<img src="' . (isset($meta['image']) && !empty($meta['image']) ? $meta['image'] : $this->defaultImage) . '" class="linkedin-url-image b2s-post-item-details-url-image" data-network-image-change="1" data-network-auth-id="' . $networkAuthId . '">';
                $edit .= '<div class="linkedin-content">';
                $edit .= '<p class="linkedin-url-title b2s-post-item-details-preview-title" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['title']) && !empty($meta['title']) ? $meta['title'] : '') . '</p>';
                $edit .= $this->getUrlHtml($networkId, $networkAuthId, $limit, $limitValue, true, 'linkedin-url-input', true);
                $edit .= '<p class="linkedin-url-desc b2s-post-item-details-preview-desc" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['description']) && !empty($meta['description']) ? $meta['description'] : '' ) . '</p>';
                $edit .= '</div>';
                $edit .= '</div>';
            }

            if ($networkId == 8 && $networkType == 0) {
                $edit = '<textarea class="form-control xing-textarea-input b2s-post-item-details-item-message-input ' . (in_array($networkId, $this->allowHtml) ? 'b2s-post-item-details-item-message-input-allow-html' : '') . '" data-network-text-limit="'.$limitValue.'" data-network-auth-id="' . $networkAuthId . '" placeholder="' . __('Write something about your post...', 'blog2social') . '" name="b2s[' . $networkAuthId . '][content]" ' . $isRequiredTextarea . ' ' . $textareaOnKeyUp . '>' . $message . '</textarea>';
                $edit .= '<div class="xing-container">';
                $edit .= '<img src="' . (isset($meta['image']) && !empty($meta['image']) ? $meta['image'] : $this->defaultImage) . '" class="xing-url-image b2s-post-item-details-url-image" data-network-image-change="0" data-network-auth-id="' . $networkAuthId . '">';
                $edit .= '<div class="xing-content">';
                $edit .= '<p class="xing-url-title b2s-post-item-details-preview-title" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['title']) && !empty($meta['title']) ? $meta['title'] : '') . '</p>';
                $edit .= '<span class="xing-url-desc b2s-post-item-details-preview-desc" data-network-auth-id="' . $networkAuthId . '">' . (isset($meta['description']) && !empty($meta['description']) ? $meta['description'] : '' ) . '</span>';
                $edit .= $this->getUrlHtml($networkId, $networkAuthId, $limit, $limitValue, true, 'xing-url-input', true);
                $edit .= '</div>';
                $edit .= '</div>';
            }
        } else {
            $edit = '<textarea class="form-control b2s-post-item-details-item-message-input ' . (in_array($networkId, $this->allowHtml) ? 'b2s-post-item-details-item-message-input-allow-html' : '') . '" data-network-text-limit="'.$limitValue.'" data-network-auth-id="' . $networkAuthId . '" placeholder="' . __('Write something about your post...', 'blog2social') . '" name="b2s[' . $networkAuthId . '][content]" ' . $isRequiredTextarea . ' ' . $textareaOnKeyUp . '>' . $message . '</textarea>';
            $edit .= $this->getUrlHtml($networkId, $networkAuthId, $limit, $limitValue);
        }
        return $edit;
    }

    private function excludedImageTransferHtml($networkId, $networkAuthId, $limitValue) {
        $inputOnChange = 'onchange="networkLimitAll(\'' . $networkAuthId . '\',\'' . $networkId . '\',\'' . $limitValue . '\');"';
        return '<span class="b2s-post-item-details-item-image-span" data-network-auth-id="' . $networkAuthId . '"><label class="b2s-vertical-align-baseline"><input class="form-control b2s-post-item-details-item-image-input" checked type="checkbox" name="b2s[' . $networkAuthId . '][publish_image]"  data-network-auth-id="' . $networkAuthId . '" ' . $inputOnChange . ' value="1"/> ' . __('Post selected image', 'blog2social') . '</label></span> | ';
    }

    private function getUrlHtml($networkId, $networkAuthId, $limit, $limitValue, $hideInfo = false, $class = '', $refeshBtn = false) {
        if (in_array($networkId, $this->allowEditUrl)) {
            $urlLimit = ($limit !== false) ? ' onkeyup="networkLimitAll(\'' . $networkAuthId . '\',\'' . $networkId . '\',\'' . $limitValue . '\');"' : 'onkeyup="networkCount(\'' . $networkAuthId . '\');"';
            $isRequiredClass = (in_array($networkId, $this->requiredUrl)) ? 'required_network_url' : '';
            $isRequiredText = (!empty($isRequiredClass)) ? '<small>(' . __('required', 'blog2social') . ')</small>' : '';
            $url = (!$hideInfo) ? '<div class="b2s-post-item-details-url-title">Link ' . $isRequiredText . '</div>' : '';
            if ($refeshBtn) {
                $url .= '<div class="input-group"><input class="form-control ' . $class . ' b2s-post-item-details-item-url-input ' . $isRequiredClass . ' complete_network_url" name="b2s[' . $networkAuthId . '][url]" ' . $urlLimit . ' placeholder="' . __('Link', 'blog2social') . '" data-network-auth-id="' . $networkAuthId . '" value="' . $this->postUrl . '" name="b2s[' . $networkAuthId . '][url]"/><span class="input-group-addon"><span class="glyphicon glyphicon-refresh b2s-post-item-details-preview-url-reload" data-network-auth-id="' . $networkAuthId . '" data-network-id="' . $networkId . '" aria-hidden="true"></span></span></div>';
            } else {
                $url .= '<input class="form-control ' . $class . ' b2s-post-item-details-item-url-input ' . $isRequiredClass . ' complete_network_url" name="b2s[' . $networkAuthId . '][url]" ' . $urlLimit . ' placeholder="' . __('Link', 'blog2social') . '" data-network-auth-id="' . $networkAuthId . '" value="' . $this->postUrl . '" name="b2s[' . $networkAuthId . '][url]"/>';
            }
        } else {
            $url = '<input type="hidden" name="b2s[' . $networkAuthId . '][url]" value="' . $this->postUrl . '">';
        }
        return $url;
    }

    private function getHashTagsString($add = "\n\n") {
        $hashTagsData = get_the_tags($this->postId);
        $hashTags = '';
        if (is_array($hashTagsData) && !empty($hashTagsData)) {
            foreach ($hashTagsData as $tag) {
                $hashTags .= ' #' . trim($tag->name);
            }
        }
        return (!empty($hashTags) ? (!empty($add) ? $add . $hashTags : $hashTags) : '');
    }

    private function getBoardHtml($networkAuthId, $networkId) {
        $result = json_decode(B2S_Api_Post::post(B2S_PLUGIN_API_ENDPOINT, array('action' => 'getBoards', 'token' => B2S_PLUGIN_TOKEN, 'networkAuthId' => $networkAuthId, 'networkId' => $networkId)));
        $board = '<select class="form-control b2s-select" name="b2s[' . $networkAuthId . '][board]">';
        if (is_object($result) && !empty($result) && isset($result->data) && !empty($result->data) && isset($result->result) && (int) $result->result == 1) {
            $board .= $result->data;
        }
        $board .= '</select>';
        return $board;
    }

    private function getGroupsHtml($networkAuthId, $networkId) {
        $result = json_decode(B2S_Api_Post::post(B2S_PLUGIN_API_ENDPOINT, array('action' => 'getGroups', 'token' => B2S_PLUGIN_TOKEN, 'networkAuthId' => $networkAuthId, 'networkId' => $networkId, 'lang' => B2S_LANGUAGE)));
        $group = '<select class="form-control b2s-select b2s-post-item-details-item-group-select" name="b2s[' . $networkAuthId . '][group]">';
        if (is_object($result) && !empty($result) && isset($result->data) && !empty($result->data) && isset($result->result) && (int) $result->result == 1) {
            $group .= $result->data;
        }
        $group .= '</select>';
        return $group;
    }

    private function getTitleHtml($networkdAutId, $title) {
        return '<input type="text" name="b2s[' . $networkdAutId . '][custom_title]" class="form-control b2s-post-item-details-item-title-input" data-network-auth-id="' . $networkdAutId . '" placeholder="' . __('The Headline...', 'blog2social') . '" required="required" maxlength="254" value="' . $title . '" />';
    }

    private function getTagsHtml($networkAuthId) {
        $tags = '<div class="b2s-post-item-details-tag-area">';
        $tags .= '<div class="b2s-post-item-details-tag-title"> ' . __('Hashtags', 'blog2social') . ' </div>';
        $tags .= '<div class="b2s-post-item-details-tag-input form-inline">';
        $posttags = get_the_tags($this->postId);
        $countTags = 0;
        if ($posttags) {
            foreach ($posttags as $tag) {
                $countTags += 1;
                $tags .= '<input class="form-control b2s-post-item-details-tag-input-elem" name="b2s[' . $networkAuthId . '][tags][]" data-network-auth-id="' . $networkAuthId . '" value="' . $tag->name . '">';
            }
        } else {
            $tags .= '<input class="form-control b2s-post-item-details-tag-input-elem" name="b2s[' . $networkAuthId . '][tags][]" data-network-auth-id="' . $networkAuthId . '" value="">';
        }
        $showRemoveTagBtn = ($countTags >= 2) ? '' : 'display:none;';
        $tags .= '<div class="form-control b2s-post-item-details-tag-add-div">';
        $tags .= '<span class="remove-tag-btn glyphicon glyphicon-minus" data-network-auth-id="' . $networkAuthId . '" style="' . $showRemoveTagBtn . '" onclick="removeTag(\'' . $networkAuthId . '\');" ></span>';
        $tags .= '<span class="ad-tag-btn glyphicon glyphicon-plus" data-network-auth-id="' . $networkAuthId . '" onclick="addTag(\'' . $networkAuthId . '\');" ></span>';
        $tags .= '</div>';
        $tags .= '</div>';
        $tags .= '</div>';

        return $tags;
    }

    private function getShippingTimeHtml($networkAuthId, $networkTyp, $networkId) {
        //$shipping = '<div class="b2s-post-item-details-release-choose">' . __('Schedule Publication', 'blog2social') . '</div>';
        $shipping = '<br>';
        $shipping .= '<select name="b2s[' . $networkAuthId . '][releaseSelect]" data-user-version="' . B2S_PLUGIN_USER_VERSION . '" data-network-type="' . $networkTyp . '" data-network-id="' . $networkId . '" data-network-auth-id="' . $networkAuthId . '" class="form-control b2s-select b2s-post-item-details-release-input-date-select ' . (B2S_PLUGIN_USER_VERSION == 0 ? 'b2s-post-item-details-release-input-date-select-reset' : '') . '" >';
        $shipping .= '<option value="0" selected="selected">' . __('Share Now', 'blog2social') . '</option>';

        $shipping .= '<option value="1">' . __('Schedule post once', 'blog2social') . '</option>';
        if ($networkTyp != 2 && !in_array($networkId, $this->noScheduleRegularly)) {
            $shipping .= '<option value="2">' . __('Schedule post recurrently', 'blog2social') . '</option>';
        }

        $shipping .= '</select>';

        if (B2S_PLUGIN_USER_VERSION > 0) {
            $shipping .= '<div class="b2s-post-item-details-release-area-details">';
            $shipping .= '<ul class="list-group b2s-post-item-details-release-area-details-ul" data-network-auth-id="' . $networkAuthId . '" style="display:none;">';
            $shipping .= '<li class="list-group-item">';

            //Sched post
            $time = time();
            if (trim(strtolower($this->postStatus)) == 'future') {
                $time = strtotime($this->postData->post_date);
            }
            if (date('H') == '23' && date('i') >= 30) {
                $time = strtotime('+ 1 days');
            }
            $currentDate = (substr(B2S_LANGUAGE, 0, 2) == 'de') ? date('d.m.Y', $time) : date('Y-m-d', $time);

            for ($schedcount = 0; $schedcount < $this->maxSchedCount; $schedcount++) {
                $shipping .= '<div class="form-group b2s-post-item-details-releas-area-details-row" data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '" style="display:none">';
                $shipping .= $schedcount != 0 ? '<div class="clearfix"></div><hr class="b2s-hr-small">' : '';

                $shipping .= '<label class="col-xs-2 del-padding-left b2s-post-item-details-release-area-label-duration" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '">' . __('Duration', 'blog2social') . '</label>';
                $shipping .= '<label class="col-xs-2 del-padding-left b2s-post-item-details-release-area-label-date" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '">' . __('Date', 'blog2social') . '</label>';
                $shipping .= '<label class="col-xs-2 del-padding-left b2s-post-item-details-release-area-label-time" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '">' . __('Time', 'blog2social') . '</label>';
                $shipping .= '<label class="col-xs-6 del-padding-left b2s-post-item-details-release-area-label-day" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '">' . __('Days', 'blog2social') . '</label>';

                $shipping .= '<div class="clearfix"></div>';

                if ($networkTyp != 2 && !in_array($networkId, $this->noScheduleRegularly)) {
                    $shipping .= '<div class="col-xs-2 del-padding-left b2s-post-item-details-release-area-div-duration" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '"><select name="b2s[' . $networkAuthId . '][weeks][' . $schedcount . ']" class="form-control b2s-select b2s-post-item-details-release-input-weeks" data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '" style="display:none;" disabled="disabled">';
                    $defaultWeek = isset($this->defaultScheduleTime[$networkId][$schedcount]['weeks']) ? $this->defaultScheduleTime[$networkId][$schedcount]['weeks'] : 1;
                    for ($i = 1; $i <= $this->maxWeekTimeSelect; $i++) {
                        $weekName = ($i == 1) ? __('Week', 'blog2social') : __('Weeks', 'blog2social');
                        $shipping .= '<option value="' . $i . '" ' . ($defaultWeek == $i ? 'selected="selected"' : '') . '>' . $i . ' ' . $weekName . '</option>';
                    }
                    $shipping .= '</select></div>';
                }
                $shipping .= '<div class="col-xs-2 del-padding-left b2s-post-item-details-release-area-label-date" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '"><input type="text" placeholder="' . __('Date', 'blog2social') . '" name="b2s[' . $networkAuthId . '][date][' . $schedcount . ']" data-network-id="' . $networkId . '" data-network-type="' . $networkTyp . '" data-network-count="' . $schedcount . '" data-network-auth-id="' . $networkAuthId . '"  class="b2s-post-item-details-release-input-date form-control" style="display:none;"  disabled="disabled" readonly value="' . $currentDate . '"></div>';
                $shipping .= '<div class="col-xs-2 del-padding-left b2s-post-item-details-release-area-label-time" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '"><input type="text" placeholder="' . __('Time', 'blog2social') . '" name="b2s[' . $networkAuthId . '][time][' . $schedcount . ']" data-network-id="' . $networkId . '" data-network-type="' . $networkTyp . '" data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '"  class="b2s-post-item-details-release-input-time form-control" style="display:none;" disabled="disabled" readonly value=""></div>';
                $shipping .= '<div class="col-xs-5 del-padding-left b2s-post-item-details-release-area-label-day" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '">';
                if ($networkTyp != 2 && !in_array($networkId, $this->noScheduleRegularly)) {
                    $shipping .= '<div class="b2s-post-item-details-release-input-daySelect" data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '"  style="display:none;">';
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-mo" type="checkbox" name="b2s[' . $networkAuthId . '][mo][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-mo" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-mo" class="b2s-post-item-details-release-input-lable-day">' . __('Mon', 'blog2social') . '</label>'; //MO
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-di" type="checkbox" name="b2s[' . $networkAuthId . '][di][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-di" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-di" class="b2s-post-item-details-release-input-lable-day">' . __('Tue', 'blog2social') . '</label>'; //Di
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-mi" type="checkbox" name="b2s[' . $networkAuthId . '][mi][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-mi" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-mi" class="b2s-post-item-details-release-input-lable-day">' . __('Wed', 'blog2social') . '</label>'; //Mi
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-do" type="checkbox" name="b2s[' . $networkAuthId . '][do][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-do" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-do" class="b2s-post-item-details-release-input-lable-day">' . __('Thu', 'blog2social') . '</label>'; //Do
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-fr" type="checkbox" name="b2s[' . $networkAuthId . '][fr][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-fr" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-fr" class="b2s-post-item-details-release-input-lable-day">' . __('Fri', 'blog2social') . '</label>'; //Fr
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-sa" type="checkbox" name="b2s[' . $networkAuthId . '][sa][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-sa" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-sa" class="b2s-post-item-details-release-input-lable-day">' . __('Sat', 'blog2social') . '</label>'; //Sa
                    $shipping .= '<input id="b2s-' . $networkAuthId . '-' . $schedcount . '-so" type="checkbox" name="b2s[' . $networkAuthId . '][so][' . $schedcount . ']" data-network-auth-id="' . $networkAuthId . '" data-network-count="' . $schedcount . '" class="form-control b2s-post-item-details-release-input-days b2s-post-item-details-release-input-lable-day-so" value="1" disabled="disabled"><label for="b2s-' . $networkAuthId . '-' . $schedcount . '-so" class="b2s-post-item-details-release-input-lable-day">' . __('Sun', 'blog2social') . '</label>'; //So
                    $shipping .= '</div>';
                }
                $shipping .= '</div>';
                $shipping .= '<div class="col-xs-2 del-padding-left">';
                $shipping .= ( $schedcount >= 1) ? '<button class="btn btn-link b2s-post-item-details-release-input-hide"  data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '" data-network-count="1" style="display:none;">-' . __('delete', 'blog2social') . '</button>' : '';
                $shipping .= $schedcount < $this->maxSchedCount - 1 ? '<button class="btn btn-link b2s-post-item-details-release-input-add"  data-network-count="' . $schedcount . '"  data-network-auth-id="' . $networkAuthId . '" data-network-count="1" style="display:none;">+' . __('Add Posting Time', 'blog2social') . '</button>' : '';
                $shipping .= '</div>';
                $shipping .= '</div>';
            }
            $shipping .= '<div class="col-xs-12">';
            $shipping .= '<button class="btn btn-sm btn-link pull-right b2s-post-item-details-release-area-sched-for-all" data-network-auth-id="' . $networkAuthId . '">' . __('Apply Settings To All Networks', 'blog2social') . '</button>';
            $shipping .= '<label class="pull-right btn btn-link btn-sm b2s-post-item-details-release-save-settings-label" data-network-auth-id="' . $networkAuthId . '"><input class="b2s-post-item-details-release-save-settings" data-network-auth-id="' . $networkAuthId . '" type="checkbox" name="b2s[' . $networkAuthId . '][saveSchedSetting]" value="1" disabled="disabled">' . __('Save Settings As Default', 'blog2social') . '</label>';
            $shipping .= '</div><div class="clearfix"></div>';
            $shipping .= '</li>';
            $shipping .= '</ul>';
            $shipping .= '</div>';
        }
        return $shipping;
    }

}

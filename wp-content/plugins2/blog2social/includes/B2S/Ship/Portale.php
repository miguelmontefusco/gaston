<?php

class B2S_Ship_Portale {

    private $authurl;
    private $allowProfil;
    private $allowPage;
    private $allowGroup;
    private $oAuthPortal;

    public function __construct() {
        $this->authurl = B2S_PLUGIN_API_ENDPOINT_AUTH . '?b2s_token=' . B2S_PLUGIN_TOKEN . '&sprache=' . substr(B2S_LANGUAGE, 0, 2);
        $this->allowProfil = unserialize(B2S_PLUGIN_NETWORK_ALLOW_PROFILE);
        $this->allowPage = unserialize(B2S_PLUGIN_NETWORK_ALLOW_PAGE);
        $this->allowGroup = unserialize(B2S_PLUGIN_NETWORK_ALLOW_GROUP);
        $this->oAuthPortal = unserialize(B2S_PLUGIN_NETWORK_OAUTH);
    }

    public function getItemHtml($portale) {
        $html = '<ul>';
        foreach ($portale as $k => $portal) {
            $html .= '<li>';
            $html .= '<img class="b2s-network-list-add-thumb" alt="' . $portal->name . '" src="' . plugins_url('/assets/images/portale/' . $portal->id . '_flat.png', B2S_PLUGIN_FILE) . '">';
            $html .= '<span class="b2s-network-list-add-details">' . $portal->name . '</span>';

            $b2sAuthUrl = $this->authurl . '&portal_id=' . $portal->id . '&transfer=' . (in_array($portal->id, $this->oAuthPortal) ? 'oauth' : 'form' ) . '&version=3';
            if (in_array($portal->id, $this->allowGroup)) {
                $html .= (B2S_PLUGIN_USER_VERSION > 0) ? ('<button onclick="wop(\'' . $b2sAuthUrl . '&choose=group\', \'Blog2Social Network\'); return false;" class="btn btn-primary btn-sm b2s-network-list-add-btn">') : '<button type="button" class="btn btn-primary btn-sm b2s-network-list-add-btn b2s-network-list-add-btn-profeature" data-title="'.__('You want to connect a social media group?','blog2social').'" data-toggle="modal" data-target="#b2sProFeatureModal">';
                $html .= '+ ' . __('Group', 'blog2social') . '</button>';
            }
            if (in_array($portal->id, $this->allowPage)) {
                $html .= (B2S_PLUGIN_USER_VERSION > 0 || $portal->id == 1) ? ('<button onclick="wop(\'' . $b2sAuthUrl . '&choose=page\', \'Blog2Social Network\'); return false;" class="btn btn-primary btn-sm b2s-network-list-add-btn">') : '<button type="button" class="btn btn-primary btn-sm b2s-network-list-add-btn b2s-network-list-add-btn-profeature" data-title="'.__('You want to connect a network page?','blog2social').'" data-toggle="modal" data-target="#b2sProFeatureModal">';
                $html .= '+ ' . __('Page', 'blog2social') . '</button>';
            }
            $html .= in_array($portal->id, $this->allowProfil) ? ('<a href="#" onclick="wop(\'' . $b2sAuthUrl . '&choose=profile\', \'Blog2Social Network\'); return false;" class="btn btn-primary btn-sm b2s-network-list-add-btn">+ ' . __('Profile', 'blog2social') . '</a>') : '';

            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

}

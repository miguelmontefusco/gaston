<?php

class PRG_Post_Filter {

    public $type;
    protected $postFilter = '';
    protected $searchAuthorId;
    protected $searchPostType;
    protected $searchPostTitle;
    protected $searchPublishDate;
    protected $searchSchedDate;
    protected $postAuthor;

    function __construct($type, $title = "", $authorId = "", $postType = "", $publishDate = "", $schedDate = "") {  //type=all,publish,sched
        $this->type = $type;
        $this->searchPostTitle = $title;
        $this->searchAuthorId = $authorId;
        $this->searchPostType = $postType;
        $this->searchPublishDate = $publishDate;
        $this->searchSchedDate = $schedDate;
    }

    public function getAutorData() {
        global $wpdb;
        $sqlAuthors = "SELECT `ID`,`display_name` FROM `$wpdb->users`";
        $this->postAuthor = $wpdb->get_results($sqlAuthors);
    }

    private function getAutorHtml() {
        $autor = '<div class="form-group"><select name="prgSortPostAuthor" class="form-control b2s-select"><option value="">'. __('All Authors', 'blog2social').'</option>';
        foreach ($this->postAuthor as $var) {
            $selected = (!empty($this->searchAuthorId) && $var->ID == (int) $this->searchAuthorId) ? 'selected' : '';
            $autor.='<option ' . $selected . ' value="' . $var->ID . '">' . $var->display_name . '</option>';
        }
        $autor.='</select></div>';
        return $autor;
    }

    private function getPostTypeHtml() {
       $typeData = array(array('key' => 'publish', 'value' =>  __('published', 'blog2social')), array('key' => 'future', 'value' =>  __('scheduled', 'blog2social')), array('key' => 'pending', 'value' =>  __('draft', 'blog2social')));
       $type = '<div class="form-group"><select name="prgSortPostType" class="form-control b2s-select"><option value="">'. __('All Types', 'blog2social').'</option>';
        foreach ($typeData as $var) {
            $var = (object) $var;
            $selected = (!empty($this->searchPostType) && $var->key == $this->searchPostType) ? 'selected' : '';
            $type.='<option ' . $selected . ' value="' . $var->key . '">' . $var->value . '</option>';
        }
        $type .='</select></div>';
        return $type;
    }

    public function getItemHtml() {
        $this->getAutorData();
        $this->postFilter .= '<div class="form-group">
                                    <input id="pref-search" name="prgSortPostTitle" maxlength="30" class="form-control input-sm" value="' . (empty($this->searchPostTitle) ? '' : $this->searchPostTitle) . '" placeholder="' . (empty($this->searchPostTitle) ?  __('Search Title', 'blog2social') : '') . '" type="text">
                             </div>';
        if (B2S_PLUGIN_ADMIN) {
            $this->postFilter .=$this->getAutorHtml();
        }
        if ($this->type == 'all') {
            $this->postFilter .= $this->getPostTypeHtml();
        }
        
        $this->postFilter .='<div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="submit">'. __('sort', 'blog2social').'</button>
                                    <a class="btn btn-primary btn-sm" href="admin.php?page=prg-post">'. __('reset', 'blog2social').'</a>
                             </div>';


        return $this->postFilter;
    }

}

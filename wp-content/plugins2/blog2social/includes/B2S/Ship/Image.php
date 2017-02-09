<?php

class B2S_Ship_Image {

    public $isImage;

    public function __construct() {
        
    }

    private function getAllImageData($id) {
        return B2S_Util::getImagesByPostID($id, true);
    }

    public function getItemHtml($id) {
        $imageData = $this->getAllImageData($id);
        $isImage = (is_array($imageData) && !empty($imageData)) ? true : false;

        if ($isImage) {
            $content = '<h4>' . __('Select Image', 'blog2social') . '<span class="b2s-no-image-area"><input class="selectNoNetworkImage" type="checkbox" id="no_image_url" name="no_image_url" value="no_image_url"><label class="b2s-no-image-area-text" for="no_image_url">' . __('Post no image', 'blog2social') . '</label></span></h4>';
            $content.='<div class="b2s-image-size-info"><i>'.__('The best size for images in social media posts are between: 667-1000px x 523-1000px <br>Blog2Social will automatically resize your image according to network requirements.', 'blog2social').'</i></div><br>';
            $content .= '<div class="b2s-image-warning-no-image alert alert-info" style="display:none;">' . __('On Pinterest, Flickr and Instagram may be published with a image.', 'blog2social') . '</div>';

            $tempCountImage = 0;
            foreach ($imageData as $key => $image) {
                $checked = (($tempCountImage == 0) ? "checked" : "");
                $content .='<div class="b2s-image-item">';
                $content .='<div class="b2s-image-item-thumb">';
                $content .='<label for="bs2-image-count-' . $tempCountImage . '">';
                $content .='<img class="img-thumbnail networkImage" alt="blogImage" src="' . $image[0] . '">';
                $content .= '</label>';
                $content .='</div>';
                $content .='<div class="b2s-image-item-caption text-center">';
                $content .='<div class="b2s-image-item-caption-resolution clearfix small"></div>';
                $content .= '<input type="radio" value="' . $image[0] . '" class="checkNetworkImage" name="image_url" id="bs2-image-count-' . $tempCountImage . '" '.$checked.'>';
                $content .= '</div>';
                $content .= '</div>';
                $tempCountImage++;
            }
        } else {
            $content = '<h4>' . __('Images not found', 'blog2social') . '</h4>';
            $content .= '<div class="b2s-image-warning-no-image alert alert-info">' . __('Pinterest, Flickr and Instagram can only be shared with a image included', 'blog2social') . '</div>';
        }
        $content .= "<input type='hidden' id='blog_image' name='blog_image' value='" . trim($isImage) . "'>";

        return $content;
    }

}

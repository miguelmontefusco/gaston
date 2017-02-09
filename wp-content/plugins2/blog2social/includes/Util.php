<?php

class B2S_Util {

    public static function getUTCForDate($date, $userTimezone) {
        $utcTime = strtotime($date) + ($userTimezone * 3600);
        return date('Y-m-d H:i:s', $utcTime);
    }

    public static function getCustomDateFormat($dateTime = '0000-00-00 00:00:00', $lang = 'de') {
        if ($lang == 'de') {
            $ident = 'd.m.Y H:i';
            return date($ident, strtotime($dateTime)) . ' Uhr';
        } else {
            $ident = 'Y/m/d g:i a';
            return date($ident, strtotime($dateTime));
        }
    }

    public static function getTrialRemainingDays($trialEndDate = '', $timeZone = 'Europe/Berlin') {
        if (!empty($trialEndDate)) {
            $trailDateUtc = new DateTime($trialEndDate);
            $timeZone = empty($timeZone) ? 'Europe/Berlin' : $timeZone;
            $trailDateUtc->setTimezone(new DateTimeZone($timeZone));
            $isTrial = $trailDateUtc->format('Y-m-d H:i:s');

            $differTime = strtotime($isTrial) - time();
            if ((int) $differTime >= 0) {
                return (int) ($differTime / 86400);
            }
            return 0;
        }
        return false;
    }

    public static function getMetaTags($postId = 0, $postUrl = '', $network = 1) {

        //GETSTOREEDDATA
        if ((int) $postId != 0) {
            $metaData = get_option('B2S_PLUGIN_POST_META_TAGES_' . $postId);
            if ($metaData !== false && is_array($metaData)) {
                return $metaData;
            }
        }

        //GETDATA
        $getTags = array('title', 'description', 'image');
        $param = array();
        libxml_use_internal_errors(true); // Yeah if you are so worried about using @ with warnings
        $html = self::b2sFileGetContents($postUrl);
        if (!empty($html) && $html !== false) {
            //if ($network == 1) { //FB
            //Serach frist OG Parameter
            $temp = self::b2sGetAllTags($html, 'og');
            foreach ($getTags as $k => $v) {
                if (isset($temp[$v]) && !empty($temp[$v])) {
                    $param[$v] = $temp[$v];
                } else {
                    if ($v == 'title') {
                        if (function_exists('mb_convert_encoding')) {
                            $param[$v] = htmlspecialchars(self::b2sGetMetaTitle($html));
                        } else {
                            $param[$v] = self::b2sGetMetaTitle($html);
                        }
                    }
                    if ($v == 'description') {
                        if (function_exists('mb_convert_encoding')) {
                            $param[$v] = htmlspecialchars(self::b2sGetMetaDescription($html));
                        } else {
                            $param[$v] = self::b2sGetMetaDescription($html);
                        }
                    }
                }
                //}
            }
            //STOREDATA
            if ((int) $postId != 0) {
                update_option('B2S_PLUGIN_POST_META_TAGES_' . $postId, $param);
            }
            return $param;
        }
        return false;
    }

    private static function b2sFileGetContents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:5.0) Gecko/20100101 Firefox/5.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = self::b2sCurlExecFollow($ch);
        curl_close($ch);
        return $data;
    }

    private static function b2sCurlExecFollow($ch, $maxredirect = 5) {
        $b2sSafeMode = ini_get('safe_mode');
        $b2sOpenBaseDir = ini_get('open_basedir');
        if ((empty($b2sOpenBaseDir) || $b2sOpenBaseDir == " ") && (filter_var($b2sSafeMode, FILTER_VALIDATE_BOOLEAN) === false) || strtolower($b2sSafeMode) == "off") {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            if ($maxredirect > 0) {
                $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                $newurl = $original_url;
                $rch = curl_copy_handle($ch);
                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                do {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if ((int) $code == 301) {
                            preg_match('/Location:(.*?)\n/i', $header, $matches);
                            $newurl = trim(array_pop($matches));
                            if (!preg_match("/^https?:/i", $newurl)) {
                                $newurl = $original_url . $newurl;
                            }
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$maxredirect);

                curl_close($rch);

                if (!$maxredirect) {
                    if ($maxredirect === null) {
                        return false; //Too many redirects
                    } else {
                        $maxredirect = 0;
                    }
                    return false;
                }
                curl_setopt($ch, CURLOPT_URL, $newurl);
            }
        }
        return curl_exec($ch);
    }

    private static function b2sGetMetaDescription($html) {
        //$res = get_meta_tags($url);
        //return (isset($res['description']) ? self::cleanContent(strip_shortcodes($res['description'])) : '');
        $res = preg_match('#<meta +name *=[\"\']?description[\"\']?[^>]*content=[\"\']?(.*?)[\"\']? */?>#i', $html, $matches);
        return (isset($matches[1]) && !empty($matches[1])) ? trim(preg_replace('/\s+/', ' ', $matches[1])) : '';
    }

    private static function b2sGetMetaTitle($html) {
        $res = preg_match("/<title>(.*)<\/title>/siU", $html, $matches);
        return (isset($matches[1]) && !empty($matches[1])) ? trim(preg_replace('/\s+/', ' ', $matches[1])) : '';
    }

    private static function b2sGetAllTags($html, $type = 'og') {
        $list = array();
        @libxml_use_internal_errors(true);
        $dom = new DomDocument();
        if (function_exists('mb_convert_encoding')) {
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        } else {
            $dom->loadHTML();
        }
        $xpath = new DOMXPath($dom);
        $query = '//*/meta[starts-with(@property, \'' . $type . ':\')]';
        $result = $xpath->query($query);
        foreach ($result as $meta) {
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            $property = str_replace($type . ':', '', $property);
            if ($property == 'description') {
                $content = self::cleanContent(strip_shortcodes($content));
            }
            $list[$property] = (function_exists('mb_convert_encoding') ? htmlspecialchars($content) : $content );
        }
        return $list;
    }

    public static function getImagesByPostId($postId = 0, $network = false) {
        $homeUrl = get_site_url(); //parse_url(get_site_url(), PHP_URL_HOST);
        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($postId));
        $page_data = get_page($postId);
        $matches = array();
        if (!preg_match_all('%<img.*?src="(.*?)".*?>%', $page_data->post_content, $matches) && !$featuredImage) {
            return false;
        }
        array_unshift($matches[1], $featuredImage);
        $rtrnArray = array();
        foreach ($matches[1] as $key => $imgUrl) {
            if ($imgUrl == false) {
                continue;
            }

            //AllowedExtensions?
            if (!$network && !in_array(substr($imgUrl, strrpos($imgUrl, '.')), array('.jpg', '.png'))) {
                continue;
            }

            //isRelativ?
            if (!preg_match('/((http|https):\/\/|(www.))/', $imgUrl)) {
                $imgUrl = (substr($imgUrl, 0, 1) != '/') ? '/' . $imgUrl : $imgUrl;
                $imgUrl = str_replace('//', '/', $imgUrl);
                $imgUrl = $homeUrl . $imgUrl;
                if (strpos($imgUrl, 'http://') === false && strpos($imgUrl, 'https://') === false) {
                    $imgUrl = 'http://' . $imgUrl;
                }
            }

            /* $file_headers = @get_headers($imgUrl);
              if ((!is_array($file_headers)) || (is_array($file_headers) && !preg_match('/200/', $file_headers[0]))) {
              continue;
              } */

            $rtrnArray[$key][0] = $imgUrl;
        }
        return $rtrnArray;
    }

    public static function prepareContent($content = '', $allowHtml = '<p><h1><h2><br><i><b><a><img>') {
        $homeUrl = get_site_url(); //parse_url(get_site_url(), PHP_URL_HOST);    
        $content = html_entity_decode($content, ENT_COMPAT, 'UTF-8');
        $prepareContent = (empty($allowHtml)) ? self::cleanContent(strip_shortcodes($content)) : self::cleanContent(self::cleanHtmlAttr(strip_shortcodes(self::cleanShortCodeByCaption($content))));
        $prepareContent = preg_replace('/(?:[ \t]*(?:\n|\r\n?)){3,}/', "\n\n", $prepareContent);
        if ($allowHtml != false) {
            $tempContent = nl2br(trim(strip_tags($prepareContent, $allowHtml)));
            if (preg_match_all('%<img.*?src="(.*?)".*?/>%', $tempContent, $matches)) {
                foreach ($matches[1] as $key => $imgUrl) {
                    if ($imgUrl == false) {
                        continue;
                    }
                    //Relative?
                    if (!preg_match('/((http|https):\/\/|(www.))/', $imgUrl)) {
                        $tempImgUrl = (substr($imgUrl, 0, 1) != '/') ? '/' . $imgUrl : $imgUrl;
                        $tempImgUrl = str_replace('//', '/', $tempImgUrl);
                        $tempImgUrl = $homeUrl . $tempImgUrl;
                        if (strpos($tempImgUrl, 'http://') === false && strpos($imgUrl, 'https://') === false) {
                            $tempImgUrl = 'http://' . $tempImgUrl;
                        }
                        $tempContent = str_replace(trim($imgUrl), $tempImgUrl, $tempContent);
                    }
                }
            }
            return $tempContent;
        }
        return trim(strip_tags($prepareContent));
    }

    public static function cleanHtmlAttr($content) {
        $content = preg_replace('/(<[^>]+) style=[\"\'].*?[\"\']/i', '$1', $content);
        $content = preg_replace('/(<[^>]+) class=[\"\'].*?[\"\']/i', '$1', $content);
        $content = preg_replace('/(<[^>]+) height=[\"\'].*?[\"\']/i', '$1', $content);
        $content = preg_replace('/(<[^>]+) width=[\"\'].*?[\"\']/i', '$1', $content);
        return preg_replace('/(<[^>]+) id=[\"\'].*?[\"\']/i', '$1', $content);
    }

    public static function cleanContent($content) {
        return preg_replace('/\[.*?(?=\])\]/s', '', $content);
    }

    public static function cleanShortCodeByCaption($content) {
        preg_match_all('#\s*\[caption[^]]*\].*?\[/caption\]\s*#is', $content, $matches);
        if (isset($matches[0]) && !empty($matches[0]) && is_array($matches[0])) {
            $temp = '';
            foreach ($matches[0] as $k => $v) {
                $temp = $v;
                if (preg_match('/< *img[^>]+\>/i', $v, $match)) {
                    $v = (isset($match[0])) ? str_replace($match[0], $match[0] . "\n\n", $v) : $v;
                    $t = preg_replace('#\s*\[/caption\]\s*#is', "\n\n", $v);
                    $new = preg_replace('#\s*\[caption[^]]*\]\s*#is', '', $t);
                    $content = str_replace($temp, "\n" . $new, $content);
                }
            }
        }
        return $content;
    }

    public static function getRandomTime($start, $ende) {
        $startparts = explode(':', $start);
        $startH = $startparts[0];
        $startMin = strlen($startparts[1]) == 1 ? '0' . $startparts[1] : $startparts[1];
        $endparts = explode(':', $ende);
        $endH = $endparts[0];
        $endMin = strlen($endparts[1]) == 1 ? '0' . $endparts[1] : $endparts[1];

        $rand = rand((int) ($startH . $startMin), (int) ($endH . $endMin));
        if ($rand == NULL) {
            return date('H:00');
        }
        if (strlen($rand) == 3) {
            $rand = '0' . $rand;
        }
        $hour = substr($rand, 0, 2);
        $miunte = substr($rand, 2, 2);
        $minute = $miunte > 50 ? '30' : '00';

        return $hour . ':' . $minute;
    }

    public static function getTimeByLang($time, $lang = 'de') {
        $time = substr('0' . $time, -2);
        $slug = ($lang == 'en') ? 'h:i a' : 'H:i';
        return date($slug, strtotime(date('Y-m-d ' . $time . ':00:00')));
    }

    public static function getExcerpt($text, $count = 400, $add = false) {
        //Bug: Converting json + PHP Extension
        if (function_exists('mb_strlen') && function_exists('mb_substr')) {
            if (mb_strlen($text, 'UTF-8') < $count) {
                return trim($text);
            }
            $stops = array('.', ';', ':', ',', ' ');
            $min = (int) $count / 2;
            $sub = mb_substr($text, $min, $min - 1,'UTF-8');
            for ($i = 0; $i < count($stops); $i++) {
                if (count($subArray = explode($stops[$i], $sub)) > 1) {
                    $subArray[count($subArray) - 1] = ' ';
                    $sub = implode($stops[$i], $subArray);
                    break;
                }
            }
            $text = trim(mb_substr($text, 0, $min,'UTF-8') . $sub);
            return ($add) ? $text . "..." : $text;
        }
        return trim($text);
    }

}

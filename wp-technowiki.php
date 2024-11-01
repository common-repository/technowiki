<?php
/*
Plugin Name: WP-Technowiki
Plugin URI: http://polishwords.wikidot.com/
Description: Wtyczka, która umieszcza w postach linki do artykułów o osobach znanych w branży IT znajdujących się na Polskiej Wiki Technologicznej.
Author: Tomasz Smykowski
Version: 1.1
Author URI: http://www.polishwords.com.pl

Copyright 2009-2009 Tomasz Smykowski

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function technowikinguj($text)
{

       $adres = "http://polishwords.com.pl/api/wp-technowiki-api.php";

        $xml = file_get_contents($adres);

        preg_match_all( "/\<matcho\>(.*?)\<\/matcho\>/s", $xml, $bookblocks );
        
        foreach( $bookblocks[1] as $block )
        {
            preg_match_all( "/<matchoName>(.*?)\<\/matchoName>/",  $block, $name );
            preg_match_all( "/<linkatoros>(.*?)\<\/linkatoros>/",  $block, $link );

            $namess = html_entity_decode($name[1][0], ENT_QUOTES);
            $linkss = html_entity_decode($link[1][0], ENT_QUOTES);
            
            //echo $namess;
            
            $text = str_replace($namess, "<a href='$linkss' rel='nofollow' title='$namess na Polishwords WIKI'>$namess</a>", $text);
        }
        
      return $text;   
}

add_filter("the_content", "technowikinguj");

?>
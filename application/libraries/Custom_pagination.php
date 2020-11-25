<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class Custom_pagination {

	var $base_url			= ''; // The page we are linking to
	var $prefix				= ''; // A custom prefix added to the path.
	var $suffix				= ''; // A custom suffix added to the path.

	var $total_rows			=  0; // Total number of items (database results)
	var $per_page			= 10; // Max number of items you want shown per page
	var $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page			=  0; // The current page being viewed
	var $use_page_numbers	= FALSE; // Use page number for segment instead of offset
	var $first_link			= '&lsaquo; First';
	var $next_link			= '&gt;';
	var $prev_link			= '&lt;';
	var $last_link			= 'Last &rsaquo;';
	var $uri_segment		= 3;
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';
	var $first_url			= ''; // Alternative URL for the First Page.
	var $cur_tag_open		= '&nbsp;<strong>';
	var $cur_tag_close		= '</strong>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '';
	var $page_query_string	= FALSE;
	var $query_string_segment = 'per_page';
	var $display_pages		= TRUE;
	var $anchor_class		= '';
	var $cur_page_giv		= '';
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */
    function create_links($reload, $page, $tpages){
            $adjacents = 2;
            $prevlabel = "&lsaquo; Prev";
            $nextlabel = "Next &rsaquo;";
            $out = "";
            // previous
            if ($page == 1) {
                $out.= "<span>" . $prevlabel . "</span>\n";
            } elseif ($page == 2) {
                $out.= "<li><a id=\"". ($page-1) . "\">" . $prevlabel . "</a>\n</li>";
            } else {
                $out.= "<li><a id=\"". ($page-1) . "\">" . $prevlabel . "</a>\n</li>";
            }

            $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
            $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
            for ($i = $pmin; $i <= $pmax; $i++) {
                if ($i == $page) {
                    $out.= "<li  class=\"active\"><a>" . $i . "</a> </li>\n";
                } elseif ($i == 1) {
                    $out.= "<li><a id=\"" . $i . "\">" . $i . "</a>\n</li>";
                } else {
                    $out.= "<li><a id=\"" . $i . "\">" . $i . "</a>\n</li>";
                }
            }

            if ($page < ($tpages - $adjacents)) {
                $out.= "<li><a id=\"". (int)$tpages . "\" style='font-size:11px'>" . (int)$tpages . "</a></a>\n";
            }
            // next
            if ($page < $tpages) {
                $out.= "<li><a  id=\"". ($page+1) . "\" >" . $nextlabel . "</a>\n</li>";
            } else {
                $out.= "<span style='font-size:11px'>" . $nextlabel . "</span>\n";
            }
            $out.= "";
            return $out;
    }
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */
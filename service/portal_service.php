<?php
/**
 * @package phpBB Extension - Portal
 * @copyright (c) Geert Eltink
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace xtreamwayz\portal\service;

use Nickvergessen\TrimMessage\TrimMessage;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\user;

/**
 * Portal Service Class
 */
class portal_service
{
    /**
     * @var driver_interface
     */
    protected $db;

    /**
     * @var user
     */
    protected $user;

    /**
     * @var auth
     */
    protected $auth;

    /**
     * @var string phpBB root path
     */
    protected $root_path;

    /**
     * @var string PHP extension
     */
    protected $php_ext;

    protected $news_forum_id = 3;

    protected $news_limit = 5;

    /**
     * @param driver_interface $db
     * @param user $user
     * @param auth $auth
     * @param $root_path
     * @param $php_ext
     */
    public function __construct(driver_interface $db, user $user, auth $auth, $root_path, $php_ext)
    {
        $this->db        = $db;
        $this->user      = $user;
        $this->auth      = $auth;
        $this->root_path = $root_path;
        $this->php_ext   = $php_ext;
    }

    public function get_news()
    {
        // Construct the query
        $search_ary = array(
            'SELECT'    => 'p.*, t.*',
            'FROM'      => array(
                POSTS_TABLE => 'p',
            ),
            'LEFT_JOIN' => array(
                array(
                    'FROM'  => array(TOPICS_TABLE => 't'),
                    'ON'    => 't.topic_first_post_id = p.post_id'
                )
            ),
            'WHERE'     => 'p.forum_id = ' . (int) $this->news_forum_id . '
                        AND t.topic_status <> ' . ITEM_MOVED,
            'ORDER_BY'  => 'p.post_id DESC',
        );

        // Build query
        $posts = $this->db->sql_build_query('SELECT', $search_ary);
        // Execute query
        $result = $this->db->sql_query_limit($posts, $this->news_limit);

        // Build the news array
        $news_array = array();
        while($row = $this->db->sql_fetchrow($result)) {
            $topic_id = $row['topic_id'];
            $post_id = $row['post_id'];

            // Set bbcode parse flags
            $post_text_parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;

            // Truncate post text
            $trim = new TrimMessage($row['post_text'], $row['bbcode_uid'], 256, '...');
            $row['post_text'] = $trim->message();

            $news_array[] = array(
                'topic_id'      => $topic_id,
                'topic_url'     => append_sid("{$this->root_path}viewtopic.{$this->php_ext}", "t={$topic_id}"),
                'topic_title'   => censor_text($row['topic_title']),
                'topic_title_truncated' => truncate_string(
                    censor_text($row['topic_title']), 128, 255, false, $this->user->lang['ELLIPSIS']
                ),

                'post_id'       => $post_id,
                'post_time'     => $this->user->format_date($row['post_time']),
                'post_time_iso' => gmdate('c', $row['post_time']),
                'post_day'      => $this->user->format_date($row['post_time'], 'd'),
                'post_month'    => $this->user->format_date($row['post_time'], 'M'),
                'post_url'      => append_sid("{$this->root_path}viewtopic.{$this->php_ext}", "p={$post_id}#p{$post_id}"),
                'post_title'    => ($row['post_subject']) ? censor_text($row['post_subject']) : censor_text($row['topic_title']),
                'post_title_truncated' => truncate_string(
                    censor_text($row['post_subject']), 128, 255, false, $this->user->lang['ELLIPSIS']
                ),
                'post_text'     => preg_replace('/<[^>]*>/', ' ', generate_text_for_display(
                    $row['post_text'],
                    $row['bbcode_uid'],
                    $row['bbcode_bitfield'],
                    $post_text_parse_flags,
                    true
                )),
            );
        }

        return $news_array;
    }
}

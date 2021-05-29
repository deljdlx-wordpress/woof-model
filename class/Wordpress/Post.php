<?php

namespace Woof\Model\Wordpress;

use Woof\Model\Wordpress\Manager\PostType;
use Woof\Model\Wordpress\Manager\Term;
use Woof\Model\Wordpress\Manager\User;
use Woof\Model\Wordpress\Entity\User as WordpressUser;
use Woof\Model\Wordpress\PostType as WordpressPostType;
use Woof\Model\Wordpress\Term as WordpressTerm;
use Woof\Model\Wordpress\Traits\Acf;

class Post extends Entity
{


    use Acf;


    // wordpress public properties
    public $ID;
    public $post_author;
    public $post_date;
    public $post_date_gmt;
    public $post_content;
    public $post_title;
    public $post_excerpt;
    public $post_status;
    public $comment_status;
    public $ping_status;
    public $post_password;
    public $post_name;
    public $to_ping;
    public $pinged;
    public $post_modified;
    public $post_modified_gmt;
    public $post_content_filtered;
    public $post_parent;
    public $guid;
    public $menu_order;
    public $post_type;
    public $post_mime_type;
    public $comment_count;
    public $filter;


    protected $author;
    protected $terms = null;

    /**
     * @var PostType
     */
    protected $postType = null;


    /**
     * @var PostMeta[]
     */
    protected $meta = null;


    /**
     * @param string $title
     * @return this
     */
    public function setTitle($title)
    {
        $this->post_title = $title;
        return $this;
    }


    public function getId()
    {
        return $this->ID;
    }

    public function getTitle()
    {
        return $this->post_title;
    }

    public function getStatus()
    {
        return $this->post_status;
    }

    public function getExcerpt()
    {
        return $this->post_excerpt;
    }

    public function getContent()
    {
        return $this->post_content;
    }

    public function getDate()
    {
        return $this->post_date;
    }

    public function getThumbnailURL($size = 'post-thumbnail')
    {
        return get_the_post_thumbnail_url($this->getId(), $size);
    }

    public function getURL()
    {
        return get_the_permalink($this->getId());
    }

    /**
     * @return WordpressUser
     */
    public function getAuthor()
    {
        if($this->author === null) {
            $this->author = User::getById($this->post_author);
        }
        return $this->author;
    }

    /**
     * @return PostMeta[]
     */
    public function getAllMeta()
    {
        if($this->meta === null) {

            $this->meta = [];
            $query = "
            SELECT
                post_id,
                post_type,
                meta_key,
                meta_value
            FROM
                wp_posts,
                wp_postmeta
            WHERE
            wp_posts.ID = wp_postmeta.post_id
            AND wp_posts.ID = %d
        ";

        $results = $this->wpdb->queryAndFetch(
            $query,
            [$this->getId()]
        );



        foreach($results as $values) {
            $this->meta[$values->meta_key] = new PostMeta($values->meta_key, $values->meta_value, $this);
        }
    }


        return $this->meta;
    }




    /**
     *
     * @return WordpressTerm[]
     */
    public function getTerms()
    {
        if($this->terms === null) {
            $this->terms = Term::getByPostId($this->getId());
        }
        return $this->terms;
    }

    /**
     *
     * @return WordpressPostType
     */
    public function getType()
    {

        if($this->postType === null) {
            $this->postType = PostType::getByPostId($this->getId());

            // $this->postType = PostType::getByName($this->post_type);
        }

        return $this->postType;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $data = [
            'ID' => 0,
            'post_author' => $this->post_author,
            'post_date' => $this->post_date,
            'post_date_gmt' => $this->post_date_gmt,
            'post_content' => $this->post_content,
            'post_title' => $this->post_title,
            'post_excerpt' => $this->post_excerpt,
            'post_status' => $this->post_status,
            'comment_status' => $this->comment_status,
            'ping_status' => $this->ping_status,
            'post_password' => $this->post_password,
            'post_name' => $this->post_name,
            'to_ping' => $this->to_ping,
            'pinged' => $this->pinged,
            'post_modified' => $this->post_modified,
            'post_modified_gmt' => $this->post_modified_gmt,
            'post_content_filtered' => $this->post_content_filtered,
            'post_parent' => $this->post_parent,
            'guid' => $this->guid,
            'menu_order' => $this->menu_order,
            'post_type' => $this->post_type,
            'post_mime_type' => $this->post_mime_type,
            'comment_count' => $this->comment_count,
        ];
        if($this->getID()) {
            $data['ID'] = $this->getID();
            wp_insert_post($data);
        }
        else {
            $id = wp_insert_post($data);
            $this->loadById($id);
        }
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function loadById($id)
    {
        $post = get_post($id);
        $this->loadFromWordpress($post);
        return $this;
    }


    // ==========================================================================
    public function getMetadata($name, $single = true)
    {
        return get_post_meta(
            $this->getId(),
            $name,
            $single
        );
    }

    // ==========================================================================

}


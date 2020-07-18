<?php

namespace App\Data;

use App\Lib\Database;

/**
 * Class ContentData
 * 
 * @package \App\Lib
 */
class ContentData extends Database
{
    public $contentId;

    public $sectionId;

    public $contentTitle;

    public $contentbody;

    public $featuredImageUrl = null;

    public $caption = null;

    public $buttonText = null;

    public $linkUrl = null;

    public $createdAt;

    public $createdBy;

    public $updatedAt;

    public $updatedBy;

    public $isActive = 1;

    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function setData(): bool
    {
        try {
            $this->db->pdo->beginTransaction();

            $this->db->insert('content', [
                'section_id' => $this->sectionId,
                'content_title' => $this->contentTitle,
                'content_body' => $this->contentBody,
                'featured_image_url' => $this->featuredImageUrl,
                'caption' => $this->caption,
                'button_text' => $this->buttonText,
                'link_url' => $this->linkUrl,
                'created_at' => $this->createdAt,
                'created_by' =>  date('Y-m-d H:i:s'),
                'is_active' => $this->isActive
            ]);

            $this->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->db->pdo->rollback();
        }

        return false;
    }
}
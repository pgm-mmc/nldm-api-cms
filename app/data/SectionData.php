<?php

namespace App\Data;

use App\Lib\Database;


/**
 * Class SectionData
 * 
 * @package \App\Data
 */
class SectionData extends Database
{
    public $sectionId;

    public $sectionCode;

    public $sectionDesc;

    public $sequence;

    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function setData(): bool
    {
        try {
            $this->db->pdo->beginTransaction();

            $this->db->insert('section', [
                'section_code' => $this->sectionCode,
                'section_desc' => $this->sectionDesc,
                'sequence' => $this->sequence
            ]);

            $this->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->db->pdo->rollback();
        }

        return false;
    }
}
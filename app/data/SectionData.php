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
        $this->db->insert('section', [
            'section_code' => $this->sectionCode,
            'section_desc' => $this->sectionDesc,
            'sequence' => $this->sequence
        ]);

        return true;
    }
}
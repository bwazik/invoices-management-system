<?php

namespace App\Interfaces\Sections;

interface SectionRepositoryInterface
{
    #1 Get All Sections
    public function getAllSections($request);

    #2 Add Section
    public function addSection($request);

    #3 Edit Section
    public function editSection($request);

    #4 Delete Section
    public function deleteSection($request);

    #5 Delete Selected Sections
    public function deleteSelectedSections($request);
}

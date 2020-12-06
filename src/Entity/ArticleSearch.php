<?php


namespace App\Entity;




class ArticleSearch
{
    /**
     * @var string|null
     */
    private $moduleSearched;
    /**
     * @var string|null
     */
    private $semestreSearched;

    /**
     * @var Filieres
     */
    private $filieresSearched;


    /**
     * @return string|null
     */
    public function getModuleSearched(): ?string
    {
        return $this->moduleSearched;
    }

    /**
     * @param string|null $moduleSearched
     */
    public function setModuleSearched(string $moduleSearched): void
    {
        $this->moduleSearched = $moduleSearched;
    }

    /**
     * @return string|null
     */
    public function getSemestreSearched(): ?string
    {
        return $this->semestreSearched;
    }

    /**
     * @param string|null $semestreSearched
     */
    public function setSemestreSearched(string $semestreSearched): void
    {
        $this->semestreSearched = $semestreSearched;
    }
    /**
     * @return Filieres|null
     */

    public function getFilieresSearched(): ?Filieres
    {
        return $this->filieresSearched;
    }
    /**
     * @param Filieres $filieresSearched
     */

    public function setFilieresSearched(Filieres $filieresSearched): void
    {
        $this->filieresSearched = $filieresSearched;
    }



}